<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselBooking extends Model
{
    use HasFactory;

    protected $fillable = ['shipping_plan_id', 'booking_number', 'booking_date', 'created_by'];

    public function shippingPlan()
    {
        return $this->belongsTo(ShippingPlan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
