<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenseCategory
 *
 * @package App
 * @property string $name
*/
class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'parent_category'];
    
    public static function boot()
    {
        parent::boot();

        ExpenseCategory::observe(new \App\Observers\UserActionsObserver);
    }
    
}
