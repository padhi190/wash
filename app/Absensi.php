<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Absensi
 *
 * @package App
 * @property string $branch
 * @property string $tanggal
 * @property string $karyawan
 * @property text $note
*/
class Absensi extends Model
{
    use SoftDeletes;

    protected $fillable = ['tanggal', 'note', 'branch_id', 'karyawan_id'];
    
    public static function boot()
    {
        parent::boot();

        Absensi::observe(new \App\Observers\UserActionsObserver);
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
    public function setTanggalAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['tanggal'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['tanggal'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getTanggalAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setKaryawanIdAttribute($input)
    {
        $this->attributes['karyawan_id'] = $input ? $input : null;
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
    
    public function karyawan()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id')->withTrashed();
    }
    
}
