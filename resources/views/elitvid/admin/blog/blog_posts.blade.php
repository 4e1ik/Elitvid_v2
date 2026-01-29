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
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th style="width: 80px;">Изображение</th>
                                    <th>Заголовок</th>
                                    <th>Описание</th>
                                    <th>Мета-тег</th>
                                    <th>Мета-описание</th>
                                    <th style="width: 100px;">Опубликован</th>
                                    <th style="text-align: center; width: 120px;">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($blog_posts->isNotEmpty())
                                    @foreach($blog_posts as $blog_post)
                                        <tr>
                                            <td>
                                                @php
                                                    $mainImage = $blog_post->images()->where('main_image', true)->first();
                                                    $imagePath = $mainImage ? $mainImage->image : ($blog_post->attributes['main_image'] ?? null);
                                                @endphp
                                                @if($imagePath)
                                                    <a href="{{ asset('storage/' . str_replace('public/', '', $imagePath)) }}" target="_blank">
                                                        <img
                                                            src="{{ asset('storage/' . str_replace('public/', '', $imagePath)) }}"
                                                            alt="{{ $blog_post->title }}"
                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; cursor: pointer; transition: transform 0.3s;"
                                                            onmouseover="this.style.transform='scale(1.1)'"
                                                            onmouseout="this.style.transform='scale(1)'"
                                                            title="Кликните для просмотра в полном размере"
                                                        >
                                                    </a>
                                                @else
                                                    <div style="width: 60px; height: 60px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                        <span class="fa fa-image" style="color: #999; font-size: 24px;"></span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $blog_post->title }}</strong>
                                                @if(strlen($blog_post->title) > 50)
                                                    <br><small class="text-muted">{{ Str::limit($blog_post->title, 50) }}...</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ Str::limit($blog_post->description, 100) }}
                                                @if(strlen($blog_post->description) > 100)
                                                    <span class="text-muted">...</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($blog_post->meta_title)
                                                    {{ Str::limit($blog_post->meta_title, 80) }}
                                                    @if(strlen($blog_post->meta_title) > 80)
                                                        <span class="text-muted">...</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($blog_post->meta_description)
                                                    {{ Str::limit($blog_post->meta_description, 100) }}
                                                    @if(strlen($blog_post->meta_description) > 100)
                                                        <span class="text-muted">...</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($blog_post->active == 1)
                                                    <span class="label label-success" style="padding: 5px 10px; border-radius: 3px; background: #5cb85c; color: white;">
                                                        <span class="fa fa-check"></span> Да
                                                    </span>
                                                @else
                                                    <span class="label label-default" style="padding: 5px 10px; border-radius: 3px; background: #999; color: white;">
                                                        <span class="fa fa-times"></span> Нет
                                                    </span>
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
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                                            <span class="fa fa-info-circle" style="font-size: 48px; display: block; margin-bottom: 10px;"></span>
                                            Постов пока нет. <a href="{{ route('blogs.create') }}">Создайте первый пост</a>
                                        </td>
                                    </tr>
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
