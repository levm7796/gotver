@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование пользователя</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.users.edit', $user->id) }}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Аватарка:</label>
                <div class="col-sm-10">
                    <span class="" style="display: flex;align-items: center;gap: 10px;">
                        @if($user->validAvatar)
                            <img src="{{ $user->validAvatar }}" alt="">
                        @endif
                        <span style="width: 100%;">
                            <input type="file" class="form-control" placeholder="Имя" name="avatar" >
                            <div class="form-check">
                                <input type="hidden" name="delete_ava" value="0">
                                <input type="checkbox" id="phoneConfirmation0" value="1" class="form-check-input" name="delete_ava"
                                    {{ old('delete_ava') ? 'checked' : '' }}>
                                <label class="form-check-label" for="phoneConfirmation0">Просто удалить и вернуть стандартную</label>
                            </div>
                        </span>
                    </span>
                </div>
                @if ($errors->has('avatar'))
                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Имя:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Имя" name="name"
                        value="{{ old('name') ? old('name') : $user->name }}">
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Почта:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" placeholder="Почта" name="email"
                        value="{{ old('email') ? old('email') : $user->email }}">
                </div>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <phone-input
                name="phone"
                :value="{{ json_encode(old('phone', $user->phone)) }}"
                :error="{{ json_encode($errors->first('phone')) }}">
            </phone-input>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Пароль:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder="Новый пароль или оставьте пустым"
                        name="password" value="{{ old('password') ? old('password') : '' }}">
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Привилегии:</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Привилегии" name="role_id">
                        <option value="2"
                            {{ 3 == (old('role_id') ? old('role_id') : $user->role_id) ? 'selected' : '' }}>User
                        </option>
                        <option value="2"
                            {{ 2 == (old('role_id') ? old('role_id') : $user->role_id) ? 'selected' : '' }}>Moderator
                        </option>
                        <option value="1"
                            {{ 1 == (old('role_id') ? old('role_id') : $user->role_id) ? 'selected' : '' }}>Admin</option>
                    </select>
                    @if ($errors->has('role_id'))
                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                    @endif
                </div>
                <div class="form-group mt-3 row">
                    <div class="col-sm-6 ">
                        <div class="form-check">
                            <input type="hidden" name="phone_verified_at" value="0">
                            <input type="checkbox" id="phoneConfirmation" value="1" class="form-check-input" name="phone_verified_at"
                                {{ old('phone_verified_at', $user->phone_verified_at) ? 'checked' : '' }}>
                            <label class="form-check-label" for="phoneConfirmation">Телефон поддтвержден</label>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-check">
                            <input type="hidden" name="email_verified_at" value="0">
                            <input type="checkbox" id="phoneConfirmation2" value="1" class="form-check-input" name="email_verified_at"
                                {{ old('email_verified_at', $user->email_verified_at) ? 'checked' : '' }}>
                            <label class="form-check-label" for="phoneConfirmation2">Почта поддтверждена</label>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3 row">
                    <div class="col-sm-6 ">
                        <div class="form-check">
                            <input type="hidden" name="permission_email" value="0">
                            <input type="checkbox" id="phoneConfirmation3" value="1" class="form-check-input" name="permission_email"
                                {{ old('permission_email', $user->permission_email) ? 'checked' : '' }}>
                            <label class="form-check-label" for="phoneConfirmation3">Разрешение почтовой рассылки</label>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-check">
                            <input type="hidden" name="permission_sms" value="0">
                            <input type="checkbox" id="phoneConfirmation4" value="1" class="form-check-input" name="permission_sms"
                                {{ old('permission_sms', $user->permission_sms) ? 'checked' : '' }}>
                            <label class="form-check-label" for="phoneConfirmation4">Разрешение смс рассылки</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-sm-offset-2 col-sm-1">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                    <div class="col-sm-offset-2 col-sm-1">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
        </form>
    </div>
@endsection
