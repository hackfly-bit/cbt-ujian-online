<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $soal_id
 * @property string $jenis_isian
 * @property string $jawaban
 * @property boolean $jawaban_benar
 * @property string $created_at
 * @property string $updated_at
 * @property Soal $soal
 */
class JawabanSoal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jawaban_soal';

    /**
     * @var array
     */
    protected $fillable = ['soal_id', 'jenis_isian', 'jawaban', 'jawaban_benar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soal()
    {
        return $this->belongsTo('App\Models\Soal');
    }
}
