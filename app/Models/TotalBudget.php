<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalBudget extends Model
{
    use HasFactory;
    protected $table = 'total_budgets';

    protected $fillable = [
        'material_id',
        'project_id',
        'quantity',
        'alert',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function materialUnit()
    {
        return $this->belongsTo(Measure::class, 'unit_id');
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class, 'budget_id');
    }
}
