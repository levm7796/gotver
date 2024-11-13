<?php

namespace App\Models;

use App\Http\Controllers\SettingController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;
    protected $appends = ['myUrl'];

    public function location() {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function newsAll()
    {
        return $this->hasMany(News::class, 'hub_id');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'hub_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'hub_id')->where('type', '0');
    }

    public function articles($limit = null)
    {   if(is_null($limit))
            return $this->hasMany(News::class, 'hub_id')->where('type', '1');
        return $this->hasMany(News::class, 'hub_id')->where('type', '1')->limit(5)->get();
        // return News::where('hub_id', $this->id)->where('type', '1')->limit(5)->get();
    }

    public function getAllTagsBySettings(){
        $settings = $this->getContent();
        return $this->getAllTags(optional($settings)['additional_tags_add'], optional($settings)['additional_tags_remove']);
    }

    public function getAllTags($addIds = null, $removeIds = null)
    {
        $hotels = $this->hotels()->with('tags')->get();
        $news = $this->newsAll()->with('tags')->get();

        $tags = new Collection();

        foreach ($hotels as $hotel) {
            $tags = $tags->merge($hotel->tags);
        }

        foreach ($news as $newsItem) {
            $tags = $tags->merge($newsItem->tags);
        }

        $tags = $tags->unique('id');

        if (!empty($addIds)) {
            $additionalTags = Tag::whereIn('id', $addIds)->get();
            $tags = $tags->merge($additionalTags)->unique('id');
        }

        if (!empty($removeIds)) {
            $tags = $tags->reject(function ($tag) use ($removeIds) {
                return in_array($tag->id, $removeIds);
            });
        }

        // Сортируем теги по алфавиту
        $tags = $tags->sortBy('name');

        return $tags;
    }

    public function img(){
        return optional($this->getContent())['img'];
    }


    public function getContent()
    {
        return SettingController::getContent($this->getTable(), $this->id);
    }

    public function setContent($data){
        SettingController::setContent($this->getTable(), $this->id, $data);
    }

    public function getMyUrlAttribute(){
        return '/hub/'.$this->id;
    }

    public function myUrl(){
        return '/hub/'.$this->id;
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

}
