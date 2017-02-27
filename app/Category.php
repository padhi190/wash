<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package App
 * @property string $name
 * @property text $description
 * @property string $photo
*/
class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'photo'];
    
    public static function boot()
    {
        parent::boot();

        Category::observe(new \App\Observers\UserActionsObserver);
    }
    
}
