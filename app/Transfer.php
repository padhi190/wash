<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transfer
 *
 * @package App
 * @property string $branch
 * @property string $tanggal
 * @property string $dari
 * @property string $ke
 * @property decimal $jumlah
 * @property text $note
*/
class Transfer extends Model
{
    use SoftDeletes;

    protected $fillable = ['tanggal', 'jumlah', 'note', 'branch_id', 'dari_id', 'ke_id'];
    
    public static function boot()
    {
        parent::boot();

        Transfer::observe(new \App\Observers\UserActionsObserver);
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
            $this->attributes['tanggal'] = Carbon::createFromFormat(config('app.date_format') . ' H:i', $input)->format('Y-m-d H:i');
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
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i');
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setDariIdAttribute($input)
    {
        $this->attributes['dari_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setKeIdAttribute($input)
    {
        $this->attributes['ke_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setJumlahAttribute($input)
    {
        $this->attributes['jumlah'] = $input ? $input : null;
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
    
    public function dari()
    {
        return $this->belongsTo(Account::class, 'dari_id')->withTrashed();
    }
    
    public function ke()
    {
        return $this->belongsTo(Account::class, 'ke_id')->withTrashed();
    }
    
}
