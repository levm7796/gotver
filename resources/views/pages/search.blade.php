@extends('layout')
@section('content')
    <div class="container">
        <div class="grid-container _showmore-active" data-showmore="items">
            <div class="grid-container__inner" data-showmore-content="5" style="height: 2833px; overflow: hidden;">
                @if(isset($items))
                    @foreach($items as $index => $item)
                        <div class="card-item item-favorite @if(\Illuminate\Support\Facades\Auth::check()) @if(count(\App\Models\Favorite::where('table_name', 'hotels')->where('item_id', $item['id'])->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get()->toArray()) !==0) is-favorite @endif @endif" @if(isset($item['img'])) id="news_{{$item['id']}}" @else id="hotels_{{$item['id']}}" @endif>
                            <div class="card-item__picture">
                                <picture>
                                    <source type="image/webp"><img style="background-image: @if(isset($item['img'])) url({{$item['img']}}) @else url({{$hotelImg[$index][0]}}) @endif; background-position: center center;background-size: cover" width="456" height="278" loading="lazy">
                                </picture>
                            </div>
                            <div class="card-item__overlay"></div>
                            <div class="card-item__text"><a class="card-item__text-wrapper" href="{{$item['myUrl']}}">
                                    <p class="card-item__title">{{$item['name']}}</p>
                                    <p class="card-item__description">{{$item['description']}}</p></a>
                                <div class="card-item__info-panel">
                                    <div class="card-item__labels">
                                        <p class="label-item" data-tag="Отели Твери" data-color="red">@if(isset($item['img'])) Новости @else Объект @endif</p>
                                    </div>
                                    <div class="activity-panel">
                                        <div class="activity-panel__item">
                                            <svg width="20" height="20" aria-hidden="true">
                                                <use xlink:href="img/sprite.svg#eye"></use>
                                            </svg><span>{{$item['viewsCount']}}</span>
                                        </div>
                                        <div class="activity-panel__item">
                                            <svg width="20" height="20" aria-hidden="true">
                                                <use xlink:href="img/sprite.svg#like"></use>
                                            </svg><span>{{$item['likesCount']}}</span>
                                        </div>
                                        <div class="activity-panel__item">
                                            <svg width="20" height="20" aria-hidden="true">
                                                <use xlink:href="img/sprite.svg#comment"></use>
                                            </svg><span>{{$item['commentsCount']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="action-item" type="button" data-favorite="card" onclick="favorite(@if(isset($item['img'])) 'news' @else 'hotels' @endif, {{$item['id']}})"><span class="action-item__icon">
                              <svg width="24" height="24" aria-hidden="true">
                                <use xlink:href="img/sprite.svg#heart"></use>
                              </svg></span>
                            </button>
                        </div>
                    @endforeach
                @else
                    <h1>Ничего не найдено</h1>
                @endif
            </div>
        </div>
    </div>
    <script>
        function favorite(table, id) {
            console.log(table, id)
            let csrf = document.querySelector('meta[name="csrf-token"]').content;
            console.log(csrf)
            axios.post(`/hotel/favorite/${table}/${id}`, {
                headers: {
                    'X-CSRF-Token': csrf
                }
            }).then(res=>{
                if(res.data) {
                    if(table === 'hotels') {
                        document.getElementById('hotels_'+id).classList.add('is-favorite')
                    } else {
                        document.getElementById('news_'+id).classList.add('is-favorite')
                    }
                } else {
                    if(table === 'hotels') {
                        document.getElementById('hotels_'+id).classList.remove('is-favorite')
                    } else {
                        document.getElementById('news_'+id).classList.remove('is-favorite')
                    }
                }
            })
        }
    </script>
@endsection
