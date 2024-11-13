@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список коментариев {{-- <a href="{{ route('admin.comments.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a> --}}</h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Текст</label>
                <input type="text" class="form-control col-form-label-sm" id="inputZip" name="message" value="{{ request('message') }}">
            </div>

            <div class="col-md-2">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Проверка</label>
                <select id="inputState" class="form-select col-form-label-sm" name="cheked">
                    <option selected value="">Все</option>
                    <option value="0" @if(request('cheked') === '0') selected @endif>Не одобреный</option>
                    <option value="1" @if(request('cheked') == 1) selected @endif>Одобреный</option>
                </select>
            </div>
{{--            <div class="col-1"></div>--}}
            <div class="col-md-1">
                <a href="/admin/comments" class="btn btn-danger mb-1">Cброс</a>
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
        <table class="table table-striped table-sm" style="text-align: center;">
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
                    Место
                </th>
                <th>
                    Ответ
                </th>
                <th>
                    Автор
                </th>
                <th colspan="2" >
                    Сообшение
                </th>
                <th>
                    Проверен
                </th>
                <th>
                    Дата
                </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td style="text-align: center;">{{ $comment->id }}</td>
                    <td style="text-align: center;">
                        <a href="{{ $comment->getItem()->myUrl() }}">
                            {{ $comment->getItem()->name }}
                        </a>
                    </td>
                    <td style="text-align: center;">
                        @if(!empty($comment->answered_msg))
                        <a href="{{ route('admin.comments.edit', $comment->answered_msg) }}">
                            {{ $comment->answered_msg}}
                        </a>
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $comment->user->name }}</td>
                    <td colspan="2" style="text-align: justify;">{{ $comment->message }}</td>
                    <td style="text-align: center;">
                        @if($comment->cheked == 1)
                            <i class="bi bi-check-circle"></i>
                        @else
                            <i class="bi bi-x-circle"></i>
                        @endif

                    </td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.comments.destroy', $comment->id) }}" pp="Комент: {{ $comment->id }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $comments->links() }}
</div>

@endsection
