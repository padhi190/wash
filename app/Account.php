<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 *
 * @package App
 * @property string $name
 * @property string $account_no
 * @property string $holder_name
 * @property string $branch
*/
class Account extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'account_no', 'holder_name', 'branch'];
    
    public static function boot()
    {
        parent::boot();

        Account::observe(new \App\Observers\UserActionsObserver);
    }
    
}
