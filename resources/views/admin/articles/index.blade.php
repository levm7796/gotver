@extends('admin.layout')
@section('content')
<div class="mt-5">
    <h2>Список статей <a href="{{ route('admin.articles.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Локация</label>
                <select id="inputState" class="form-select col-form-label-sm" name="location_id">
                    <option selected value="">Все</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" @if(request('location_id') == $location->id) checked @endif>{{ $location->name }}</option>
                    @endforeach
               </select>
           </div>
            <div class="col-md-2">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Хабовая</label>
                <select id="inputState" class="form-select col-form-label-sm" name="hub_id">
                    <option selected value="">Все</option>
                    @foreach($hubs as $hub)
                        <option value="{{ $hub->id }}" @if(request('hub_id') == $hub->id) checked @endif>
                            {{ optional($hub->location)->name }} | {{ $hub->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Название</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="name" value="">
            </div>

            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Активные на момент</label>
                <input type="datetime-local" class="form-control col-form-label-sm" id="inputZip" name="activenow" value="{{ request('activenow') }}">
            </div>

            <div class="col-1">
                <a href="/admin/articles" class="btn btn-danger mb-1">Cброс</a>
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>
        </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
                <th>
                    @php $key = 'id'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        #Id
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>Локация</th>
                <th>Хабовая</th>
                <th>
                    @php $key = 'name'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        #Название
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>
                    @php $key = 'author'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Автор
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>

                <th>
                    <i class="bi bi-geo-alt"></i>
                </th>

                <th>
                    @php $key = 'data'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Дата
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
{{--                <th>Иконка</th>--}}
                <th>Просмотры</th>
                <th>
                    @php $key = 'order'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'asc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Очередность
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'asc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($articles as $new)
                <tr>
                    <td>{{ $new->id }}</td>
                    <td>
                        <a href="{{$new->location->myUrl()}}">
                            {{ $new->location->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{$new->hub->myUrl()}}">
                            {{ $new->hub->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{$new->myUrl()}}">
                            {{ $new->name }}
                        </a>
                    </td>
                    <td>{{ $new->user->name }}</td>
                    <td>
                        @if(empty($new->coordinates))
                            -
                        @else
                            <a href="https://yandex.ru/maps/?text={{ str_replace(' ', '', $new->coordinates) }}&z=13" target="_blank">
                                <i class="bi bi-geo-alt"></i>
                            </a>
                        @endif
                    </td>
                    <td>
                        {{ $new->created_at }}<br>
                        {{ $new->end_date }}
                    </td>
                    <td>{{ $new->viewsCount }}</td>
                    <td>{{ $new->order }}</td>
                    <td>
                        <span restart-btn hreff="{{ route('admin.articles.restart', $new->id) }}" pp="Вся статистика будет обноволена" class="btn btn-primary m-2">
                            <i class="bi bi-arrow-clockwise"></i>
                        </span>
                        <a href="{{ route('admin.articles.edit', $new->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.articles.destroy', $new->id) }}" pp="Имя: {{ $new->name }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $articles->links() }}
</div>

@endsection
