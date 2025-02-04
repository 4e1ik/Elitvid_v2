@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Мета-теги</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Мета-теги</h3></div>
                    <div class="panel-body">
                        @if($metaTags->isNotEmpty())
                            @foreach($metaTags as $metaTag)
                                <div class="col-md-12 well well-sm">
                                    <form action="{{route('meta_tags_update',['metaTag' => $metaTag])}}"
                                          method="post">
                                        @method('PUT')
                                        @csrf
                                        <div style="display: flex; align-items: center; margin-top: 20px"
                                             class="col-md-12">
                                            <div class="col-md-2">
                                                <h3>
                                                    @if($metaTag->page == 'benches')
                                                        Страница скемеек
                                                    @elseif($metaTag->page == 'lines_benches')
                                                        Страница коллекции Lines
                                                    @elseif($metaTag->page == 'solo_benches')
                                                        Страница коллекции Solo
                                                    @elseif($metaTag->page == 'stones_benches')
                                                        Страница коллекции Stones
                                                    @elseif($metaTag->page == 'street_furniture_benches')
                                                        Страница коллекции Уличная фурнитура
                                                    @elseif($metaTag->page == 'verona_benches')
                                                        Страница коллекции Verona
                                                    @elseif($metaTag->page == 'pots')
                                                        Страница кашпо
                                                    @elseif($metaTag->page == 'rectangular_pots')
                                                        Страница прямоугольные кашпо
                                                    @elseif($metaTag->page == 'round_pots')
                                                        Страница круглые кашпо
                                                    @elseif($metaTag->page == 'square_pots')
                                                        Страница квадратные кашпо
                                                    @elseif($metaTag->page == 'bollards_and_fencing')
                                                        Страница болларды и ограждения
                                                    @elseif($metaTag->page == 'decorations')
                                                        Страница декорации
                                                    @elseif($metaTag->page == 'directions')
                                                        Страница направления
                                                    @elseif($metaTag->page == 'facade_stucco_molding_and_panels')
                                                        Страница фасадная лепнина и панели
                                                    @elseif($metaTag->page == 'main')
                                                        Главная страница
                                                    @elseif($metaTag->page == 'parklets_and_canopies')
                                                        Страница парклеты и навесы
                                                    @elseif($metaTag->page == 'pillars_and_covers')
                                                        Страница столбы и накрывки
                                                    @elseif($metaTag->page == 'rotundas_and_colonnades')
                                                        Страница ротонды и коллоны
                                                    @elseif($metaTag->page == 'blog')
                                                        Страница постов блога
                                                    @endif
                                                </h3>
                                            </div>
                                            <div class="col-md-4 padding-0">
                                                <h3>Заголовок</h3>
                                                <div class="col-md-11 padding-0">
                                            <textarea name="title" id="" cols="25"
                                                      rows="5">{{$metaTag->title}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 padding-0">
                                                <h3>Описание</h3>
                                                <div class="col-md-11 padding-0">
                                            <textarea name="description" id="" cols="25"
                                                      rows="5">{{ $metaTag->description}}</textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{$metaTag->page}}">
                                            <div class="col-md-1 padding-0">
                                                <input type="submit" class="btn btn-3d btn-primary"
                                                       value="Сохранить теги">
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
