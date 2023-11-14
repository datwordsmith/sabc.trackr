<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplementaryBudget extends Model
{
    use HasFactory;


    protected $fillable = [
        'project_id',
        'title',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
