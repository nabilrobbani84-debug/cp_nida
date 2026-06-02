<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table = 'units';

    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'name',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_unit';
    }
}
