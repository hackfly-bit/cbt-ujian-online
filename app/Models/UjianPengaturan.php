<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ujian_id
 * @property string $metode_penilaian
 * @property integer $nilai_kelulusan
 * @property boolean $hasil_ujian_tersedia
 * @property string $created_at
 * @property string $updated_at
 * @property Ujian $ujian
 * @property boolean $acak_soal
 * @property boolean $acak_jawaban
 * @property boolean $lihat_hasil
 * @property boolean $lockscreen
 */
class UjianPengaturan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ujian_pengaturan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ujian_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    // protected $fillable = ['metode_penilaian', 'nilai_kelulusan', 'hasil_ujian_tersedia', 'created_at', 'updated_at'];

      protected $fillable = [
        'metode_penilaian',
        'nilai_kelulusan',
        'hasil_ujian_tersedia',
        'acak_soal',
        'acak_jawaban',
        'lihat_hasil',
        'lihat_pembahasan',
        'lockscreen',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }
}
