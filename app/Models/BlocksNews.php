<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocksNews extends Model
{
    protected $table = 'block_news';
    protected $casts = [
        'block' => 'json',
    ];

    public function news() {
        return $this->belongsTo(News::class);
    }

    use HasFactory;
}
