@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Таблицы скамеек</h3>
                    <p class="animated fadeInDown">
                        Таблицы <span class="fa-angle-right fa"></span> Таблицы скамеек
                    </p>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="{{route('create', ['route' => 'benches'])}}">Добавить товар</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Коллекция Stones</h3></div>
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
                                @foreach($benches_stones as $bench)
                                <tr>
                                    <td>{{$bench->title}}</td>
                                    <td>{!! $bench->content !!}</td>
                                    <td>
                                        @if($bench->type == 9)
                                            Коллекция Stones
                                        @elseif($bench->type == 10)
                                            Коллекция Radius
                                        @elseif($bench->type == 11)
                                            Коллекция Solo
                                        @elseif($bench->type == 12)
                                            Коллекция Outdoor
                                        @endif
                                    </td>
                                    <td>{{$bench->created_at}}</td>
                                    <td>{{$bench->updated_at}}</td>
                                    <td>
                                        @if($bench->active == 1)
                                            Да
                                        @else
                                            Нет
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('posts.show', ['post' => $bench->id])}}">
                                            <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('posts.destroy', ['post' => $bench->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Коллекция Radius</h3></div>
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
                                @foreach($benches_radius as $bench)
                                    <tr>
                                        <td>{{$bench->title}}</td>
                                        <td>{!! $bench->content !!}</td>
                                        <td>
                                            @if($bench->type == 9)
                                                Коллекция Stones
                                            @elseif($bench->type == 10)
                                                Коллекция Radius
                                            @elseif($bench->type == 11)
                                                Коллекция Solo
                                            @elseif($bench->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$bench->created_at}}</td>
                                        <td>{{$bench->updated_at}}</td>
                                        <td>
                                            @if($bench->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('posts.show', ['post' => $bench->id])}}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $bench->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Коллекция Solo</h3></div>
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
                                @foreach($benches_solo as $bench)
                                    <tr>
                                        <td>{{$bench->title}}</td>
                                        <td>{!! $bench->content !!}</td>
                                        <td>
                                            @if($bench->type == 9)
                                                Коллекция Stones
                                            @elseif($bench->type == 10)
                                                Коллекция Radius
                                            @elseif($bench->type == 11)
                                                Коллекция Solo
                                            @elseif($bench->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$bench->created_at}}</td>
                                        <td>{{$bench->updated_at}}</td>
                                        <td>
                                            @if($bench->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('posts.show', ['post' => $bench->id])}}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $bench->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Коллекция Outdoor</h3></div>
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
                                @foreach($benches_outdoor as $bench)
                                    <tr>
                                        <td>{{$bench->title}}</td>
                                        <td>{!! $bench->content !!}</td>
                                        <td>
                                            @if($bench->type == 9)
                                                Коллекция Stones
                                            @elseif($bench->type == 10)
                                                Коллекция Radius
                                            @elseif($bench->type == 11)
                                                Коллекция Solo
                                            @elseif($bench->type == 12)
                                                Коллекция Outdoor
                                            @endif
                                        </td>
                                        <td>{{$bench->created_at}}</td>
                                        <td>{{$bench->updated_at}}</td>
                                        <td>
                                            @if($bench->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('posts.show', ['post' => $bench->id])}}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $bench->id]) }}" method="post">
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
