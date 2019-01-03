<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    //
    protected $fillable = ['license_plate', 'type', 'brand','branch_id' ,'model', 'color', 'size', 'arrival_time', 'status', 'note'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
