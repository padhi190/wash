<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 *
 * @package App
 * @property string $branch
 * @property string $name
 * @property string $sex
 * @property string $phone
 * @property string $join_date
 * @property text $note
*/
class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sex', 'phone', 'join_date', 'note', 'branch_id'];
    
    public static function boot()
    {
        parent::boot();

        Customer::observe(new \App\Observers\UserActionsObserver);
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
     * Set attribute to date format
     * @param $input
     */
    public function setJoinDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['join_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['join_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getJoinDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
    
}
