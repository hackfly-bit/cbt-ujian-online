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
 * @property Peserta[] $pesertas
 * @property Sertifikat[] $sertifikats
 * @property UjianPengaturan $ujianPengaturan
 * @property UjianPesertaForm $ujianPesertaForm
 * @property UjianSection[] $ujianSections
 * @property JenisUjian $jenisUjian
 * @property HasilUjian[] $hasilUjian
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
     * @var array
     */
    protected $fillable = ['jenis_ujian_id', 'link', 'nama_ujian', 'deskripsi', 'durasi', 'tanggal_selesai', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pesertas()
    {
        return $this->hasMany('App\Models\Peserta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sertifikats()
    {
        return $this->hasMany('App\Models\Sertifikat');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisUjian()
    {
        return $this->belongsTo('App\Models\JenisUjian');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function hasilUjian()
    {
        return $this->hasMany('App\Models\HasilUjian', 'ujian_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ujianThema()
    {
        return $this->hasOne('App\Models\UjianThema', 'ujian_id');
    }


}
