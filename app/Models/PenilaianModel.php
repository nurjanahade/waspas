<?php

namespace App\Models;

use App\Models\subKriteriaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianModel extends Model
{
    use HasFactory;
    protected $table = 'penilaian';
    protected $guarded = [];

    public function sub()
    {
        return $this->belongsTo(subKriteriaModel::class, 'sub_kriteria', 'id');
    }
}
