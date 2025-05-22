<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tingkat_kesulitan_id
 * @property integer $kategori_id
 * @property integer $sub_kategori_id
 * @property string $jenis_font
 * @property string $pertanyaan
 * @property boolean $is_audio
 * @property string $audio_file
 * @property string $penjelasan_jawaban
 * @property string $tag
 * @property string $created_at
 * @property string $updated_at
 * @property JawabanSoal[] $jawabanSoals
 * @property TingkatKesulitan $tingkatKesulitan
 * @property Kategori $kategori
 * @property SubKategori $subKategori
 * @property UjianSectionSoal[] $ujianSectionSoals
 */
class Soal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'soal';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tingkat_kesulitan_id', 'kategori_id', 'sub_kategori_id', 'jenis_font', 'pertanyaan', 'is_audio', 'audio_file', 'penjelasan_jawaban', 'tag', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jawabanSoals()
    {
        return $this->hasMany('App\Models\JawabanSoal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tingkatKesulitan()
    {
        return $this->belongsTo('App\Models\TingkatKesulitan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subKategori()
    {
        return $this->belongsTo('App\Models\SubKategori');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSectionSoals()
    {
        return $this->hasMany('App\Models\UjianSectionSoal');
    }
}
