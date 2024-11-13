<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    protected $appends = ['countLikes'];

    public function likes()
    {
        return $this->hasMany(Like::class, 'comment_id');
    }

    public function getLikeCount()
    {
        return $this->likes()->where('like', 1)->count();
    }

    public function getDislikeCount()
    {
        return $this->likes()->where('like', 0)->count();
    }

    public function getCountLikesAttribute()
    {
        $counts = DB::table('likes')
            ->selectRaw('
                SUM(CASE WHEN `like` = 1 THEN 1 ELSE 0 END) as like_count,
                SUM(CASE WHEN `like` = 0 THEN 1 ELSE 0 END) as dislike_count
            ')
            ->where('comment_id', $this->id)
            ->first();
        $likeCount = $counts ? $counts->like_count : 0;
        $dislikeCount = $counts ? $counts->dislike_count : 0;

        return [
            'like' => $likeCount,
            'dislike' => $dislikeCount
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Comment::class, 'answered_msg', 'id')->with('user', 'likes');
    }

    public function getItem()
    {
        switch ($this->table_name) {
            case 'hotels':
                return Hotel::find($this->item_id);
            case 'news':
                return News::find($this->item_id);
            default:
                return null;
        }
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
