<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\UserSchool;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //recupere le role du user connecté
        $userRole = auth()->user()->school()->pivot->role;

        //recupere toutes les promo
        $cohorts = Cohort::all();

        //compte le nombre d'etudiant dans l'ecole
        $studentCount = UserSchool::where('role', 'student')->count();
        //compte le nombre d'enseignant dans l'ecole
        $teacherCount = UserSchool::where('role', 'teacher')->count();
        //compte le nombre de promo
        $cohortCount = Cohort::count();

        //renvoie la vue du user en fonction de son role
        return view('pages.dashboard.dashboard-' . $userRole, [
            'studentCount' => $studentCount,
            'teacherCount' => $teacherCount,
            'cohortCount' => $cohortCount,
        ], compact('cohorts'));
    }
}
