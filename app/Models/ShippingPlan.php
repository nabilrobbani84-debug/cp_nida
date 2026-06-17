<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPlan extends Model
{
    use HasFactory;

    protected $fillable = ['po_number', 'shipping_date', 'status', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoice()
    {
        return $this->hasOne(ExportInvoice::class);
    }

    public function packingList()
    {
        return $this->hasOne(PackingList::class);
    }

    public function booking()
    {
        return $this->hasOne(VesselBooking::class);
    }
}
