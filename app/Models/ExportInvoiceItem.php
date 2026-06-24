<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'export_invoice_id',
        'po_no',
        'po_dated',
        'quantity',
        'description',
        'basic_price',
        'material_surcharge',
        'amount',
    ];

    public function exportInvoice()
    {
        return $this->belongsTo(ExportInvoice::class);
    }
}
