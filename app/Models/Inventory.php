<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';

    protected $fillable = [
        'material_id',
        'project_id',
        'quantity',
        'receiver',
        'purpose',
        'flow',
        'created_by',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function budget()
    {
        return $this->belongsTo(ProjectBudget::class, 'budget_id', 'budget_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
