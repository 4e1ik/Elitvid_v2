@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Таблицы кашпо</h3>
                    <p class="animated fadeInDown">
                        Таблицы <span class="fa-angle-right fa"></span> Таблицы кашпо
                    </p>
                </div>
                <ul class="nav navbar-nav">
{{--                    {{$route_name = \Illuminate\Support\Facades\Route::currentRouteName()}}--}}
                    <li><a href="{{route('posts.create')}}">Добавить товар</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Круглые кашпо</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Коллекция</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($round_pots as $pot)
                                    <tr>
                                        <td>{{$pot->title}}</td>
                                        <td>{!! $pot->content!!}</td>
                                        <td>
                                            @if($pot->type == 9)
                                                Коллекция Stones
                                            @elseif($pot->type == 10)
                                                Коллекция Radius
                                            @elseif($pot->type == 11)
                                                Коллекция Solo
                                            @elseif($pot->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$pot->created_at}}</td>
                                        <td>{{$pot->updated_at}}</td>
                                        <td>
                                            @if($pot->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', ['post' => $pot->id]) }}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $pot->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" style="border: 0">
                                                    <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Прямоугольные кашпо</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Коллекция</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rectangular_pots as $pot)
                                    <tr>
                                        <td>{{$pot->title}}</td>
                                        <td>
                                            {!! $pot->content !!}
                                        </td>
                                        <td>
                                            @if($pot->type == 9)
                                                Коллекция Stones
                                            @elseif($pot->type == 10)
                                                Коллекция Radius
                                            @elseif($pot->type == 11)
                                                Коллекция Solo
                                            @elseif($pot->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$pot->created_at}}</td>
                                        <td>{{$pot->updated_at}}</td>
                                        <td>
                                            @if($pot->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('posts.show', ['post' => $pot->id])}}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $pot->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" style="border: 0">
                                                    <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Квадратные кашпо</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Коллекция</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($square_pots as $pot)
                                    <tr>
                                        <td>{{$pot->title}}</td>
                                        <td>{!! $pot->content !!}</td>
                                        <td>
                                            @if($pot->type == 9)
                                                Коллекция Stones
                                            @elseif($pot->type == 10)
                                                Коллекция Radius
                                            @elseif($pot->type == 11)
                                                Коллекция Solo
                                            @elseif($pot->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$pot->created_at}}</td>
                                        <td>{{$pot->updated_at}}</td>
                                        <td>
                                            @if($pot->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('posts.show', ['post' => $pot->id])}}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $pot->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" style="border: 0">
                                                    <input type="button" class="btn btn-3d btn-danger" value="Удалить">
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
    <!-- end: content -->
@endsection
