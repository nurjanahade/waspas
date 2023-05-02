<?php

namespace App\Models;

use App\Models\KriteriaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subKriteriaModel extends Model
{
    use HasFactory;
    protected $table = 'sub_kriteria';
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'cat_kriteria', 'kode_kriteria');
    }
}
