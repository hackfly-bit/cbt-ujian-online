<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $kategori_id
 * @property string $nama
 * @property string $deskripsi
 * @property string $created_at
 * @property string $updated_at
 * @property Soal[] $soals
 * @property Kategori $kategori
 */
class SubKategori extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sub_kategori';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['kategori_id', 'nama', 'deskripsi', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soals()
    {
        return $this->hasMany('App\Models\Soal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori');
    }
}
