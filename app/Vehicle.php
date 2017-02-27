<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle
 *
 * @package App
 * @property string $license_plate
 * @property string $customer
 * @property string $type
 * @property string $brand
 * @property string $model
 * @property string $color
 * @property string $size
 * @property text $note
*/
class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = ['license_plate', 'type', 'brand', 'model', 'color', 'size', 'note', 'customer_id'];
    
    public static function boot()
    {
        parent::boot();

        Vehicle::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCustomerIdAttribute($input)
    {
        $this->attributes['customer_id'] = $input ? $input : null;
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }
    
}
