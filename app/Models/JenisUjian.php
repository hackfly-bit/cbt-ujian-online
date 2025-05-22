<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nama
 * @property string $deskripsi
 * @property string $created_at
 * @property string $updated_at
 * @property Ujian[] $ujians
 */
class JenisUjian extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jenis_ujian';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nama', 'deskripsi', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujians()
    {
        return $this->hasMany('App\Models\Ujian');
    }
}
