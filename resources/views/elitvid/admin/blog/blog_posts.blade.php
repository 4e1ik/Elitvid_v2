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
                        <button class="btn btn-3d btn-sm btn-success">
                            <span class="fa fa-plus"></span> Создать пост
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
                        <div style="margin-bottom: 20px;">
                            <a href="{{route('blogs.create')}}" class="btn btn-3d btn-sm btn-success">
                                <span class="fa fa-plus"></span> Создать пост
                            </a>
                        </div>
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
                                    <th style="text-align: center; width: 120px;">Действия</th>
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
                                            <td style="text-align: center; white-space: nowrap;">
                                                <a href="{{ route('blogs.edit', ['blog' => $blog_post]) }}" 
                                                   class="btn btn-3d btn-sm btn-primary" 
                                                   title="Редактировать"
                                                   style="margin-right: 5px;">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                                <form action="{{ route('blogs.destroy', ['blog' => $blog_post]) }}"
                                                      method="post" 
                                                      style="display: inline-block; margin: 0; vertical-align: top;"
                                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-3d btn-sm btn-danger" 
                                                            title="Удалить">
                                                        <span class="fa fa-trash"></span>
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
