@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Редактирование пользователя</h3>
                    <p class="animated fadeInDown">
                        <a href="{{ route('users.index') }}">← Вернуться к списку</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>{{ $user->username }}</h3></div>
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

                        <form id="user-edit-form" action="{{ route('users.update', $user) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="username"><strong>Имя пользователя</strong> <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="username"
                                       id="username"
                                       class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username', $user->username) }}"
                                       required>
                                @error('username')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="email"><strong>Email</strong> <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password"><strong>Пароль</strong></label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       autocomplete="new-password">
                                <small class="text-muted">Оставьте пустым — текущий пароль сохранится. При смене: минимум 10 символов, буквы разного регистра и цифры.</small>
                                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            @php $isSelf = auth()->id() === $user->id; @endphp

                            <div class="form-group">
                                <label for="role"><strong>Роль</strong> <span class="text-danger">*</span></label>
                                @if($isSelf)
                                    <input type="hidden" name="role" value="{{ $user->role->value }}">
                                    <select id="role" class="form-control" disabled>
                                        @foreach(\App\Enums\UserRole::cases() as $roleOption)
                                            <option value="{{ $roleOption->value }}" @selected($user->role === $roleOption)>
                                                {{ $roleOption->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Нельзя изменить роль своего аккаунта.</small>
                                @else
                                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                        @foreach(\App\Enums\UserRole::cases() as $roleOption)
                                            @continue($roleOption === \App\Enums\UserRole::Admin)
                                            <option value="{{ $roleOption->value }}" @selected(old('role', $user->role->value) === $roleOption->value)>
                                                {{ $roleOption->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Активен</strong> <span class="text-danger">*</span></label>
                                <div>
                                    <label style="margin-right: 20px;">
                                        <input type="radio" name="active" value="1" @checked(old('active', $user->active ? '1' : '0') == '1')> Да
                                    </label>
                                    <label>
                                        <input type="radio" name="active" value="0" @checked(old('active', $user->active ? '1' : '0') == '0')> Нет
                                    </label>
                                </div>
                                @error('active')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-3d btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('user-edit-form').addEventListener('submit', function () {
            var passwordInput = document.getElementById('password');

            if (!passwordInput.value.trim()) {
                passwordInput.disabled = true;
            }
        });
    </script>
@endsection
