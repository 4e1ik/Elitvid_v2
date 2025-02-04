@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Список постов</h3>
                </div>
                <ul class="nav navbar-nav">
                    {{--                    {{$route_name = \Illuminate\Support\Facades\Route::currentRouteName()}}--}}
                    <a href="{{route('blogs.create')}}">
                        <button class="btn ripple btn-outline btn-primary">
                            <div>
                                <span>Создать пост</span>
                                <span class="ink"></span>
                            </div>
                        </button>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Посты</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Заголовок</th>
                                    <th>Описание</th>
                                    <th>Мета-тег</th>
                                    <th>Мета-описание</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($blog_posts->isNotEmpty())
                                    @foreach($blog_posts as $blog_post)
                                        <tr>
                                            <td>{{ $blog_post->title}}</td>
                                            <td>{{ $blog_post->description}}</td>
                                            <td>{{ $blog_post->meta_title}}</td>
                                            <td>{{ $blog_post->meta_description}}</td>
                                            <td>
                                                @if($blog_post->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('blogs.edit', ['blog' => $blog_post]) }}">
                                                    <input type="button" class=" btn btn-3d btn-primary"
                                                           value="Редактировать">
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('blogs.destroy', ['blog' => $blog_post]) }}"
                                                      method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
@endsection
