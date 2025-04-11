<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\School;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    /**
     * Display all available cohorts
     * @return Factory|View|Application|object
     */
    public function index() {

        $schools = School::all();
        $cohorts = Cohort::with('school')->get();

        return view('pages.cohorts.index', compact('schools', 'cohorts'));
    }


    /**
     * Display a specific cohort
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort) {

        $cohortStudents = $cohort->students;

        $students = User::join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.role', 'student')
            ->select('users.*')
            ->get();

        return view('pages.cohorts.show', [
            'cohort' => $cohort,
            'students' => $students,
            'cohortStudents' => $cohortStudents
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        Cohort::create([
            'school_id' => $validated['school_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('cohort.index');
    }

    public function destroy($id)
    {
        $cohort = Cohort::findOrFail($id);
        $cohort->delete();

        return redirect()->route('cohort.index');
    }

    public function addStudent(Request $request, Cohort $cohort)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cohort->students()->attach($validated['user_id']);

        return redirect()->route('cohort.show', $cohort);
    }
}
