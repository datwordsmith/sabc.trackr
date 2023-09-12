<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $table = 'allocations';

    protected $fillable = [
        'material_id',
        'project_id',
        'quantity',
        'receiver',
        'purpose',
        'flow',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
