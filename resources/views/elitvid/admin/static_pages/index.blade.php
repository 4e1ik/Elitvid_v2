@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Статические страницы направлений</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Список страниц</h3>
                    </div>
                    <div class="panel-body">
                        <div style="margin-bottom: 20px;">
                            <a href="{{route('static_pages.create')}}" class="btn btn-3d btn-sm btn-success">
                                <span class="fa fa-plus"></span> Создать новую страницу
                            </a>
                        </div>
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Slug</th>
                                    <th>Заголовок (H1)</th>
                                    <th>Подзаголовок</th>
                                    <th>Главная картинка</th>
                                    <th>Активна</th>
                                    <th style="text-align: center; width: 120px;">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staticPages as $staticPage)
                                    <tr>
                                        <td>{{$staticPage->id}}</td>
                                        <td>{{$staticPage->slug ?? 'Не указан'}}</td>
                                        <td>{{Str::limit($staticPage->title ?? 'Не указан', 50)}}</td>
                                        <td>{{Str::limit($staticPage->subtitle ?? 'Не указан', 50)}}</td>
                                        <td>
                                            @php
                                                $mainImage = $staticPage->images()->where('main_image', true)->first();
                                            @endphp
                                            @if($mainImage)
                                                <img style="height: 100px" src="{{asset('storage/' . str_replace('public/', '', $mainImage->image))}}" alt="{{$mainImage->description_image}}">
                                            @else
                                                Нет изображения
                                            @endif
                                        </td>
                                        <td>
                                            @if($staticPage->active)
                                                <span class="label label-success">Активна</span>
                                            @else
                                                <span class="label label-danger">Неактивна</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center; white-space: nowrap;">
                                            <a href="{{route('static_pages.edit', ['static_page' => $staticPage])}}" class="btn btn-3d btn-sm btn-primary" title="Редактировать" style="margin-right: 5px;">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <form action="{{route('static_pages.destroy', ['static_page' => $staticPage])}}" method="post" style="display: inline-block; margin: 0; vertical-align: top;" onsubmit="return confirm('Вы уверены, что хотите удалить эту страницу?');">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-3d btn-sm btn-danger" title="Удалить">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


