<?php

namespace App\Models;

use App\Models\User;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'client',
        'start_date',
        'expected_delivery_date',
        'status',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->with('role');
    }

    public function budgets()
    {
        return $this->hasMany(ProjectBudget::class);
    }


}
