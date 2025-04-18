<?php

namespace App\Providers;

use App\Models\Cohort;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $teacherSideBar = collect();

            if (auth()->check()) {
                $user = auth()->user();

                $userSchool = $user->school();

                if ($userSchool) {
                    if ($userSchool->pivot->role === 'teacher') {
                        $teacherSideBar = $user->cohorts()->get();
                    } else {
                        $teacherSideBar = Cohort::with('school')->get();
                    }
                }
            }
            $view->with('teacherSideBar', $teacherSideBar);
        });
    }
}
