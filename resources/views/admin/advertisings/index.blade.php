@extends('admin.layout')
@section('content')
<div class="mt-5">
    <h2>Список пользовательских реклам <a href="{{ route('admin.advertisings.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Название</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="name" value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Имя пользователя</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="user" value="{{ request('user') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Телефон пользователя</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="phone" value="{{ request('phone') }}">
            </div>
             <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Активные на момент(по Объекту)</label>
                <input type="datetime-local" class="form-control col-form-label-sm" id="inputZip" name="activenow" value="{{ request('activenow') }}">
            </div>

            <div class="col-md-1">
                <a href="/admin/advertisings" class="btn btn-danger mb-1">Cброс</a>
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
                <th>Название</th>
                <th>
                    @php $key = 'user_id'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Пользователь
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>
                    @php $key = 'hotel_id'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Объект
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
              <th style="text-align: center;">Даты по объекту</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($advertisings as $advertising)
                <tr>
                    <td>{{ $advertising->id }}</td>
                    <td>{{ $advertising->name }}</td>
                    <td>{{ $advertising->user->name }}</td>
                    <td>
                        <a style="margin-right: 5px;" href="{{ route('admin.hotels.index') }}?id={{$advertising->hotel->id}}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ $advertising->hotel->myUrl() }}">
                            {{ $advertising->hotel->name }}
                        </a>
                    </td>
                    <td style="text-align: center;">
                        {{ $advertising->hotel->created_at }}<br>
                        {{ isset($advertising->hotel->date_end) ? $advertising->hotel->date_end : '-' }}
                    </td>

                    <td>
                        <a href="{{ route('admin.advertisings.edit', $advertising->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.advertisings.destroy', $advertising->id) }}" pp="Имя: {{ $advertising->id }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $advertisings->links() }}
</div>

@endsection
