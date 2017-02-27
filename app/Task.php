<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 *
 * @package App
 * @property string $branch
 * @property string $kendaraan
 * @property text $description
 * @property string $status
 * @property string $due_date
 * @property string $approval_date
*/
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'due_date', 'approval_date', 'branch_id', 'kendaraan_id', 'status_id'];
    
    public static function boot()
    {
        parent::boot();

        Task::observe(new \App\Observers\UserActionsObserver);
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
    public function setKendaraanIdAttribute($input)
    {
        $this->attributes['kendaraan_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setStatusIdAttribute($input)
    {
        $this->attributes['status_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDueDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['due_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['due_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDueDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setApprovalDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['approval_date'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['approval_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getApprovalDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
    
    public function kendaraan()
    {
        return $this->belongsTo(Vehicle::class, 'kendaraan_id')->withTrashed();
    }
    
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id')->withTrashed();
    }
    
    public function tag()
    {
        return $this->belongsToMany(TaskTag::class, 'task_task_tag')->withTrashed();
    }
    
}
