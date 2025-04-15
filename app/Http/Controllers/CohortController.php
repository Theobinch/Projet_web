<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CohortController extends Controller
{
    /**
     * Display all available cohorts
     * @return Factory|View|Application|object
     */
    public function index() {

        $schools = School::all();
        $cohorts = Cohort::with('school')->get();

        $cohortStudentCount = $cohorts->map(function ($cohort) {
            $studentCount = DB::table('cohort_student')->where('cohort_id', $cohort->id)->count();
            $cohort->studentCount = $studentCount;
            return $cohort;
        });

        return view('pages.cohorts.index', compact('schools', 'cohorts', 'cohortStudentCount'));
    }


    /**
     * Display a specific cohort
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort) {

        $cohortStudents = $cohort->students;
        $cohortTeachers = $cohort->teachers;

        $students = User::join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.role', 'student')
            ->select('users.*')
            ->get();

        $teachers = User::join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.role', 'teacher')
            ->select('users.*')
            ->get();

        return view('pages.cohorts.show', [
            'cohort' => $cohort,
            'students' => $students,
            'teachers' => $teachers,
            'cohortStudents' => $cohortStudents,
            'cohortTeachers' => $cohortTeachers
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

        $studentAlreadyAssigned = DB::table('cohort_student')
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($studentAlreadyAssigned) {
            return back()->with('error', 'Cet étudiant est déjà assigné à une autre promotion.');
        }

        $cohort->students()->attach($validated['user_id']);

        return redirect()->route('cohort.show', $cohort);
    }

    public function addTeacher(Request $request, Cohort $cohort)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cohort->teachers()->attach($validated['user_id']);

        return redirect()->route('cohort.show', $cohort);
    }
}
