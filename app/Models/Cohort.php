<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $table        = 'cohorts';
    protected $fillable     = ['school_id', 'name', 'description', 'start_date', 'end_date'];

    //lien entre ecole et promo
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    //lien entre etudiant et promo
    public function students()
    {
        return $this->belongsToMany(User::class, 'cohort_student');
    }

    //lien entre enseignant et promo
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'cohort_teacher', 'cohort_id', 'user_id');
    }
}

