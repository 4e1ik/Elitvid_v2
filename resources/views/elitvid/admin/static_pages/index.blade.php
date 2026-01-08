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
                    <div class="panel-heading"><h3>Список страниц</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Страница</th>
                                    <th>Заголовок (H1)</th>
                                    <th>Главная картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staticPages as $staticPage)
                                    <tr>
                                        <td>{{$staticPage->id}}</td>
                                        <td>
                                            @if($staticPage->page == 'bollards_and_fencing')
                                                Болларды и ограждения
                                            @elseif($staticPage->page == 'facade_stucco_molding_and_panels')
                                                Фасадная лепнина и панели
                                            @elseif($staticPage->page == 'parklets_and_canopies')
                                                Парклеты и навесы
                                            @elseif($staticPage->page == 'pillars_and_covers')
                                                Столбы и накрывки
                                            @elseif($staticPage->page == 'rotundas_and_colonnades')
                                                Ротонды и колонны
                                            @elseif($staticPage->page == 'small_architectural_forms')
                                                Малые архитектурные формы
                                            @elseif($staticPage->page == 'concrete_products')
                                                Изделия из бетона
                                            @else
                                                {{$staticPage->page}}
                                            @endif
                                        </td>
                                        <td>{{Str::limit($staticPage->title ?? 'Не указан', 50)}}</td>
                                        <td>
                                            @if($staticPage->main_image)
                                                <img style="height: 100px" src="{{asset($staticPage->main_image)}}" alt="{{$staticPage->alt_image}}">
                                            @else
                                                Нет изображения
                                            @endif
                                        </td>
                                        <td>{{$staticPage->created_at}}</td>
                                        <td>{{$staticPage->updated_at}}</td>
                                        <td>
                                            <a href="{{route('static_pages.edit', ['static_page' => $staticPage])}}" class="btn btn-3d btn-primary">Редактировать</a>
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


