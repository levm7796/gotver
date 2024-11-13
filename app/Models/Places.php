<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $table = 'hotel_places';

    public function hotels() {
        return $this->belongsTo(Hotel::class);
    }
}
