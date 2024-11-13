<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class newsTag extends Model
{
    protected $table = 'news_tag';
    use HasFactory;
    function news() {
        return $this->belongsToMany(News::class, 'news_tag', 'new_id', 'tag_id');
    }
    function tags() {
        return $this->belongsToMany(Tag::class, 'news_tag', 'tag_id', 'new_id');
    }
}
