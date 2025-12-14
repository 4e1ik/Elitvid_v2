@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Картинки главной страницы</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Картинки главной страницы</h3></div>
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
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($static_images as $static_image)
                                        <tr>
                                            <td>
                                                {{--                                                <img style="height: 200px" src="{{asset('storage/'.$image->image)}}" alt="">--}}
                                                <img style="height: 200px" src="{{asset($static_image->image)}}" alt="">
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('static_images.update', ['static_image' =>  $static_image]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="text" name="description_image"
                                                           value="{{$static_image->description_image}}">
                                                    <button type="submit" style="border: 0">
                                                        <input type="button" class=" btn btn-3d btn-primary"
                                                               value="Сохранить описание">
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{$static_image->created_at}}</td>
                                            <td>{{$static_image->updated_at}}</td>
                                            <td>
                                                <form
                                                    action="{{ route('static_images.destroy', ['static_image' => $static_image]) }}"
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
