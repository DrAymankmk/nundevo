<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultManual extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_service_id', 'PLT', 'RBCs', 'HB', 'HCT','MCV',
        'MCH', 'MCHC','RDW','WBCs','comment'
    ];
}
