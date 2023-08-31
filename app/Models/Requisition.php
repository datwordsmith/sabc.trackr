<?php

namespace App\Models;

use App\Models\TotalBudget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'quantity',
        'activity',
        'status',
        'vendor_id',
    ];

    public function budget()
    {
        return $this->belongsTo(TotalBudget::class, 'budget_id');
    }

}
