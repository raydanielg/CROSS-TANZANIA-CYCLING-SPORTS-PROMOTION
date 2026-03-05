<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemStat extends Model
{
    protected $fillable = [
        'cpu_usage',
        'memory_usage',
        'storage_usage',
    ];
}
