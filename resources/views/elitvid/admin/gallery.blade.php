@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Таблица картинок примеров работ</h3>
                    <p class="animated fadeInDown">
                        Таблица <span class="fa-angle-right fa"></span> Таблица картинок примеров работ
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
                    <div class="panel-heading"><h3>Таблица картинок примеров работ кашпо</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Картинка</th>
                                    <th>Описание</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pots_images as $p_images)
                                    <tr>
                                        <td>
                                            <img style="height: 200px" src="{{asset('storage/'.$p_images->image)}}"
                                                 alt="">
                                        </td>
                                        <td>
                                            <form action="{{ route('gallery_image_update', ['image' => $p_images->id]) }}"
                                                  method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="text" name="description_img" value="{{$p_images->description_img}}">
                                                <button type="submit" style="border: 0">
                                                    <input type="button" class=" btn btn-3d btn-primary" value="Сохранить описание">
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{$p_images->created_at}}</td>
                                        <td>{{$p_images->updated_at}}</td>
                                        <td>
                                            @if($p_images->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('gallery_image_destroy', ['id' => $p_images->id]) }}"
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ скамеек</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Картинка</th>
                                    <th>Описание</th>
                                    <th>Время создания</th>
                                    <th>Время редактирования</th>
                                    <th>Опубликован</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($benches_images as $b_images)
                                    <tr>
                                        <td>
                                            <img style="height: 200px" src="{{asset('storage/'.$b_images->image)}}"
                                                 alt="">
                                        </td>
                                        <td>
                                            <form action="{{ route('gallery_image_update', ['image' => $b_images->id]) }}"
                                                  method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="text" name="description_img" value="{{$b_images->description_img}}">
                                                <button type="submit" style="border: 0">
                                                    <input type="button" class=" btn btn-3d btn-primary" value="Сохранить описание">
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{$b_images->created_at}}</td>
                                        <td>{{$b_images->updated_at}}</td>
                                        <td>
                                            @if($b_images->active == 1)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('gallery_image_destroy', ['id' => $b_images->id]) }}"
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
