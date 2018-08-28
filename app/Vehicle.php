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

    public function setLicensePlateAttribute($input)
    {
        $this->attributes['license_plate'] = strtoupper($input);
    }

    public function getLicensePlateAttribute()
    {
        return strtoupper($this->attributes['license_plate']);
    }

    public function setBrandAttribute($input)
    {
        $this->attributes['brand'] = ucfirst($input);
    }

    public function getBrandAttribute()
    {
        return ucfirst($this->attributes['brand']);
    }

    public function setModelAttribute($input)
    {
        $this->attributes['model'] = ucfirst($input);
    }

    public function getModelAttribute()
    {
        return ucfirst($this->attributes['model']);
    }

    public function setColorAttribute($input)
    {
        $this->attributes['color'] = ucfirst($input);
    }

    public function getColorAttribute()
    {
        return ucfirst($this->attributes['color']);
    }


    public function getFullVehicleAttribute()
    {
        $full_vehicle = $this->license_plate . " | " . $this->model . " " . $this->color . " (" . $this->type . ")";
        return strtoupper($full_vehicle);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function sales()
    {
        return $this->hasMany(Income::class, 'vehicle_id');
    }
    
}
