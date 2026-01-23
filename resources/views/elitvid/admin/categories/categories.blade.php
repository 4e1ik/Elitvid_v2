@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Категории</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Категории</h3></div>
                    <div class="panel-body">
                        @if($categories->isNotEmpty())
                            @foreach($categories as $category)
                                <div class="col-md-12 well well-sm">
                                    <form action="{{route('categories.update',['category' => $category])}}"
                                          method="post">
                                        @method('PUT')
                                        @csrf
                                        <div style="display: flex; align-items: center; margin-top: 20px"
                                             class="col-md-12">
                                            <div class="col-md-2">
                                                <h3>
                                                    @if($category->page == 'benches')
                                                        Страница скемеек
                                                    @elseif($category->page == 'lines_benches')
                                                        Страница коллекции Lines
                                                    @elseif($category->page == 'solo_benches')
                                                        Страница коллекции Solo
                                                    @elseif($category->page == 'stones_benches')
                                                        Страница коллекции Stones
                                                    @elseif($category->page == 'street_furniture_benches')
                                                        Страница коллекции Уличная фурнитура
                                                    @elseif($category->page == 'verona_benches')
                                                        Страница коллекции Verona
                                                    @elseif($category->page == 'pots')
                                                        Страница кашпо
                                                    @elseif($category->page == 'rectangular_pots')
                                                        Страница прямоугольные кашпо
                                                    @elseif($category->page == 'round_pots')
                                                        Страница круглые кашпо
                                                    @elseif($category->page == 'square_pots')
                                                        Страница квадратные кашпо
                                                    @elseif($category->page == 'bollards_and_fencing')
                                                        Страница болларды и ограждения
                                                    @elseif($category->page == 'decorations')
                                                        Страница декорации
                                                    @elseif($category->page == 'directions')
                                                        Страница направления
                                                    @elseif($category->page == 'main')
                                                        Главная страница
                                                    @elseif($category->page == 'blog')
                                                        Страница постов блога
                                                    @endif
                                                </h3>
                                            </div>
                                            <div class="col-md-8 padding-0">
                                                <h3>Описание</h3>
                                                <div class="col-md-11 padding-0">
                                            <textarea name="description" id="editor" cols="25"
                                                      rows="5">{{$category->description}}</textarea>
                                                    <script>
                                                        tinymce.init({
                                                            selector: '#editor',
                                                            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                                            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{$category->page}}">
                                            <div class="col-md-1 padding-0">
                                                <input type="submit" class="btn btn-3d btn-primary"
                                                       value="Сохранить описание">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
@endsection
