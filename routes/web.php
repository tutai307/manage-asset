<?php

use App\Enums\AppLocale;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Classrooms;
use App\Livewire\Curriculum;
use App\Livewire\Dashboard;
use App\Livewire\Roleplay\ConversationPage;
use App\Livewire\Roleplay\History;
use App\Livewire\Skills;
use App\Livewire\Topics;
use Illuminate\Support\Facades\Route;

Route::post('/locale/{locale}', LocaleController::class)
    ->whereIn('locale', AppLocale::values())
    ->name('locale.switch');

Route::middleware('guest')->group(function () {
    Route::livewire('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/', Dashboard::class)->name('home');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::livewire('/classrooms', Classrooms\Index::class)
        ->middleware('can:viewAny,App\Models\Classroom')
        ->name('classrooms.index');
    Route::livewire('/classrooms/{classroom}', Classrooms\Show::class)->name('classrooms.show');

    Route::livewire('/curriculum', Curriculum\Index::class)->name('curriculum.index');
    Route::livewire('/curriculum/{unit}', Curriculum\Show::class)->name('curriculum.show');

    Route::livewire('/exercises/{exercise}', Skills\ExercisePage::class)->name('exercises.show');
    Route::livewire('/exercises/{exercise}/edit', Skills\EditExercise::class)->name('exercises.edit');

    Route::livewire('/topics', Topics\Index::class)->name('topics.index');
    Route::livewire('/topics/{topic}', Topics\Show::class)->name('topics.show');

    Route::livewire('/conversations', History::class)->name('conversations.index');
    Route::livewire('/conversations/{conversation}', ConversationPage::class)->name('conversations.show');
});
