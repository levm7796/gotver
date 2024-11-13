@extends('admin.layout')
@section('content')
<div class="mt-5">
    <h2>Список действий <a href="{{ route('admin.tags.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a></h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Сообшение</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="message" value="">
            </div>
            <div class="col-md-2">
                <label for="inputZip2" class="form-label col-form-label-sm mb-0">Имя юзера</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip2" name="user" value="">
            </div>
            <div class="col-md-2">
                <label for="inputZip3" class="form-label col-form-label-sm mb-0">Телефон</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip3" name="phone" value="">
            </div>
            <div class="col-md-2">
                <label for="inputZip4" class="form-label col-form-label-sm mb-0">IP</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip4" name="ip" value="">
            </div>
            <div class="col-md-1">
                <a href="/admin/tags" class="btn btn-danger mb-1">Cброс</a>
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
                <th>Телефон</th>
                <th>Имя</th>
                <th>сообщение</th>
                <th>Детальная информация</th>
                <th>IP</th>
                <th>Время</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->phone }}</td>
                    <td>{{ $log->user }}</td>
                    <td>{{ $log->message }}</td>
                    <td>
                        @if (strlen( $log->data) > 10)
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $log->id }}">
                              Детали
                            </button>
                            <div class="modal fade" id="staticBackdrop{{ $log->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Детали лог №{{ $log->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                  </div>
                                  <div class="modal-body">
                                    <pre>
                                        @php
                                        $data = [];
                                        foreach(json_decode($log->data, true) as $key=>$value){
                                            $data[$key] = json_decode($value, true);
                                        }
                                        print_r($data); 
                                        @endphp
                                    </pre>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @else
                            {{ $log->data }}
                        @endif
                    </td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        <span delete-btn hreff="{{ route('admin.loging.destroy', $log->id) }}" pp="Имя: {{ $log->id }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $logs->links() }}
</div>

@endsection
