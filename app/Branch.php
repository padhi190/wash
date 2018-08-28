<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Branch
 *
 * @package App
 * @property string $branch_name
 * @property string $address
 * @property string $city
 * @property string $phone
*/
class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = ['branch_name', 'address', 'city', 'phone', 'last_bon'];
    
    public static function boot()
    {
        parent::boot();

        Branch::observe(new \App\Observers\UserActionsObserver);
    }
    
}
