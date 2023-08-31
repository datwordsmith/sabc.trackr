<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $table = 'material_category';

    protected $fillable = [
        'category',
        'slug',
    ];


    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }
}
