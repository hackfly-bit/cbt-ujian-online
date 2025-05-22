<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ujian_id
 * @property boolean $nama
 * @property boolean $phone
 * @property boolean $email
 * @property boolean $institusi
 * @property boolean $nomor_induk
 * @property boolean $tanggal_lahir
 * @property boolean $alamat
 * @property boolean $foto
 * @property string $created_at
 * @property string $updated_at
 * @property Ujian $ujian
 */
class UjianPesertaForm extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ujian_peserta_form';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ujian_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nama', 'phone', 'email', 'institusi', 'nomor_induk', 'tanggal_lahir', 'alamat', 'foto', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian');
    }
}
