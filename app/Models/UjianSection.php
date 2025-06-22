<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ujian_id
 * @property integer $ketegori_id
 * @property string $nama_section
 * @property float $bobot_nilai
 * @property string $instruksi
 * @property string $metode_penilaian
 * @property string $formula
 * @property boolean $is_arabic
 * @property string $formula_type
 * @property string $operation_1
 * @property float $value_1
 * @property string $operation_2
 * @property float $value_2
 * @property string $created_at
 * @property string $updated_at
 * @property UjianSectionSoal[] $ujianSectionSoals
 * @property Ujian $ujian
 * @property Kategori $ketegori
 */
class UjianSection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ujian_section';

    /**
     * @var array
     */
    protected $fillable = [
        'ujian_id',
        'kategori_id',
        'nama_section',
        'bobot_nilai',
        'instruksi',
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
     * @var array
     */
    protected $casts = [
        'is_arabic' => 'boolean',
        'value_1' => 'decimal:2',
        'value_2' => 'decimal:2'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSectionSoals()
    {
        return $this->hasMany('App\Models\UjianSectionSoal', 'ujian_section');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ketegori()
    {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id');
    }
}
