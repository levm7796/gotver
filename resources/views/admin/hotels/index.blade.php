@extends('admin.layout')
@section('content')
<div class="mt-5">
    <h2>Список объектов <a href="{{ route('admin.hotels.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
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
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="name" value="{{ request('name') }}">
            </div>
             <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Активные на момент</label>
                <input type="datetime-local" class="form-control col-form-label-sm" id="inputZip" name="activenow" value="{{ request('activenow') }}">
            </div>

            <div class="col-1">
                <a href="/admin/news" class="btn btn-danger mb-1">Cброс</a>
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>
        </div>
        {{-- <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Название</label>
                <input type="text"  class="form-control col-form-label-sm" id="inputZip" name="name" value="{{ request('name') }}">
            </div>
            <div class="col-1">
            </div>
            <div class="col-1">
                <a href="{{ route('admin.locations.index') }}" class="btn btn-danger mb-1">Cброс</a>
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>
        </div> --}}
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
                        Название
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
                <th>
                    Просмотры
                </th>
                <th alt="Клики ссылка">
                    Кс
                </th>
                <th alt="Клики телефон">
                    Кт
                </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->id }}</td>
                    <td>{{ optional($hotel->location)->name }}</td>
                    <td>{{ optional($hotel->hub)->name }}</td>
                    <td>
                        <a href="{{$hotel->myUrl()}}">
                            {{ $hotel->name }}
                        </a>
                    </td>
                    <td>
                        @if(empty($hotel->coordinates))
                            -
                        @else
                            <a href="https://yandex.ru/maps/?text={{ str_replace(' ', '', $hotel->coordinates) }}&z=13" target="_blank">
                                <i class="bi bi-geo-alt"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{ $hotel->created_at }}</td>
                    <td>{{ $hotel->viewsCount }}</td>
                    <td>{{ $hotel->link_click }}</td>
                    <td>{{ $hotel->phone_click }}</td>
                    <td>
                        <span restart-btn hreff="{{ route('admin.hotels.restart', $hotel->id) }}" pp="Вся статистика будет обноволена" class="btn btn-primary m-2">
                            <i class="bi bi-arrow-repeat"></i>
                        </span>
                        <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.hotels.destroy', $hotel->id) }}" pp="Имя: {{ $hotel->name }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash-fill"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $hotels->links() }}
</div>

@endsection
