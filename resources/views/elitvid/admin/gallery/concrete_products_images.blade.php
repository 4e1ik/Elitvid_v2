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
                        <button class="btn btn-3d btn-sm btn-success">
                            <span class="fa fa-plus"></span> Добавить картинки примеров работ
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
                        <div style="margin-bottom: 20px;">
                            <a href="{{route('create', ['route' => 'gallery'])}}" class="btn btn-3d btn-sm btn-success">
                                <span class="fa fa-plus"></span> Добавить картинки примеров работ
                            </a>
                        </div>
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Картинка</th>
                                    <th>Опубликован</th>
                                    <th style="text-align: center; width: 200px;">Действия</th>
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
                                                @if($item->active == 1)
                                                    <span class="label label-success">Да</span>
                                                @else
                                                    <span class="label label-default">Нет</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center; white-space: nowrap;">
                                                <form
                                                    action="{{ route('galleries.update', ['gallery' =>  $item]) }}"
                                                    method="post" style="display: inline-block; margin-right: 5px;">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image" class="form-control" style="display: inline-block; width: auto; margin-right: 5px;"
                                                           value="{{$image->description_image}}" placeholder="Описание">
                                                    <button type="submit" class="btn btn-3d btn-sm btn-primary" title="Сохранить описание">
                                                        <span class="fa fa-save"></span>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('galleries.destroy', ['gallery' => $item]) }}"
                                                    method="post" style="display: inline-block; margin: 0; vertical-align: top;"
                                                    onsubmit="return confirm('Вы уверены, что хотите удалить это изображение?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-3d btn-sm btn-danger" title="Удалить">
                                                        <span class="fa fa-trash"></span>
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
