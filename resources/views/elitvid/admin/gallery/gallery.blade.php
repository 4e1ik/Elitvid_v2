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
                    <a href="{{route('create', ['route' => 'gallery'])}}">
                        <button class="btn ripple btn-outline btn-primary">
                            <div>
                                <span>Добавить картинки примеров работ</span>
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
                                @foreach($pots_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                @foreach($benches_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ главной страницы</h3></div>
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
                                @foreach($main_page_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ декоративных элементов</h3></div>
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
                                @foreach($decorative_elements_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ боллард</h3></div>
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
                                @foreach($bollards_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ парклетов и навесов</h3></div>
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
                                @foreach($parklets_and_naves_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ столбов и накрывок</h3></div>
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
                                @foreach($columns_and_panels_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ фасадной лепнины</h3></div>
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
                                @foreach($facade_walls_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading"><h3>Таблица картинок примеров работ ротонд</h3></div>
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
                                @foreach($rotundas_images as $item)
                                    @foreach($item->gallery_images as $image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                @if($item->active == 1)
                                                    Да
                                                @else
                                                    Нет
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class="btn btn-3d btn-danger"
                                                               value="Удалить">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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