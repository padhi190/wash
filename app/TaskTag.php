<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskTag
 *
 * @package App
 * @property string $name
*/
class TaskTag extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        TaskTag::observe(new \App\Observers\UserActionsObserver);
    }
    
}
