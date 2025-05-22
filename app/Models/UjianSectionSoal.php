<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $soal_id
 * @property integer $ujian_section
 * @property string $created_at
 * @property string $updated_at
 * @property Soal $soal
 * @property UjianSection $ujianSection
 */
class UjianSectionSoal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ujian_section_soal';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['soal_id', 'ujian_section', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soal()
    {
        return $this->belongsTo('App\Models\Soal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujianSection()
    {
        return $this->belongsTo('App\Models\UjianSection', 'ujian_section');
    }
}
