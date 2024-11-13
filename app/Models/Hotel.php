<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Hotel extends Model
{
    use HasFactory;

//    public function images() {
//        return $this->hasMany(Images::class, 'hotels_id');
//    }
    // Для старых версий Laravel
    protected $dates = ['created_at', 'updated_at', 'end_date'];

    // Для новых версий Laravel
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = ['myUrl'];
    public function places() {
        return $this->hasMany(Places::class, 'hotels_id')->orderBy('id');
    }

    public function images() {
        return Images::where('table', $this->getTable())->where('table_id', $this->id)->pluck('img');
    }

    public static function searchImages($id) {
        return Images::where('table', 'hotels')->where('table_id', $id)->pluck('img')->take(1)->toArray();
    }

    public function thumbImages() {
        return Images::where('table', $this->getTable().'_thumb')->where('table_id', $this->id)->pluck('img');
    }
    public function getThumbImgAttribute() {
        return Images::where('table', $this->getTable())->where('table_id', $this->id)->first()->img;
    }

    public function social() {
        return $this->hasMany(HotelSocial::class, 'hotels_id')->orderBy('id');
    }

    public function options() {
        return $this->belongsToMany(Option::class);
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function hub(){
        return $this->belongsTo(Hub::class, 'hub_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function someArticles(){
        return News::where('type', '1')->where('location_id', $this->location_id)->get();
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

    public function getMyUrlAttribute(){
        return '/object/'.$this->id;
    }
    public function myUrl(){
        return '/object/'.$this->id;
    }

    public function toArray()
    {
        $array = parent::toArray(); // Получение стандартного представления

        // Добавление вычисляемого атрибута
        $array['myUrl'] = $this->myUrl();

        return $array;
    }

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
}
