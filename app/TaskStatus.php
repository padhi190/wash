<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskStatus
 *
 * @package App
 * @property string $name
*/
class TaskStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        TaskStatus::observe(new \App\Observers\UserActionsObserver);
    }
    
}
