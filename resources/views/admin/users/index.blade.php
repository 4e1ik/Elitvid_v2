@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Пользователи</h3>
                </div>
                <ul class="nav navbar-nav">
                    <a href="{{ route('users.create') }}">
                        <button type="button" class="btn btn-3d btn-sm btn-success">
                            <span class="fa fa-plus"></span> Создать пользователя
                        </button>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Список пользователей</h3></div>
                    <div class="panel-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin-bottom: 0;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="responsive-table">
                            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Роль</th>
                                    <th>Активен</th>
                                    <th>Создан</th>
                                    <th style="text-align: center; width: 140px;">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @php
                                                $roleClass = match($user->role->value) {
                                                    'admin' => 'label-primary',
                                                    'manager' => 'label-warning',
                                                    default => 'label-default',
                                                };
                                            @endphp
                                            <span class="label {{ $roleClass }}">{{ $user->role->label() }}</span>
                                        </td>
                                        <td>
                                            @if($user->active)
                                                <span class="label label-success">Да</span>
                                            @else
                                                <span class="label label-danger">Нет</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at?->format('d.m.Y H:i') }}</td>
                                        <td style="text-align: center; white-space: nowrap;">
                                            <a href="{{ route('users.edit', $user) }}"
                                               class="btn btn-3d btn-sm btn-primary"
                                               title="Редактировать"
                                              
                                               style="margin-right: 5px;">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}"
                                                  method="post"
                                                 
                                                  style="display: inline-block; margin: 0; vertical-align: top;"
                                                  onsubmit="return confirm('Удалить пользователя {{ $user->username }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-3d btn-sm btn-danger"
                                                        title="Удалить"
                                                        @if(auth()->id() === $user->id) disabled @endif>
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Пользователи не найдены</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
