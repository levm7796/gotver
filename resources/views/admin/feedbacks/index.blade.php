@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список запросов обратной связи {{-- <a href="{{ route('admin.feedbacks.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a> --}}</h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Имя</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="name" value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Почта</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="mail" value="{{ request('mail') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Фраза в сообшение</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="msg" value="{{ request('msg') }}">
            </div>
            <div class="col-md-1">
                <a href="/admin/feedbacks" class="btn btn-danger mb-1">Cброс</a>
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
                    Имя
                </th>
                <th>
                    Почта
                </th>
                <th>
                    Сообшение
                </th>
                <th>
                    @php $key = 'created_at'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Время
                        @if(request('s', 'order') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->name }} </td>
                    <td>{{ $feedback->email }}</td>
                    <td> {{ $feedback->message }} </td>
                    <td> {{ $feedback->created_at }} </td>
                    <td>
                        {{-- <a href="{{ route('admin.feedbacks.edit', $feedback->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a> --}}
                        <span delete-btn hreff="{{ route('admin.feedbacks.destroy', $feedback->id) }}" pp="Фитбэк ИД {{ $feedback->id }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $feedbacks->links() }}
</div>

@endsection
