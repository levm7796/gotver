<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelSocial extends Model
{
    use HasFactory;
    protected $table = 'hotel_social';

    public function hotels() {
        return $this->belongsTo(Hotel::class);
    }
}
