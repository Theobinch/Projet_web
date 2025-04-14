<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $teachers = UserSchool::with('user')->where('role', 'teacher')->get();
        return view('pages.teachers.index',compact('schools'), compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'school' => 'required|exists:schools,id',
        ]);

        $randomPassword = Str::random(15);
        $validated['password'] = bcrypt($randomPassword);


        $user = User::create($validated);

        UserSchool::create([
            'user_id' => $user->id,
            'school_id' => $validated['school'],
            'role' => 'teacher',
        ]);

        return redirect()->back()->with('success');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        \DB::table('users_schools')->where('user_id', $user->id)->delete();

        $user->delete();

        return redirect()->route('teacher.index');
    }

    public function deleteToCohort($userId, $cohortId)
    {
        \DB::table('cohort_teacher')->where('user_id', $userId)->where('cohort_id', $cohortId)->delete();

        return redirect()->route('cohort.show', ['cohort' => $cohortId]);
    }
}
