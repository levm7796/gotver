@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список локаций <a href="{{ route('admin.locations.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
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
                <th>
                    @php $key = 'name'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Название
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>Иконка</th>
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
            @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>
                        <svg width="24" height="24" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#{{ $location->icon }}"></use>
                        </svg>
                    </td>
                    <td>{{ $location->order }}</td>
                    <td>
                        <a href="{{ route('admin.locations.edit', $location->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.locations.destroy', $location->id) }}" pp="Имя: {{ $location->name }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $locations->links() }}
</div>

@endsection
