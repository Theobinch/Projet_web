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
        //recupere toute les ecole
        $schools = School::all();
        //recupere tous les user grace a la table user_school
        $teachers = UserSchool::with('user')->where('role', 'teacher')->get();
        //renvoie la vue teacher index
        return view('pages.teachers.index',compact('schools'), compact('teachers'));
    }

    public function store(Request $request)
    {
        //valide les donnée recu par formulaire
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'school' => 'required|exists:schools,id',
        ]);

        //genere mot de passe random de 15 caractere
        $randomPassword = Str::random(15);
        //crypte le mdp
        $validated['password'] = bcrypt($randomPassword);

        //crée un nouvel user
        $user = User::create($validated);

        //ajoute l'user a la table user_school
        UserSchool::create([
            'user_id' => $user->id,
            'school_id' => $validated['school'],
            'role' => 'teacher',
        ]);

        //redirige le user a la page precedente apres creation
        return redirect()->back()->with('success');
    }

    public function update(Request $request, $id)
    {
        //valide donne recu via formulaire
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        //recherche user via son id
        $user = User::findOrFail($id);

        //met a jour le user
        $user->update([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'email' => $validated['email'],
        ]);

        //recup l'ecole associé au user
        $school = $user->school();

        //si ecole existe, met a jour dans user_school
        if ($school) {
            \DB::table('users_schools')
                ->where('user_id', $user->id)
                ->where('school_id', $school->id);
        }
        //redirige vers teacher index
        return redirect()->route('teacher.index');
    }

    public function destroy($id)
    {
        //recherche le user avec son id
        $user = User::findOrFail($id);

        //supprime le lien entre user_school et le user
        \DB::table('users_schools')->where('user_id', $user->id)->delete();

        //supprime le user de la table user
        $user->delete();

        //redirige vers teacher index
        return redirect()->route('teacher.index');
    }

    public function deleteToCohort($userId, $cohortId)
    {
        //supprime le lien entre user et cohort_teacher
        \DB::table('cohort_teacher')->where('user_id', $userId)->where('cohort_id', $cohortId)->delete();

        //renvoie la vue cohort show apres avoir supp l'enseignant de la promo
        return redirect()->route('cohort.show', ['cohort' => $cohortId]);
    }

    public function getForm(User $teacher) {

        //rend la vue du form avec les données
        $html = view('pages.teachers.teacher-form', compact('teacher'))->render();

        //retourne html avec reponse json
        return response()->json(['html' => $html]);
    }
}
