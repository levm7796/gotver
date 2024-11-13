@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список редиректов <a href="{{ route('admin.redirects.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Откуда</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="from" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Куда</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="to" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Код</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="to" value="{{ request('code') }}">
            </div>
            <div class="col-md-2">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Статус</label>
                <select id="inputState" class="form-select col-form-label-sm" name="active">
                    <option selected value="">Все</option>
                    <option value="0" @if(request('active') == 0) selected @endif>Отключен</option>
                    <option value="1" @if(request('active') == 1) selected @endif>Активен</option>
                </select>
            </div>

            <div class="col-md-1">
                <a href="/admin/redirects" class="btn btn-danger mb-1">Cброс</a>
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
                <th>
                    Откуда
                </th>
                <th>
                    Куда
                </th>
                <th>
                    Код
                </th>
                <th>
                    Вкл
                </th>
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
            @foreach ($redirects as $redirect)
                <tr>
                    <td>{{ $redirect->id }}</td>
                    <td>{{ $redirect->from }}</td>
                    <td>
                        {{ $redirect->to }}
                    </td>
                    <td>
                        {{ $redirect->code }}
                    </td>
                    <td>{!! $redirect->active ? '<i style="color:#00ff1e" class="bi bi-check-circle-fill"></i>' : '<i style="color:#ff0000" class="bi bi-x-circle-fill"></i>' !!}</td>
                    <td>{{ $redirect->order }}</td>
                    <td>
                        <a href="{{ route('admin.redirects.edit', $redirect->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.redirects.destroy', $redirect->id) }}" pp="Редирект с: {{ $redirect->from }}, Редирект на: {{ $redirect->to }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $redirects->links() }}
</div>

@endsection
