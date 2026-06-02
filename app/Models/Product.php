<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'code',
        'name',
        'id_product_type',
        'id_unit',
        'hs_code',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_product';
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'id_product_type', 'id_product_type');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }
}
