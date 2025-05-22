<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ujian_id
 * @property string $nama
 * @property string $phone
 * @property string $email
 * @property string $institusi
 * @property string $nomor_induk
 * @property string $tanggal_lahir
 * @property string $alamat
 * @property string $foto
 * @property string $session_id
 * @property string $created_at
 * @property string $updated_at
 * @property HasilUjian[] $hasilUjians
 * @property Ujian $ujian
 */
class Peserta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'peserta';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['ujian_id', 'nama', 'phone', 'email', 'institusi', 'nomor_induk', 'tanggal_lahir', 'alamat', 'foto', 'session_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasilUjians()
    {
        return $this->hasMany('App\Models\HasilUjian', 'peserta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }
}
