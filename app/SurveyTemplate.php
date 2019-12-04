<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyTemplate extends Model
{
    //
    protected $fillable = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10','essay', 'template_name', 'no_of_questions'];
}
