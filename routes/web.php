<?php

use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommonLifeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// Redirect the root path to /dashboard
Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cohorts
        Route::get('/cohorts', [CohortController::class, 'index'])->name('cohort.index');
        Route::get('/cohort/{cohort}', [CohortController::class, 'show'])->name('cohort.show');
        Route::post('/cohorts', [CohortController::class, 'store'])->name('cohort.store');
        Route::put('/cohorts/{id}', [CohortController::class, 'update'])->name('cohort.update');
        Route::delete('/cohorts/{id}', [CohortController::class, 'destroy'])->name('cohort.destroy');
        Route::post('cohorts/{cohort}/add-student', [CohortController::class, 'addStudent'])->name('cohort.addStudent');
        Route::post('cohorts/{cohort}/add-teacher', [CohortController::class, 'addTeacher'])->name('cohort.addTeacher');
        Route::get('/cohort/{cohort}/form', [CohortController::class, 'getForm'])->name('cohort.form');

        // Teachers
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('teacher.store');
        Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teacher.update');
        Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
        Route::delete('/teachers/{userId}/cohort/{cohortId}', [TeacherController::class, 'deleteToCohort'])->name('cohort_teacher.delete');
        Route::get('/teachers/{id}/cohorts', [TeacherController::class, 'showTeacherCohorts'])->name('teacher.cohorts');
        Route::get('teacher/form/{teacher}', [TeacherController::class, 'getForm'])->name('teacher.form');

        // Students
        Route::get('students', [StudentController::class, 'index'])->name('student.index');
        Route::post('/students', [StudentController::class, 'store'])->name('student.store');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
        Route::delete('/students/{userId}/cohort/{cohortId}', [StudentController::class, 'deleteToCohort'])->name('cohort_student.delete');
        Route::get('student/form/{student}', [StudentController::class, 'getForm'])->name('student.form');

        // Knowledge
        Route::get('knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');

        // Groups
        Route::get('groups', [GroupController::class, 'index'])->name('group.index');

        // Retro
        route::get('retros', [RetroController::class, 'index'])->name('retro.index');

        // Common life
        Route::get('common-life', [CommonLifeController::class, 'index'])->name('common-life.index');
    });

});

require __DIR__.'/auth.php';
