<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ujian_id
 * @property string $image_bg
 * @property mixed $template
 * @property string $created_at
 * @property string $updated_at
 * @property HasilUjian[] $hasilUjians
 * @property Ujian $ujian
 */
class Sertifikat extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sertifikat';

    /**
     * @var array
     */
    protected $fillable = ['ujian_id', 'image_bg', 'template', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasilUjians()
    {
        return $this->hasMany('App\Models\HasilUjian');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }
}
