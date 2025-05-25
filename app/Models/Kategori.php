<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nama
 * @property string $deskripsi
 * @property string $created_at
 * @property string $updated_at
 * @property Soal[] $soals
 * @property SubKategori[] $subKategoris
 */
class Kategori extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kategori';

    /**
     * @var array
     */
    protected $fillable = ['nama', 'deskripsi', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soals()
    {
        return $this->hasMany('App\Models\Soal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subKategoris()
    {
        return $this->hasMany('App\Models\SubKategori');
    }
}
