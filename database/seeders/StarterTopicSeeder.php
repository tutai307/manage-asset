<?php

namespace Database\Seeders;

use App\Enums\TopicStatus;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Idempotent: safe to re-run against a database that already has the starter topics. AM-003.
 */
class StarterTopicSeeder extends Seeder
{
    private const EMOJI = [
        'greetings-introductions' => '👋',
        'family' => '👨‍👩‍👧',
        'school-classroom' => '🏫',
        'daily-routines' => '⏰',
        'hobbies-free-time' => '🎨',
        'food-ordering' => '🍜',
        'shopping' => '🛍️',
        'directions' => '🧭',
        'weather' => '🌦️',
        'health' => '🩺',
        'plans-invitations' => '🎉',
        'on-the-phone' => '📞',
    ];

    public function run(): void
    {
        $topics = require database_path('seeders/data/starter_topics.php');
        $englishText = require database_path('seeders/data/starter_topics_en.php');

        DB::transaction(function () use ($topics, $englishText) {
            foreach ($topics as $topicIndex => $data) {
                $en = $englishText[$data['slug']] ?? ['description_en' => null, 'scenarios' => []];

                $topic = Topic::updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'emoji' => self::EMOJI[$data['slug']] ?? null,
                        'title_en' => $data['title_en'],
                        'title_vi' => $data['title_vi'],
                        'description_vi' => $data['description_vi'],
                        'description_en' => $en['description_en'],
                        'status' => TopicStatus::Published,
                        'sort_order' => $topicIndex + 1,
                    ],
                );

                foreach ($data['patterns'] as $i => [$english, $vietnamese, $note]) {
                    $topic->sentencePatterns()->updateOrCreate(
                        ['english' => $english],
                        ['vietnamese' => $vietnamese, 'note_vi' => $note, 'sort_order' => $i + 1],
                    );
                }

                foreach ($data['scenarios'] as $i => $scenario) {
                    $topic->roleplayScenarios()->updateOrCreate(
                        ['title_en' => $scenario['title_en']],
                        [
                            ...$scenario,
                            'situation_en' => $en['scenarios'][$scenario['title_en']] ?? null,
                            'sort_order' => $i + 1,
                        ],
                    );
                }
            }
        });
    }
}
