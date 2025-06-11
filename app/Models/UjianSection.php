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
    protected $fillable = ['ujian_id', 'kategori_id','nama_section', 'bobot_nilai', 'instruksi', 'metode_penilaian', 'formula', 'created_at', 'updated_at'];

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
