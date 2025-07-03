<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $peserta_id
 * @property integer $ujian_id
 * @property integer $total_soal
 * @property integer $soal_dijawab
 * @property integer $jawaban_benar
 * @property integer $hasil_nilai
 * @property integer $durasi_pengerjaan
 * @property string $waktu_mulai
 * @property string $waktu_selesai
 * @property string $waktu_selesai_timestamp
 * @property string $detail_section
 * @property string $status
 * @property integer $sertifikat_id
 * @property string $created_at
 * @property string $updated_at
 * @property Peserta $peserta
 * @property Ujian $ujian
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
     * @var array
     */
    protected $fillable = [
        'peserta_id',
        'ujian_id',
        'total_soal',
        'soal_dijawab',
        'jawaban_benar',
        'hasil_nilai',
        'durasi_pengerjaan',
        'waktu_mulai',
        'waktu_selesai',
        'waktu_selesai_timestamp',
        'detail_section',
        'status',
        'sertifikat_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai_timestamp' => 'datetime',
        'detail_section' => 'array',
    ];

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
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian', 'ujian_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sertifikat()
    {
        return $this->belongsTo('App\Models\Sertifikat', 'sertifikat_id');
    }
}
