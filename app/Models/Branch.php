<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';

    protected $primaryKey = 'id_branch';

    protected $fillable = [
        'branch_name',
        'location',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_branch';
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_branch', 'id_branch');
    }
}

