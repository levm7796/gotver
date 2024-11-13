@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список услуги объекта <a href="{{ route('admin.options.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        {{-- <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Название</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="name" value="">
            </div>
            <div class="col-md-2">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Тип</label>
                <select id="inputState" class="form-select col-form-label-sm" name="type">
                    <option selected value="">Все</option>
                    <option value="0">Локация</option>
                    <option value="1">Новость</option>
                    <option value="2">Афиша</option>
                </select>
            </div>
            <div class="col-md-1">
                <a href="/admin/tags" class="btn btn-danger mb-1">Cброс</a>
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
                    ICO
                </th>
                <th>
                    Навзание
                </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($options as $option)
                <tr>
                    <td>{{ $option->id }}</td>
                    <td>
                        <svg width="24" height="24" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#{{ $option->ico }}"></use>
                        </svg>
                    </td>
                    <td>{{ $option->content }}</td>
                    <td>
                        <a href="{{ route('admin.options.edit', $option->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.options.destroy', $option->id) }}" pp="Название: {{ $option->content }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $options->links() }}
</div>

@endsection
