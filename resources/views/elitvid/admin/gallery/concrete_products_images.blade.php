@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Примеры работ изделий из бетона</h3>
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
                    <div class="panel-heading"><h3>Примеры работ изделий из бетона</h3></div>
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
                                @foreach($concrete_products_images as $item)
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
