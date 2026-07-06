<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restrictions extends Model
{
    use HasFactory;

    public $fillable = ['credit', 'debit', 'process','account_type','daily_entry_id','final_accounts','cost_center_id','account_balance','reference','notice','clinic_id','account_id'];

    function accounts()
    {
        return $this->belongsTo(AccountsTree::class,'final_accounts');
    }

    function center()
    {
        return $this->belongsTo(CostCenters::class,'cost_center_id');
    }

    function daily_entry()
    {
        return $this->belongsTo(DailyEntry::class);
    }
}
