<x-public-layout :title="__('landing.meta_title')" :description="__('landing.meta_description')">
    {{-- Hero: the product's real call screen, drawn with the same companion the student talks to --}}
    <section class="mx-auto grid max-w-6xl items-center gap-12 px-4 pt-14 pb-16 sm:px-8 lg:grid-cols-[1.05fr_1fr] lg:pt-20 lg:pb-24">
        <div>
            <p class="text-sm font-semibold text-brand-700">{{ __('landing.hero_eyebrow') }}</p>
            <h1 class="mt-3 text-4xl leading-[1.15] font-bold tracking-tight text-balance sm:text-5xl">{{ __('landing.hero_title') }}</h1>
            <p class="mt-5 max-w-xl text-lg/8 text-ink-muted">{{ __('landing.hero_body') }}</p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('login') }}" class="btn-primary px-5 py-3 text-base">
                    {{ __('landing.cta_student') }} <x-icon name="arrow-right" class="size-4" />
                </a>
                <a href="{{ route('login.staff') }}" class="btn-secondary px-5 py-3 text-base">{{ __('landing.cta_staff') }}</a>
            </div>
            <a href="{{ route('guide') }}" class="mt-4 inline-block text-sm font-medium text-brand-700 hover:underline">{{ __('landing.cta_guide') }}</a>
        </div>

        <div class="card overflow-hidden" aria-hidden="true">
            <div class="flex items-start gap-3 border-b border-line px-5 py-4">
                <span class="text-2xl">🛍️</span>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold">{{ __('landing.demo_title') }}</p>
                    <p class="text-sm text-ink-muted">{{ __('landing.demo_situation') }}</p>
                </div>
                <p class="shrink-0 text-right text-xs text-ink-subtle">
                    <span class="block text-base font-semibold text-ink tabular-nums">3/12</span>
                    {{ __('roleplay.turns_label') }}
                </p>
            </div>

            <div data-state="speaking" class="relative flex flex-col items-center bg-brand-50 px-4 pt-12 pb-10">
                <p class="absolute top-3 left-3 flex items-center gap-2 rounded-full bg-surface px-3 py-1 text-xs font-semibold">
                    <span class="size-2 rounded-full bg-good"></span>
                    {{ __('companions.state_speaking', ['name' => App\Enums\Companion::Miu->name()]) }}
                </p>
                <x-companion :companion="App\Enums\Companion::Miu" class="size-48 sm:size-56" />
                <p lang="en" class="mt-3 max-w-md rounded-xl bg-ink/80 px-4 py-2 text-center text-[15px]/6 text-white">Hello! Can I help you?</p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2 border-t border-line px-5 py-4">
                <span class="btn-secondary"><x-icon name="replay" class="size-4" /> {{ __('companions.repeat') }}</span>
                <span class="btn-secondary">{{ __('roleplay.hint') }}</span>
                <span class="btn-primary bg-bad hover:bg-bad"><x-icon name="phone" class="size-4 rotate-[135deg]" /> {{ __('companions.call_end') }}</span>
            </div>
        </div>
    </section>

    <section class="border-y border-line bg-surface">
        <dl class="mx-auto grid max-w-6xl grid-cols-2 gap-y-6 px-4 py-8 sm:px-8 lg:grid-cols-4">
            @foreach (__('landing.facts') as $fact)
                <div class="flex flex-col">
                    <dt class="text-sm text-ink-muted">{{ $fact['label'] }}</dt>
                    <dd class="order-first text-3xl font-bold tracking-tight tabular-nums">{{ $fact['value'] }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- The problem, then the four steps that answer it --}}
    <section class="mx-auto grid max-w-6xl gap-12 px-4 py-20 sm:px-8 lg:grid-cols-[1fr_1.4fr]">
        <div>
            <h2 class="text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.problem_title') }}</h2>
            <p class="mt-4 text-ink-muted">{{ __('landing.problem_body') }}</p>
        </div>

        <ol class="divide-y divide-line border-y border-line">
            @foreach (__('landing.steps') as $i => $step)
                <li class="flex gap-5 py-5">
                    <span class="w-6 shrink-0 text-2xl font-bold text-brand-600 tabular-nums">{{ $i + 1 }}</span>
                    <div>
                        <h3 class="font-semibold">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-sm/6 text-ink-muted">{{ $step['body'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- The three support levels, showing what each one really displays --}}
    <section class="border-y border-line bg-surface">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-20 sm:px-8 lg:grid-cols-2">
            <div>
                <h2 class="text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.support_title') }}</h2>
                <p class="mt-4 text-ink-muted">{{ __('landing.support_body') }}</p>
            </div>

            <ul class="card divide-y divide-line bg-ground" aria-label="{{ __('topics.support.label') }}">
                @foreach (['full' => 'Cái này giá bao nhiêu?', 'partial' => 'Cái này …', 'english' => null] as $level => $meaning)
                    <li class="flex items-start gap-4 px-5 py-4">
                        <span class="w-28 shrink-0 pt-0.5 text-sm font-semibold text-brand-700">{{ __("topics.support.{$level}") }}</span>
                        <div class="min-w-0">
                            <p lang="en" class="font-medium">How much is this?</p>
                            @if ($meaning)
                                <p lang="vi" class="text-sm text-ink-muted">{{ $meaning }}</p>
                            @endif
                            @if ($level !== 'full')
                                <p class="text-sm font-medium text-brand-700">{{ __('topics.reveal') }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-20 sm:px-8">
        <h2 class="max-w-2xl text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.companions_title') }}</h2>
        <p class="mt-4 max-w-2xl text-ink-muted">{{ __('landing.companions_body') }}</p>

        <ul class="mt-10 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-line bg-line lg:grid-cols-4">
            @foreach (App\Enums\Companion::cases() as $companion)
                <li class="flex flex-col items-center bg-surface px-4 py-8 text-center">
                    <x-companion :companion="$companion" class="size-28 sm:size-32" />
                    <p class="mt-3 font-semibold">{{ $companion->name() }}</p>
                    <p class="mt-0.5 text-sm text-ink-muted">{{ $companion->tagline() }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="border-y border-line bg-surface">
        <div class="mx-auto max-w-6xl px-4 py-20 sm:px-8">
            <h2 class="max-w-2xl text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.skills_title') }}</h2>
            <p class="mt-4 max-w-2xl text-ink-muted">{{ __('landing.skills_body') }}</p>

            <dl class="mt-10 grid gap-x-10 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (App\Enums\SkillType::cases() as $skill)
                    <div class="flex gap-3">
                        <x-icon :name="$skill->icon()" class="mt-0.5 text-brand-600" />
                        <div>
                            <dt class="font-semibold">{{ $skill->label() }}</dt>
                            <dd class="mt-1 text-sm/6 text-ink-muted">{{ __("landing.skills.{$skill->value}") }}</dd>
                        </div>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-12 px-4 py-20 sm:px-8 lg:grid-cols-[1fr_1.4fr]">
        <div>
            <h2 class="text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.teacher_title') }}</h2>
            <p class="mt-4 text-ink-muted">{{ __('landing.teacher_body') }}</p>
        </div>

        <ul class="grid gap-x-10 gap-y-7 sm:grid-cols-2">
            @foreach (__('landing.teacher_items') as $item)
                <li>
                    <h3 class="font-semibold">{{ $item['title'] }}</h3>
                    <p class="mt-1 text-sm/6 text-ink-muted">{{ $item['body'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="bg-brand-900 text-white">
        <div class="mx-auto max-w-6xl px-4 py-20 sm:px-8">
            <h2 class="max-w-2xl text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.safety_title') }}</h2>

            <dl class="mt-10 grid gap-10 md:grid-cols-3">
                @foreach (__('landing.safety_items') as $item)
                    <div class="border-t border-white/25 pt-5">
                        <dt class="font-semibold">{{ $item['title'] }}</dt>
                        <dd class="mt-2 text-sm/6 text-white/80">{{ $item['body'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-20 text-center sm:px-8">
        <h2 class="text-3xl leading-tight font-bold tracking-tight text-balance">{{ __('landing.closing_title') }}</h2>
        <p class="mx-auto mt-4 max-w-xl text-ink-muted">{{ __('landing.closing_body') }}</p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('login') }}" class="btn-primary px-5 py-3 text-base">{{ __('landing.cta_student') }}</a>
            <a href="{{ route('login.staff') }}" class="btn-secondary px-5 py-3 text-base">{{ __('landing.cta_staff') }}</a>
        </div>
    </section>
</x-public-layout>
