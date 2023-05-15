<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiQiModel extends Model
{
    use HasFactory;
    protected $table = 'nilai_qi';
    protected $guarded = [];

    public function alternatif()
    {
        return $this->belongsTo(AlternatifModel::class, 'kode_alternatif', 'kode_alternatif');
    }
}
