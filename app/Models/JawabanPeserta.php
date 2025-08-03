<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'ujian_id',
        'peserta_email',
        'soal_id',
        'section_id',
        'jawaban_soal_id',
        'jawaban_text',
        'dijawab_pada'
    ];

    protected $casts = [
        'dijawab_pada' => 'datetime'
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function jawabanSoal()
    {
        return $this->belongsTo(JawabanSoal::class);
    }
}
