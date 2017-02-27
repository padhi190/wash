<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IncomeCategory
 *
 * @package App
 * @property string $name
 * @property decimal $price
*/
class IncomeCategory extends Model
{
    protected $fillable = ['name', 'price'];
    
    public static function boot()
    {
        parent::boot();

        IncomeCategory::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }
    
}
