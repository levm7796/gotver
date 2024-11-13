<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class advertising extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function CNews()
    {
        $ids = explode(',', $this->news);
        $ids = array_filter($ids);
        return News::whereIn('id', $ids)->get();
    }

    public function CArticles()
    {
        $ids = explode(',', $this->articles);
        $ids = array_filter($ids);
        return News::whereIn('id', $ids)->get();
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
