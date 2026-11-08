<div class="mx-auto max-w-3xl space-y-6">
    <header class="border-b border-line pb-5">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('skills.create_title') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('skills.create_hint') }}</p>
    </header>

    @if ($error)
        <p role="alert" class="rounded-lg bg-bad-soft px-4 py-3 text-sm text-bad">{{ $error }}</p>
    @endif

    {{-- Who it is for --}}
    <section class="card grid gap-4 p-5 sm:grid-cols-3">
        <div>
            <label for="grade" class="mb-1.5 block text-sm font-medium">{{ __('skills.for_grade') }}</label>
            <select wire:model.live="grade" id="grade" class="form-input">
                @foreach ($grades as $option)
                    <option value="{{ $option }}">{{ __('curriculum.grade_n', ['grade' => $option]) }}</option>
                @endforeach
            </select>
            @error('grade') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="unitId" class="mb-1.5 block text-sm font-medium">{{ __('skills.for_unit') }}</label>
            <select wire:model="unitId" id="unitId" class="form-input">
                <option value="">{{ __('skills.no_unit') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" wire:key="unit-{{ $unit->id }}">{{ $unit->label() }} · {{ $unit->title() }}</option>
                @endforeach
            </select>
            @error('unitId') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="skill" class="mb-1.5 block text-sm font-medium">{{ __('skills.skill') }}</label>
            <select wire:model.live="skill" id="skill" class="form-input">
                @foreach ($skills as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </select>
            @error('skill') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>
    </section>

    {{-- How --}}
    <fieldset class="grid gap-3 sm:grid-cols-2">
        <legend class="mb-2 text-sm font-semibold">{{ __('skills.method') }}</legend>
        @foreach (['upload' => 'sparkles', 'manual' => 'pencil'] as $value => $icon)
            <label wire:key="method-{{ $value }}" class="card flex cursor-pointer gap-3 p-4 transition hover:border-line-strong has-checked:border-brand-600 has-checked:ring-2 has-checked:ring-brand-100">
                <input type="radio" wire:model.live="method" value="{{ $value }}" class="mt-1 size-4 text-brand-600 focus:ring-brand-100">
                <span>
                    <span class="flex items-center gap-2 font-semibold"><x-icon :name="$icon" class="size-4 text-brand-600" /> {{ __("skills.method_{$value}") }}</span>
                    <span class="mt-1 block text-sm text-ink-muted">{{ __("skills.method_{$value}_hint") }}</span>
                </span>
            </label>
        @endforeach
    </fieldset>

    @if ($method === 'manual')
        <button type="button" wire:click="createBlank" wire:loading.attr="disabled" wire:target="createBlank" class="btn-primary">
            <x-icon name="plus" class="size-4" /> {{ __('skills.create_manual_button') }}
        </button>
    @else
        <form wire:submit="readUpload" class="card space-y-5 p-5">
            @unless (in_array(App\Enums\SkillType::from($skill), $uploadSkills, true))
                <p class="rounded-lg bg-warn-soft px-4 py-3 text-sm">{{ __('skills.upload_skill_hint') }}</p>
            @endunless

            <div>
                <label for="files" class="mb-1.5 block text-sm font-medium">{{ __('skills.files') }}</label>
                <p class="mb-2 text-sm text-ink-subtle">{{ __('skills.files_hint') }}</p>
                <input wire:model="files" id="files" type="file" multiple accept="image/jpeg,image/png,image/webp,application/pdf"
                    class="block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
                <p wire:loading wire:target="files" class="mt-2 text-sm text-ink-subtle">…</p>
                @error('files') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                @error('files.*') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror

                @if ($files)
                    <ul class="mt-3 flex flex-wrap gap-3">
                        @foreach ($files as $index => $file)
                            <li wire:key="file-{{ $index }}-{{ $file->getFilename() }}" class="relative">
                                @if (str_starts_with((string) $file->getMimeType(), 'image/'))
                                    <img src="{{ $file->temporaryUrl() }}" alt="" class="size-24 rounded-lg border border-line object-cover">
                                @else
                                    <span class="grid size-24 place-items-center rounded-lg border border-line bg-ground text-xs font-semibold">PDF</span>
                                @endif
                                <button type="button" wire:click="removeFile({{ $index }})" aria-label="{{ __('skills.remove_question') }}"
                                    class="absolute -top-2 -right-2 grid size-6 place-items-center rounded-full bg-ink text-white">
                                    <x-icon name="x" class="size-3.5" />
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="space-y-2">
                <label class="flex items-start gap-3 text-sm">
                    <input wire:model="confirmOwn" type="checkbox" class="mt-0.5 size-4 rounded border-line-strong text-brand-600 focus:ring-brand-100">
                    <span>{{ __('skills.confirm_own') }}</span>
                </label>
                @error('confirmOwn') <p class="text-sm text-bad">{{ $message }}</p> @enderror
                <label class="flex items-start gap-3 text-sm">
                    <input wire:model="confirmNoStudents" type="checkbox" class="mt-0.5 size-4 rounded border-line-strong text-brand-600 focus:ring-brand-100">
                    <span>{{ __('skills.confirm_no_students') }}</span>
                </label>
                @error('confirmNoStudents') <p class="text-sm text-bad">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" wire:loading.attr="disabled" wire:target="readUpload,files" class="btn-primary">
                    <x-icon name="sparkles" class="size-4" /> {{ __('skills.read_upload') }}
                </button>
                <p wire:loading wire:target="readUpload" class="text-sm text-ink-muted" role="status">{{ __('skills.reading_upload') }}</p>
            </div>
        </form>
    @endif
</div>
