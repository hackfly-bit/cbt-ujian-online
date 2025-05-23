<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ujian_id
 * @property string $nama_section
 * @property float $bobot_nilai
 * @property string $instruksi
 * @property string $metode_penilaian
 * @property string $created_at
 * @property string $updated_at
 * @property Ujian $ujian
 * @property UjianSectionSoal[] $ujianSectionSoals
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
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['ujian_id', 'nama_section', 'bobot_nilai', 'instruksi', 'metode_penilaian', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSectionSoals()
    {
        return $this->hasMany('App\Models\UjianSectionSoal', 'ujian_section');
    }
}
