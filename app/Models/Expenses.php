<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'date','cost_center_id','type', 'amount', 'account_id','status','notices','clinic_id','accounting_id'
    ];
}
