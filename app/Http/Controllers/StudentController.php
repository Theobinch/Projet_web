<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $students = UserSchool::with('user')->where('role', 'student')->get();
        return view('pages.students.index', compact('schools', 'students'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birth_date' => 'nullable|date',
            'school' => 'required|exists:schools,id',
        ]);

        $randomPassword = Str::random(15);
        $validated['password'] = bcrypt($randomPassword);

        $user = User::create($validated);

        UserSchool::create([
            'user_id' => $user->id,
            'school_id' => $validated['school'],
            'role' => 'student',
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
        ]);

        $school = $user->school();
        if ($school) {
            \DB::table('users_schools')
                ->where('user_id', $user->id)
                ->where('school_id', $school->id);
        }
        return redirect()->route('student.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        \DB::table('users_schools')->where('user_id', $user->id)->delete();

        $user->delete();

        return redirect()->route('student.index');
    }

    public function deleteToCohort($userId, $cohortId)
    {
        \DB::table('cohort_student')->where('user_id', $userId)->where('cohort_id', $cohortId)->delete();

        return redirect()->route('cohort.show', ['cohort' => $cohortId]);
    }
}
