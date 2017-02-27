<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Income
 *
 * @package App
 * @property string $branch
 * @property string $vehicle
 * @property string $entry_date
 * @property string $income_category
 * @property string $product
 * @property integer $qty
 * @property string $amount
 * @property decimal $discount
 * @property string $payment_type
 * @property text $note
*/
class Income extends Model
{
    use SoftDeletes;

    protected $fillable = ['entry_date', 'qty', 'amount', 'discount', 'note', 'branch_id', 'vehicle_id', 'income_category_id', 'product_id', 'payment_type_id'];
    
    public static function boot()
    {
        parent::boot();

        Income::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setBranchIdAttribute($input)
    {
        $this->attributes['branch_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setVehicleIdAttribute($input)
    {
        $this->attributes['vehicle_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setEntryDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['entry_date'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['entry_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getEntryDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setIncomeCategoryIdAttribute($input)
    {
        $this->attributes['income_category_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setProductIdAttribute($input)
    {
        $this->attributes['product_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setQtyAttribute($input)
    {
        $this->attributes['qty'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setDiscountAttribute($input)
    {
        $this->attributes['discount'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPaymentTypeIdAttribute($input)
    {
        $this->attributes['payment_type_id'] = $input ? $input : null;
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id')->withTrashed();
    }
    
    public function income_category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
    
    public function payment_type()
    {
        return $this->belongsTo(Account::class, 'payment_type_id')->withTrashed();
    }
    
}
