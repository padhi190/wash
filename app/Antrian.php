<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    //
    protected $fillable = ['license_plate', 'type', 'brand', 'model', 'color', 'size', 'arrival_time', 'status', 'note'];
}
