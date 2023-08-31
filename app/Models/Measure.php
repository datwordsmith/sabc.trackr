<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measure extends Model
{
    use HasFactory;

    protected $table = 'measures';

    protected $fillable = [
        'name'
    ];

    public function measures()
    {
        return $this->hasMany(Material::class);
    }
}
