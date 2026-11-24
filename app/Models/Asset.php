<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'ip_address',
        'location',
        'firmware_version',
        'status',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
