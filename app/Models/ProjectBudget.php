<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectBudget extends Model
{
    use HasFactory;

    protected $table = 'project_budgets';

    protected $fillable = [
        'material_id',
        'project_id',
        'quantity',
        'isApproved',
        'isExtra',
        'alert',
        'created_by',
    ];

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
        return $this->hasMany(Requisition::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
