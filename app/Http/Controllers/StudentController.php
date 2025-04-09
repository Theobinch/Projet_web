<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;

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

        $validated['password'] = bcrypt('test1');

        $user = User::create($validated);

        UserSchool::create([
            'user_id' => $user->id,
            'school_id' => $validated['school'],
            'role' => 'student',
        ]);

        return redirect()->back()->with('success');
    }

    public function destroy($id)
    {

        $userSchool = UserSchool::where('user_id', $id)->where('role', 'student')->first();

        if ($userSchool) {

            $userSchool->delete();

            $user = User::findOrFail($userSchool->user_id);
            $user->delete();
        }

        return redirect()->route('students.index')->with('success');
    }
}
