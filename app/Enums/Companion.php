<?php

namespace App\Enums;

/**
 * The cartoon character that plays the AI side of a role-play. Original characters only.
 */
enum Companion: string
{
    case Miu = 'miu';
    case Robo = 'robo';
    case Dino = 'dino';
    case Oli = 'oli';

    public function name(): string
    {
        return __("companions.{$this->value}.name");
    }

    public function tagline(): string
    {
        return __("companions.{$this->value}.tagline");
    }

    /**
     * Added to the role-play prompt. Describes the character only — never the student.
     */
    public function personality(): string
    {
        return match ($this) {
            self::Miu => 'Miu, a cheerful orange cartoon cat. You are warm and often praise the student with short words like "Great!" or "Purr-fect!".',
            self::Robo => 'Robo, a clumsy, funny cartoon robot. Now and then you add a short "Beep boop!" and make small jokes about being a robot.',
            self::Dino => 'Dino, a silly green cartoon dinosaur. You are playful, you love food and you make gentle, simple jokes.',
            self::Oli => 'Oli, a kind and wise cartoon owl. You speak calmly, like a patient teacher, in very clear and simple sentences.',
        };
    }

    /**
     * How the in-page voice (Piper) speaks for this character. `rate` above 1 with
     * `preservesPitch` false makes the voice higher; below 1 makes it deeper.
     *
     * @return array{voiceId: string, rate: float, preservesPitch: bool}
     */
    public function voice(): array
    {
        return match ($this) {
            self::Miu => ['voiceId' => 'en_US-hfc_female-medium', 'rate' => 1.1, 'preservesPitch' => false],
            self::Robo => ['voiceId' => 'en_US-ryan-medium', 'rate' => 1.04, 'preservesPitch' => false],
            self::Dino => ['voiceId' => 'en_US-joe-medium', 'rate' => 0.94, 'preservesPitch' => false],
            self::Oli => ['voiceId' => 'en_GB-alba-medium', 'rate' => 0.9, 'preservesPitch' => true],
        };
    }
}
