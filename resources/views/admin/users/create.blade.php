@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Создание пользователя</h3>
                    <p class="animated fadeInDown">
                        <a href="{{ route('users.index') }}">← Вернуться к списку</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Новый пользователь</h3></div>
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin-bottom: 0;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="username"><strong>Имя пользователя</strong> <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="username"
                                       id="username"
                                       class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username') }}"
                                       required>
                                @error('username')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="email"><strong>Email</strong> <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password"><strong>Пароль</strong> <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                <small class="text-muted">Минимум 10 символов, буквы разного регистра и цифры.</small>
                                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="role"><strong>Роль</strong> <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Выберите роль</option>
                                    @foreach(\App\Enums\UserRole::cases() as $roleOption)
                                        @continue($roleOption === \App\Enums\UserRole::Admin)
                                        <option value="{{ $roleOption->value }}" @selected(old('role') === $roleOption->value)>
                                            {{ $roleOption->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Активен</strong> <span class="text-danger">*</span></label>
                                <div>
                                    <label style="margin-right: 20px;">
                                        <input type="radio" name="active" value="1" @checked(old('active', '1') == '1')> Да
                                    </label>
                                    <label>
                                        <input type="radio" name="active" value="0" @checked(old('active') === '0')> Нет
                                    </label>
                                </div>
                                @error('active')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-3d btn-success">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
