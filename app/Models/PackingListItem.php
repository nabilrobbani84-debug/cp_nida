<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_id',
        'order_number',
        'description',
        'length',
        'width',
        'height',
        'gross_weight',
        'net_weight',
        'quantity',
    ];

    public function packingList()
    {
        return $this->belongsTo(PackingList::class);
    }
}
