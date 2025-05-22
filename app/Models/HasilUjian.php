<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $peserta_id
 * @property integer $sertifikat_id
 * @property integer $hasil_nilai
 * @property string $waktu_selesai
 * @property string $created_at
 * @property string $updated_at
 * @property Pesertum $pesertum
 * @property Sertifikat $sertifikat
 */
class HasilUjian extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hasil_ujian';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['peserta_id', 'sertifikat_id', 'hasil_nilai', 'waktu_selesai', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peserta()
    {
        return $this->belongsTo('App\Models\Peserta', 'peserta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sertifikat()
    {
        return $this->belongsTo('App\Models\Sertifikat');
    }
}
