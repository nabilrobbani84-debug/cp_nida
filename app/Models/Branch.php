<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id_branch';

    protected $fillable = [
        'branch_name',
        'location',
    ];
}

