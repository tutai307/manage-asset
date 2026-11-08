<?php

use App\Enums\AppLocale;
use App\Http\Controllers\ExerciseSourceController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LogoutController;
use App\Livewire\Account\ChangePassword;
use App\Livewire\Assignments;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\StaffLogin;
use App\Livewire\Classrooms;
use App\Livewire\Curriculum;
use App\Livewire\Dashboard;
use App\Livewire\Roleplay\ConversationPage;
use App\Livewire\Roleplay\History;
use App\Livewire\Skills;
use App\Livewire\Teachers;
use App\Livewire\Topics;
use Illuminate\Support\Facades\Route;

Route::post('/locale/{locale}', LocaleController::class)
    ->whereIn('locale', AppLocale::values())
    ->name('locale.switch');

Route::view('/guide', 'public.guide')->name('guide');

Route::middleware('guest')->group(function () {
    Route::view('/', 'public.landing')->name('landing');
    Route::livewire('/login', Login::class)->name('login');
    Route::livewire('/staff/login', StaffLogin::class)->name('login.staff');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', Dashboard::class)->name('home');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::livewire('/account/password', ChangePassword::class)->name('account.password');

    Route::livewire('/teachers', Teachers\Index::class)
        ->middleware('can:manageTeachers,App\Models\User')
        ->name('teachers.index');

    Route::livewire('/classrooms', Classrooms\Index::class)
        ->middleware('can:viewAny,App\Models\Classroom')
        ->name('classrooms.index');
    Route::livewire('/classrooms/{classroom}', Classrooms\Show::class)->name('classrooms.show');

    Route::livewire('/curriculum', Curriculum\Index::class)->name('curriculum.index');
    Route::livewire('/curriculum/{unit}', Curriculum\Show::class)->name('curriculum.show');

    Route::livewire('/exercises/create', Skills\CreateExercise::class)->name('exercises.create');
    Route::livewire('/exercises/{exercise}', Skills\ExercisePage::class)->name('exercises.show');
    Route::livewire('/exercises/{exercise}/edit', Skills\EditExercise::class)->name('exercises.edit');
    Route::get('/exercises/{exercise}/source/{index}', ExerciseSourceController::class)
        ->whereNumber('index')
        ->name('exercises.source');

    Route::livewire('/assignments', Assignments\Index::class)->name('assignments.index');
    Route::livewire('/assignments/{assignment}', Assignments\Show::class)->name('assignments.show');

    Route::livewire('/topics', Topics\Index::class)->name('topics.index');
    Route::livewire('/topics/{topic}', Topics\Show::class)->name('topics.show');

    Route::livewire('/conversations', History::class)->name('conversations.index');
    Route::livewire('/conversations/{conversation}', ConversationPage::class)->name('conversations.show');
});
