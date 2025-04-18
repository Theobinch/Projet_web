<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\School;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CohortController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display all available cohorts
     * @return Factory|View|Application|object
     */
    public function index() {

        //recupere l'user connecté
        $user = auth()->user();

        //verifie si autoriser a voir les promo
        $this->authorize('viewAny', Cohort::class);

        //si admin alors recupere
        if ($user->school()->pivot->role == 'admin'){
            $cohorts = Cohort::all();
        } else {
            //sinon recupere que promotions qui lui sont associé
            $cohorts = $user->cohorts()->get();
        }

        //recupere toute les ecoles
        $schools = School::all();

        //compte le nombre d'étudiant dans chaque promo
        $cohortStudentCount = $cohorts->map(function ($cohort) {
            //utilise la table pivot cohort_student
            $studentCount = DB::table('cohort_student')->where('cohort_id', $cohort->id)->count();
            //ajoute le nombre d'etudiant a la promo
            $cohort->studentCount = $studentCount;
            return $cohort;
        });

        //redirige vers la vue cohort index
        return view('pages.cohorts.index', compact('schools', 'cohorts', 'cohortStudentCount'));
    }


    /**
     * Display a specific cohort
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort) {

        //recupere tous les etudiants lié a la promo
        $cohortStudents = $cohort->students;

        //recupere tous les enseignant lié a la promo
        $cohortTeachers = $cohort->teachers;

        //recupere tous les etudiants dans l'ecole associé
        $students = User::join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.role', 'student')
            ->select('users.*')
            ->get();

        //recupere tous les enseignant dans l'ecole associé
        $teachers = User::join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.role', 'teacher')
            ->select('users.*')
            ->get();

        //redirige vers la page cohort show avec toutes les données
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
        //valide requete
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        //entre dans la table cohort nouvelle entrée avec des données valide
        Cohort::create([
            'school_id' => $validated['school_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        //redirige vers la page cohort index
        return redirect()->route('cohort.index');
    }

    public function destroy($id)
    {
        //recupere le cohort avec son id
        $cohort = Cohort::findOrFail($id);

        //supprime le cohort de la bdd
        $cohort->delete();

        //redirige vers la page cohort index
        return redirect()->route('cohort.index');
    }

    public function addStudent(Request $request, Cohort $cohort)
    {
        //valide que user_id existe et qu'il sagit bien d'un user existant
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        //verifie si il existe deja dans une autre promo
        $studentAlreadyAssigned = DB::table('cohort_student')
            ->where('user_id', $validated['user_id'])
            ->exists();

        //si deja assigné, retour message d'erreur
        if ($studentAlreadyAssigned) {
            return back()->with('error', 'Cet étudiant est déjà assigné à une autre promotion.');
        }

        //sinon on ajoute a la promo
        $cohort->students()->attach($validated['user_id']);

        //redirige vers la page cohort show avec etudiant ajouté
        return redirect()->route('cohort.show', $cohort);
    }

    public function addTeacher(Request $request, Cohort $cohort)
    {
        //valide que user_id existe et qu'il s'agit bien d'un user existant
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        //associe l'enseignant a la promo
        $cohort->teachers()->attach($validated['user_id']);

        //redirige vers la page cohort show avec enseignant ajouté
        return redirect()->route('cohort.show', $cohort);
    }

    public function update(Request $request, $id)
    {
   //valide les champs
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    //recupere la promo a modifier
    $cohort = Cohort::findOrFail($id);

    //met a jour la promo
    $cohort->update([
        'name' => $validated['name'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
    ]);

    //redirige vers la page cohort index
    return redirect()->route('cohort.index');
    }

    public function getForm(Cohort $cohort) {

        //rend la vue du form avec les données
        $html = view('pages.cohorts.cohort-form', compact('cohort'))->render();

        //retourne html avec reponse json
        return response()->json(['html' => $html]);
    }
}
