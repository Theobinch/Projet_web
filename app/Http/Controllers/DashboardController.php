<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\UserSchool;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $userRole = auth()->user()->school()->pivot->role;

        $cohorts = Cohort::all();

        $studentCount = UserSchool::where('role', 'student')->count();
        $teacherCount = UserSchool::where('role', 'teacher')->count();
        $cohortCount = Cohort::count();

        return view('pages.dashboard.dashboard-' . $userRole, [
            'studentCount' => $studentCount,
            'teacherCount' => $teacherCount,
            'cohortCount' => $cohortCount,
        ], compact('cohorts'));
    }
}
