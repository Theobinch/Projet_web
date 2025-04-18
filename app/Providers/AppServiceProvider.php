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

            //verifie si utilisateur est identifié
            if (auth()->check()) {
                //recup le user
                $user = auth()->user();
                //recupere l'ecole
                $userSchool = $user->school();

                //verifie si user est associé a une ecole
                if ($userSchool) {
                    //si role est teacher
                    if ($userSchool->pivot->role === 'teacher') {
                        //recupere promotion de l'enseignant
                        $teacherSideBar = $user->cohorts()->get();
                    } else {
                        //sinon recupere toute les promo
                        $teacherSideBar = Cohort::with('school')->get();
                    }
                }
            }
            //passe la variable a toute les vue
            $view->with('teacherSideBar', $teacherSideBar);
        });
    }
}
