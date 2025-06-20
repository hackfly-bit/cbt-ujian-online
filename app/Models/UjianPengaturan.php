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
 * @property boolean $lihat_pembahasan
 * @property boolean $is_arabic
 * @property string $formula_type
 * @property string $operation_1
 * @property float $value_1
 * @property string $operation_2
 * @property float $value_2
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
    protected $fillable = [
        'metode_penilaian',
        'nilai_kelulusan',
        'hasil_ujian_tersedia',
        'acak_soal',
        'acak_jawaban',
        'lihat_hasil',
        'lihat_pembahasan',
        'is_arabic',
        'formula_type',
        'operation_1',
        'value_1',
        'operation_2',
        'value_2',
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
