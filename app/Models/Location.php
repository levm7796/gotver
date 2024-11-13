<?php

namespace App\Models;

use App\Http\Controllers\SettingController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $appends = ['myUrl'];

    public function hubs()
    {
        return $this->hasMany(Hub::class, 'location_id', 'id');
    }

    public function images() {
        return Images::where('table', $this->getTable())->where('table_id', $this->id)->pluck('img');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'location_id', 'id');
    }

    public function newsAll()
    {
        return $this->hasMany(News::class, 'location_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'location_id')->where('type', '0');
    }

    public function articles()
    {
        return $this->hasMany(News::class, 'location_id')->where('type', '1');
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

    public function selectedHubs(){
        $content = $this->getContent();
        $hubsIds = isset($content['hubs']) ? $content['hubs'] : [];
        $hubs = [];
        foreach ($hubsIds as $hubId) {
            $hub = Hub::where('id', $hubId)->first();
            if($hub){
               $hubs[] = $hub;
            }
        }
        return $hubs;
    }

    public function getContent()
    {
        return SettingController::getContent($this->getTable(), $this->id);
    }

    public function setContent($data){
        SettingController::setContent($this->getTable(), $this->id, $data);
    }

    public function getSameTags(){

    }

    public function getMyUrlAttribute(){
        return '/location/'.$this->id;
    }

    public function myUrl(){
        return '/location/'.$this->id;
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
