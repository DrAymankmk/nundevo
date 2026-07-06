<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleInvoice extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='sale_invoices';
    protected $guarded = [];


    public function saleInvoiceItems()
    {
        return $this->hasMany('App\Models\SaleInvoiceItem','sale_invoice_id');
    }

}
