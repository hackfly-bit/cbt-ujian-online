<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $jenis_ujian_id
 * @property string $link
 * @property string $nama_ujian
 * @property string $deskripsi
 * @property integer $durasi
 * @property string $tanggal_selesai
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @property Pesertum[] $pesertas
 * @property Sertifikat[] $sertifikats
 * @property JenisUjian $jenisUjian
 * @property UjianPengaturan $ujianPengaturan
 * @property UjianPesertaForm $ujianPesertaForm
 * @property UjianSection[] $ujianSections
 */
class Ujian extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ujian';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['jenis_ujian_id', 'link', 'nama_ujian', 'deskripsi', 'durasi', 'tanggal_selesai', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pesertas()
    {
        return $this->hasMany('App\Models\Pesertum');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sertifikats()
    {
        return $this->hasMany('App\Models\Sertifikat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisUjian()
    {
        return $this->belongsTo('App\Models\JenisUjian');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ujianPengaturan()
    {
        return $this->hasOne('App\Models\UjianPengaturan', 'ujian_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ujianPesertaForm()
    {
        return $this->hasOne('App\Models\UjianPesertaForm', 'ujian_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSections()
    {
        return $this->hasMany('App\Models\UjianSection');
    }
}
