@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Таблицы текстур</h3>
                    <p class="animated fadeInDown">
                        Таблицы <span class="fa-angle-right fa"></span> Таблицы текстур
                    </p>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="{{route('posts.create')}}">Добавить товар</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Натуральный камень</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($natural_stones as $stone)
                                <tr>
                                    <td>{{$stone->title}}</td>
                                    <td>
                                        @foreach($stone->images as $image)
                                            <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">
                                        @endforeach
                                    </td>
                                    <td>{{$stone->created_at}}</td>
                                    <td>{{$stone->updated_at}}</td>
                                    <td>
                                        @if($stone->active == 1)
                                            Да
                                        @else
                                            Нет
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('posts.show', ['post' => $stone->id]) }}">
                                            <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('posts.destroy', ['post' => $stone->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Лунный камень</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($moon_stones as $stone)
                                    <tr>
                                        <td>{{$stone->title}}</td>
                                        <td>
                                            @foreach($stone->images as $image)
                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">
                                            @endforeach
                                        </td>
                                        <td>{{$stone->created_at}}</td>
                                        <td>{{$stone->updated_at}}</td>
                                        <td>
                                            @if($stone->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', ['post' => $stone->id]) }}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $stone->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Полированный камень</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($polished_stones as $stone)
                                    <tr>
                                        <td>{{$stone->title}}</td>
                                        <td>
                                            @foreach($stone->images as $image)
                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">
                                            @endforeach
                                        </td>
                                        <td>{{$stone->created_at}}</td>
                                        <td>{{$stone->updated_at}}</td>
                                        <td>
                                            @if($stone->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', ['post' => $stone->id]) }}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $stone->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Породы дерева</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wood_species as $stone)
                                    <tr>
                                        <td>{{$stone->title}}</td>
                                        <td>
                                            @foreach($stone->images as $image)
                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">
                                            @endforeach
                                        </td>
                                        <td>{{$stone->created_at}}</td>
                                        <td>{{$stone->updated_at}}</td>
                                        <td>
                                            @if($stone->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', ['post' => $stone->id]) }}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $stone->id]) }}" method="post">
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
                    <div class="panel-heading"><h3>Пропитка</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Картинка</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wood_impregnation as $stone)
                                    <tr>
                                        <td>{{$stone->title}}</td>
                                        <td>
                                            @foreach($stone->images as $image)
                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">
                                            @endforeach
                                        </td>
                                        <td>{{$stone->created_at}}</td>
                                        <td>{{$stone->updated_at}}</td>
                                        <td>
                                            @if($stone->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', ['post' => $stone->id]) }}">
                                                <input type="button" class=" btn btn-3d btn-primary" value="Редактировать">
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('posts.destroy', ['post' => $stone->id]) }}" method="post">
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
