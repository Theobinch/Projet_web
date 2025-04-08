<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('pages.teachers.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $validated['password'] = bcrypt('test1');

        User::create($validated);

        return redirect()->back()->with('success');
    }
}
