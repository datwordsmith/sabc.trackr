<?php

namespace App\Models;

use App\Models\Measure;
use App\Models\MaterialCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'unit_id'
    ];

    public function unit()
    {
        return $this->belongsTo(Measure::class);
    }

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }


}
