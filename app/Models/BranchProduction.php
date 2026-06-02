<?php

namespace App\Models;

use App\Enums\BranchProductionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchProduction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'production_date',
        'id_branch',
        'id_product',
        'good_products',
        'rejected_products',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'production_date' => 'date',
            'good_products' => 'integer',
            'rejected_products' => 'integer',
            'status' => BranchProductionStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'id_branch', 'id_branch');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
