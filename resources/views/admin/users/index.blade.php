@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Список пользователей <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a> <a href="{{ route('admin.users.export') }}" traget="_blank" class="btn btn-success"><i class="bi bi-filetype-csv"></i></a> </h2>
    <form action="" autocomplete="off">
        <div class="mt-2 mb-3 row gy-2 gx-3 align-items-center">
            <div class="col-md-2">
                <label for="inputZip" class="form-label col-form-label-sm mb-0">Имя</label>
                <input type="text"  class="form-control col-form-label-sm" id="inputZip" name="name" value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip2" class="form-label col-form-label-sm mb-0">E-mail</label>
                <input type="text"  class="form-control col-form-label-sm" id="inputZip2" name="email" value="{{ request('email') }}">
            </div>
            <div class="col-md-2">
                <label for="inputZip2" class="form-label col-form-label-sm mb-0">Телефон</label>
                <input type="text"  class="form-control col-form-label-sm" id="inputZip2" name="phone" value="{{ request('phone') }}">
            </div>
            <div class="col-md-1">
                <label for="inputState" class="form-label col-form-label-sm mb-0">Привилегии</label>
                <select id="inputState" class="form-select col-form-label-sm" name="role">
                    <option @if(!request('role')) selected @endif value> Все</option>
                    <option value="1" @if(request('role') == 1) selected @endif>Admin</option>
                    <option value="2" @if(request('role') == 2) selected @endif>Moderator</option>
                    <option value="3" @if(request('role') == 3) selected @endif>User</option>
                </select>
            </div>
            <div class="col-1">
            </div>
            <div class="col-1">
                <a href="{{ route('admin.users.index') }}" class="btn btn-danger mb-1">Cброс</a>
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
                        @if(request('s', 'id') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>
                    @php $key = 'email'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Почта
                        @if(request('s', 'id') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
                <th>
                    Телефон
                </th>
                <th>
                    @php $key = 'name'; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['s' => $key, 'd' => (request('d', 'desc') == 'asc' ? 'desc' : 'asc'), 'page' => 1]) }}">
                        Имя
                        @if(request('s', 'id') == $key)
                            @if(request('d', 'desc') == 'asc')&#8593; @else &#8595; @endif
                        @endif
                    </a>
                </th>
              <th>Привилегии</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @if($user->role_id == 1)
                            Admin
                        @elseif($user->role_id == 2)
                            Moderator
                        @else
                            User
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary m-2">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span delete-btn hreff="{{ route('admin.users.destroy', $user->id) }}" pp="Имя: {{ $user->name }}" class="btn btn-danger m-2">
                            <i class="bi bi-trash"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
      {{ $users->links() }}
</div>

@endsection
