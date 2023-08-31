<?php

namespace App\Models;

use App\Models\VendorService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'location'
    ];

    public function services()
    {
        return $this->hasMany(VendorService::class);
    }
}
