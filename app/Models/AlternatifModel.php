<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_alternatif';
    protected $table = 'alternatif';
    protected $guarded = [];
    public $incrementing = false;
}
