@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: content -->
    <div id="content">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-6 col-sm-12">
                    <h3 class="animated fadeInLeft">Добро пожаловать, {{Auth::user()['username'] ?? 'Администратор'}}!</h3>
                    <p class="animated fadeInDown">
                        <span class="fa fa-envelope"></span> {{Auth::user()['email'] ?? ''}}
                    </p>
                    <p class="animated fadeInDown">
                        <span class="fa fa-clock-o"></span> Последний вход: {{Auth::user() && Auth::user()['updated_at'] ? Auth::user()['updated_at']->format('d.m.Y H:i') : 'Недавно'}}
                    </p>

                    <ul class="nav navbar-nav" style="margin-top: 15px;">
                        <li><a href="{{route('admin_blog')}}" ><span class="fa fa-file-text"></span> Блог</a></li>
                        <li><a href="{{route('admin_benches_verona')}}" ><span class="fa fa-cube"></span> Скамейки</a></li>
                        <li><a href="{{route('admin_round_pots')}}" ><span class="fa fa-cube"></span> Кашпо</a></li>
                        <li><a href="{{route('admin_page_contents.index')}}" ><span class="fa fa-picture-o"></span> Галереи</a></li>
                        <li><a href="{{route('admin_static_images', 'index')}}" ><span class="fa fa-image"></span> Статические изображения</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="padding:20px;">
            <div class="col-md-12 padding-0">
                <div class="col-md-8 padding-0">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-6">
                            <a href="{{route('admin_blog')}}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                <div class="panel-heading bg-white border-none">
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Блог</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                        <h4>
                                                <span class="icon-notebook icons icon text-right"></span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                        <h1>{{$stats['blog_posts']}}</h1>
                                        <p>Всего постов ({{$stats['active_blog_posts']}} активных)</p>
                                    <hr/>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('admin_benches_verona')}}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                <div class="panel-heading bg-white border-none">
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Продукты</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                        <h4>
                                            <span class="icon-basket-loaded icons icon text-right"></span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                        <h1>{{$stats['products']}}</h1>
                                        <p>Всего продуктов ({{$stats['active_products']}} активных)</p>
                                        <hr/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 padding-0" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <a href="{{route('admin_page_contents.index')}}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Изображения</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                            <h4>
                                                <span class="icon-picture icons icon text-right"></span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="panel-body text-center">
                                        <h1>{{$stats['galleries']}}</h1>
                                        <p>Галерей изображений</p>
                                    <hr/>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('admin_static_images', 'index')}}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Изображения</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                            <h4>
                                                <span class="icon-camera icons icon text-right"></span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="panel-body text-center">
                                        <h1>{{$stats['gallery_images'] + $stats['product_images'] + $stats['static_images']}}</h1>
                                        <p>Всего изображений</p>
                                        <hr/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel box-v4">
                            <div class="panel-heading bg-white border-none">
                                <h4><span class="icon-notebook icons"></span> Последние посты блога</h4>
                            </div>
                            <div class="panel-body padding-0">
                                @if($recent_blogs->count() > 0)
                                    @foreach($recent_blogs as $post)
                                        <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert" style="border-bottom: 1px solid #eee; padding: 15px;">
                                            <h4 style="margin-top: 0;">{{$post->title}}</h4>
                                            <p style="margin-bottom: 5px;">{{Str::limit($post->description ?? '', 100)}}</p>
                                            <b><span class="icon-clock icons"></span> {{$post->created_at->format('d.m.Y H:i')}}</b>
                                            <span class="pull-right">
                                                <span class="label {{$post->active ? 'label-success' : 'label-default'}}">
                                                    {{$post->active ? 'Активен' : 'Неактивен'}}
                                                </span>
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
                                        <p>Нет постов в блоге</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 padding-0">
                        <div class="panel box-v2">
                            <div class="panel-heading padding-0">
                                <img src="{{asset('/elitvid_assets/img/bg2.jpg')}}" class="box-v2-cover img-responsive"/>
                                <div class="box-v2-detail">
                                    <img src="{{asset('/elitvid_assets/img/avatar.jpg')}}" class="img-responsive"/>
                                    <h4>Akihiko Avaron</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 padding-0 text-center">
                                    <div class="col-md-4 col-sm-4 col-xs-6 padding-0">
                                        <h3>{{$stats['blog_posts']}}</h3>
                                        <p>Постов</p>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 padding-0">
                                        <h3>{{$stats['products']}}</h3>
                                        <p>Продуктов</p>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 padding-0">
                                        <h3>{{$stats['gallery_images'] + $stats['product_images']}}</h3>
                                        <p>Изображений</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 padding-0">
                        <div class="panel box-v3">
                            <div class="panel-heading bg-white border-none">
                                <h4>Report</h4>
                            </div>
                            <div class="panel-body">
                                @php
                                    $total_products = $stats['products'];
                                    $active_products = $stats['active_products'];
                                    $products_percent = $total_products > 0 ? round(($active_products / $total_products) * 100) : 0;
                                    
                                    $total_images = $stats['gallery_images'] + $stats['product_images'] + $stats['static_images'];
                                    $images_percent = $total_images > 0 ? min(100, round(($total_images / 1000) * 100)) : 0;
                                    
                                    $blog_percent = $stats['blog_posts'] > 0 ? min(100, round(($stats['active_blog_posts'] / $stats['blog_posts']) * 100)) : 0;
                                @endphp

                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon-basket-loaded icons" style="font-size:2em;"></span>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Активные продукты</h5>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$products_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$products_percent}}%;">
                                                <span class="sr-only">{{$products_percent}}%</span>
                                            </div>
                                        </div>
                                        <small>{{$active_products}} из {{$total_products}}</small>
                                    </div>
                                </div>

                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon-camera icons" style="font-size:2em;"></span>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Изображения</h5>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$images_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$images_percent}}%;">
                                                <span class="sr-only">{{$images_percent}}%</span>
                                            </div>
                                        </div>
                                        <small>{{$total_images}} изображений</small>
                                    </div>
                                </div>

                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon-notebook icons" style="font-size:2em;"></span>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Активные посты блога</h5>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$blog_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$blog_percent}}%;">
                                                <span class="sr-only">{{$blog_percent}}%</span>
                                            </div>
                                        </div>
                                        <small>{{$stats['active_blog_posts']}} из {{$stats['blog_posts']}}</small>
                                    </div>
                                </div>

                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon-picture icons" style="font-size:2em;"></span>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Изображения</h5>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                <span class="sr-only">100%</span>
                                            </div>
                                        </div>
                                        <small>{{$stats['galleries']}} галерей</small>
                                    </div>
                                </div>

                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon-folder icons" style="font-size:2em;"></span>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Статические страницы</h5>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                <span class="sr-only">100%</span>
                                            </div>
                                        </div>
                                        <small>{{$stats['static_pages']}} страниц</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 padding-0">
                        <div class="panel bg-light-blue">
                            <div class="panel-body text-white">
                                <h4 class="animated fadeInUp" style="color: white; margin-top: 0;">
                                    <span class="fa fa-info-circle fa-2x"></span> Информация о системе
                                </h4>
                                <div class="col-md-12 padding-0" style="margin-top: 15px;">
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center" style="padding: 10px;">
                                        <h3 style="color: white; margin: 0;">{{$stats['static_pages']}}</h3>
                                        <small style="color: rgba(255,255,255,0.8);">Статических страниц</small>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center" style="padding: 10px;">
                                        <h3 style="color: white; margin: 0;">{{$stats['static_images']}}</h3>
                                        <small style="color: rgba(255,255,255,0.8);">Статических изображений</small>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center" style="padding: 10px;">
                                        <h3 style="color: white; margin: 0;">{{now()->format('d.m.Y')}}</h3>
                                        <small style="color: rgba(255,255,255,0.8);">Сегодня</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 card-wrap padding-0">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading bg-white border-none" style="padding:20px;">
                            <div class="col-md-6 col-sm-6 col-sm-12 text-left">
                                <h4>Динамика создания контента</h4>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-bottom:50px;">
                            <div id="canvas-holder1">
                                <canvas class="line-chart" style="margin-top:30px;height:200px;"></canvas>
                            </div>
                            <div class="col-md-12" style="padding-top:20px;">
                                <div class="col-md-4 col-sm-4 col-xs-6 text-center">
                                    <h2 style="line-height:.4;">{{$stats['blog_posts']}}</h2>
                                    <small>Постов блога</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6 text-center">
                                    <h2 style="line-height:.4;">{{$stats['products']}}</h2>
                                    <small>Продуктов</small>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                    <h2 style="line-height:.4;">{{$stats['gallery_images'] + $stats['product_images']}}</h2>
                                    <small>Изображений</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading bg-white border-none" style="padding:20px;">
                            <div class="col-md-6 col-sm-6 col-sm-12 text-left">
                                <h4>Статистика по месяцам</h4>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-bottom:50px;">
                            <div id="canvas-holder1">
                                <canvas class="bar-chart"></canvas>
                            </div>
                            <div class="col-md-12 padding-0" >
                                <div class="col-md-4 col-sm-4 hidden-xs" style="padding-top:20px;">
                                    <canvas class="doughnut-chart2"></canvas>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <h4>Распределение контента</h4>
                                    <p>Общее количество контента по категориям</p>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{round(($stats['blog_posts'] / max(1, $stats['blog_posts'] + $stats['products'] + $stats['galleries'])) * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{round(($stats['blog_posts'] / max(1, $stats['blog_posts'] + $stats['products'] + $stats['galleries'])) * 100)}}%;">
                                            <span class="sr-only">{{round(($stats['blog_posts'] / max(1, $stats['blog_posts'] + $stats['products'] + $stats['galleries'])) * 100)}}%</span>
                                        </div>
                                    </div>
                                    <small>Блог: {{$stats['blog_posts']}}, Продукты: {{$stats['products']}}, Галереи: {{$stats['galleries']}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
@endsection

