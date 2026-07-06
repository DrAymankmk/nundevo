<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsExchange extends Model
{
    use HasFactory;

    public $fillable = ['points','price','status'];

}
