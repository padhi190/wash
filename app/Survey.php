<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $fillable = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10','essay','income_id', 'branch_id', 'template_id', 'coupon_code', 'expiry_date', 'coupon_type'];

    public function income()
    {
    	return $this->belongsTo(Income::class);
    }
}
