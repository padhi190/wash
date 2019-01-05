<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Antrian extends Model
{
    //
    protected $fillable = ['license_plate', 'type', 'brand','branch_id' ,'model', 'color', 'size', 'arrival_time', 'status', 'note', 'customer', 'name', 'phone'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function setArrivalTimeAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['arrival_time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i', $input)->format('Y-m-d H:i');
        } else {
            $this->attributes['arrival_time'] = null;
        }
    }

}
