@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: content -->
    <div id="content">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-6 col-sm-12">
                    <h3 class="animated fadeInLeft">Добро пожаловать, {{Auth::user()['username'] ?? 'Администратор'}}!</h3>

                    <ul class="nav navbar-nav" style="margin-top: 15px;">
                        <li><a href="{{ route('admin_blog') }}"><span class="fa fa-file-text"></span> Блог</a></li>
                        <li><a href="{{ route('admin_page_contents.index') }}"><span class="fa fa-file-text-o"></span> Контент страниц</a></li>
                        <li><a href="{{ route('static_pages.index') }}"><span class="fa fa-files-o"></span> Статические страницы</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="padding:20px;">
            <div class="col-md-12 padding-0">
                <div class="col-md-8 padding-0">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-6">
                            <a href="{{ route('admin_blog') }}" style="text-decoration: none; color: inherit;">
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
                                        <h1>{{ $stats['blog_posts'] }}</h1>
                                        <p>Всего постов ({{ $stats['active_blog_posts'] }} активных)</p>
                                    <hr/>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div class="panel box-v1" style="transition: transform 0.2s;">
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
                                        <h1>{{ $stats['products'] }}</h1>
                                        <p>Всего продуктов ({{ $stats['active_products'] }} активных)</p>
                                        <hr/>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-12 padding-0" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <a href="{{ route('admin_page_contents.index') }}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Страницы (контент)</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                            <h4>
                                                <span class="icon-doc icons icon text-right"></span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="panel-body text-center">
                                        <h1>{{ $stats['page_contents'] }}</h1>
                                        <p>Статические страницы, которые нельзя создать</p>
                                    <hr/>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('static_pages.index') }}" style="text-decoration: none; color: inherit;">
                                <div class="panel box-v1" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                            <h4 class="text-left">Статические страницы</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                            <h4>
                                                <span class="icon-folder icons icon text-right"></span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="panel-body text-center">
                                        <h1>{{ $stats['static_pages'] }}</h1>
                                        <p>Статические страницы, которые можно создать</p>
                                        <hr/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel box-v4">
                            <div class="panel-heading bg-white border-none">
                                <h4><span class="icon-notebook icons"></span> История последних действий</h4>
                            </div>
                            <div class="panel-body padding-0">
                                @if($recent_activity->count() > 0)
                                    @foreach($recent_activity as $item)
                                        <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert" style="border-bottom: 1px solid #eee; padding: 15px;">
                                            <span class="label label-info" style="font-size: 11px;">{{ $item->type_label }}</span>
                                            <h4 style="margin-top: 8px; margin-bottom: 5px;">
                                                <a href="{{ $item->edit_url }}">{{ $item->title }}</a>
                                            </h4>
                                            @if($item->excerpt)
                                                <p style="margin-bottom: 5px; font-size: 13px; color: #666;">{{ Str::limit($item->excerpt, 100) }}</p>
                                            @endif
                                            <b><span class="icon-clock icons"></span> {{ $item->created_at->format('d.m.Y H:i') }}</b>
                                            <span class="pull-right">
                                                <span class="label {{ $item->active ? 'label-success' : 'label-default' }}">
                                                    {{ $item->active ? 'Активен' : 'Неактивен' }}
                                                </span>
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
                                        <p>Нет недавних записей</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                </div>
            </div>

            <div class="col-md-12 card-wrap padding-0">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading bg-white border-none" style="padding:20px;">
                            <h4>Распределение контента</h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                            <div class="text-center" style="max-width: 280px; margin: 0 auto;">
                                <canvas class="pie-chart-distribution" style="height: 260px;"></canvas>
                            </div>
                            <p class="text-muted text-center" style="margin-top: 10px; font-size: 13px;">Блог: {{ $stats['blog_posts'] }}, Скамейки: {{ $stats['bench_products'] }}, Кашпо: {{ $stats['pot_products'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading bg-white border-none" style="padding:20px;">
                            <h4>Заявки с сайта по неделям</h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                            <div style="height: 260px;">
                                <canvas class="bar-chart-mails"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
@endsection

