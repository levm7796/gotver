<?php

namespace App\Models;

use App\Http\Controllers\SettingController;
use App\Services\MyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
//     TYPE
//     0 - Location
//     1 - New
//     2 - Post
    protected $table = 'tags';
    use HasFactory;

    protected $appends = ['myUrl'];

    public function news(){
        return $this->belongsToMany(News::class);
    }

    public function hotels(){
        return $this->belongsToMany(Hotel::class);
    }

    public function getContent()
    {
        return SettingController::getContent($this->getTable(), $this->id);
    }

    public function setContent($data){
        SettingController::setContent($this->getTable(), $this->id, $data);
    }
    public function getMyUrlAttribute(){
        return '/location/'.$this->id;
    }
    public function myUrl(){
        return '/tag/'.$this->id;
    }
    /**
    * Получает теги, которые совпадают с заданными условиями.
    *
    * @param  array|null  $type      Массив идентификаторов типов тегов, которые нужно включить. Если `null`, то условие по типу не применяется.
    * @param  array|null  $include   Массив идентификаторов тегов, которые нужно включить в результат. Если `null`, то это условие не применяется.
    * @param  array|null  $exclude   Массив идентификаторов тегов, которые нужно исключить из результата. Если `null`, то это условие не применяется.
    * @return \Illuminate\Database\Eloquent\Collection  Коллекция моделей тегов, которые соответствуют заданным условиям.
    *
    *  * @example
    * // Получить все смежные теги с типами ['0', '1'], которые включают теги с ID [10, 20] и исключают теги с ID [30]
    * $tags = getSameTags(['0', '1'], [10, 20], [30]);
    *
    *
    **/
    public function getSameTags($type = null, $include = null, $exclude = null){
        $tag = $this;
        $tags = Tag::query()->where('id', '!=', $tag->id);

        // Применяем условие по типам тегов, если задано
        if($type){
            $tags->whereIn('type', $type);
        }

        //условие по soundex
        $tags->where(function (Builder $query) use ($tag) {
            foreach (explode('|', $tag->soundex) as $key => $word) {
                if($key == 0){
                    $query->where('soundex', 'like', '%'.$word.'%');
                } else {
                    $query->orWhere('soundex', 'like', '%'.$word.'%');
                }
            }
        });

        // Принудительное включение тегов по массиву идентификаторов, если задано
        if (!empty($include)) {
            $tags->orWhereIn('id', $include);
        }

        // Исключение тегов по массиву идентификаторов, если задано
        if (!empty($exclude)) {
            $tags->whereNotIn('id', $exclude);
        }

        $tags->orderBy('name', 'asc');

        return $tags->get();
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });

        // static::created(function ($model) {
        //     $model->soundex = $model->mySoundex($model->name);
        //     $model->save();
        // });

        // static::updated(function ($model) {
        //     $model->soundex = $model->mySoundex($model->name);
        //     $model->save();
        // });
    }

    public function mySoundex($string){
        $fragment = explode(' ', $string);
        $filteredFragment = array_filter($fragment, function($word) {
            return strlen($word) > 3;
        });
        $soundexFragment = array_map(function($word) {
            return soundex(MyService::transliterate($word));
        }, $filteredFragment);
        return implode('|',$soundexFragment);
    }

}
