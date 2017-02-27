<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @package App
 * @property string $name
*/
class Tag extends Model
{
    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        Tag::observe(new \App\Observers\UserActionsObserver);
    }
    
}
