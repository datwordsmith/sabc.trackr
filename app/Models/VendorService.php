<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorService extends Model
{
    use HasFactory;

    protected $table = 'vendor_services';

    protected $fillable = [
        'vendor_id',
        'service'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
