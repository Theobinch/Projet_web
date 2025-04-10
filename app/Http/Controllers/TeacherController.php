<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;

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

        $validated['password'] = bcrypt('test1');

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
}
