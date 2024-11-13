@extends('admin.layout')
@section('content')
<div class="mt-5">
    <h2>Список историй <a href="{{ route('admin.histories.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Шаблон</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="pattern" value="{{ request('pattern') }}">
            </div>

            <div class="col-md-1">
                <a href="/admin/histories" class="btn btn-danger mb-1">Cброс</a>
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
                <th>
                    @php $key = 'pattern'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Шаблон
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>
                    Историй
                </th>
                <th>
                    @php $key = 'order'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Очередность
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($histories as $hostory)
                <tr>
                    <td>{{ $hostory->id }}</td>
                    <td>{{ $hostory->pattern }}</td>
                    <td>{{ count(json_decode(json_decode($hostory->content))) }}</td>
                    <td>{{ $hostory->order }}</td>
                    <td>
                        <a href="{{ route('admin.histories.edit', $hostory->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.histories.destroy', $hostory->id) }}" pp="Имя: {{ $hostory->name }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $histories->links() }}
</div>

@endsection
