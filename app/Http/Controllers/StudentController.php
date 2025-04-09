<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = UserSchool::with('user')->where('role', 'student')->get();
        return view('pages.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birth_date' => 'nullable|date',
            'school' => 'required|string',
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
}
