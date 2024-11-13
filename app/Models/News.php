<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    // TYPE
    // 0 news
    // 1 articles
    // 2 anons
    use HasFactory;
    protected $fillable = ['title'];
    protected $appends = ['myUrl'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('end_date', '>', now())
                    ->orWhereNull('end_date');
        });
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function blocks() {
        return $this->hasMany(BlocksNews::class, 'news_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function hub(){
        return $this->belongsTo(Hub::class, 'hub_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function comments(){
        $comments = Comment::where('table_name', $this->getTable())->where('item_id', $this->id)->whereNull('answered_msg')->with('likes', 'user', 'answers')->orderBy('created_at', 'desc')->get();
        return $comments;
    }

    public function commentsLimit($limit){
        $comments = Comment::where('table_name', $this->getTable())->where('item_id', $this->id)->whereNull('answered_msg')->with('likes', 'user', 'answers')->orderBy('created_at', 'desc')->limit($limit)->get();
        return $comments;
    }

    public function getAllTags(){
        $tagsId = $this->tags()->get()->pluck('id')->toArray();
        $tags = Tag::whereIn('id', $tagsId)->get();
        $customTags = new Collection();
        foreach($tags as $tg){
            $customTags = $customTags->merge($tg->getSameTags());
        }
        $customTags = $customTags->unique('id');

        $filteredTags = $customTags->reject(function ($tag) use ($tagsId) {
            return in_array($tag->id, $tagsId);
        });
        return $filteredTags;
    }

    public function someItself(){
        return News::where('type', $this->type)->where('location_id', $this->location_id)->limit(5)->get();
    }

    public function getFavoritesCountAttribute()
    {
        return DB::table('favorites')
            ->where('table_name', $this->getTable())
            ->where('item_id', $this->id)
            ->count();
    }

    public function images()
    {
        return [$this->img];
    }

    public function getMyUrlAttribute(){
        if($this->type == 0)
            return '/news/'.$this->id;
        else
            return '/article/'.$this->id;
    }
    public function myUrl(){
        if($this->type == 0)
            return '/news/'.$this->id;
        else
            return '/article/'.$this->id;
    }

    public function toArray()
    {
        $array = parent::toArray(); // Получение стандартного представления

        // Добавление вычисляемого атрибута
        $array['myUrl'] = $this->myUrl();

        return $array;
    }
}
