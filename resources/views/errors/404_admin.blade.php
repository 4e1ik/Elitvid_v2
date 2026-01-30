@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">404</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body text-center" style="padding: 60px 20px;">
                        <h1 style="font-size: 72px; margin-bottom: 20px; color: #999;">404</h1>
                        <p class="lead">Страница не найдена</p>
                        <p class="text-muted">Запрашиваемая страница не существует или произошла ошибка.</p>
                        <a href="{{ route('admin') }}" class="btn btn-3d btn-primary" style="margin-top: 20px;">
                            <span class="fa fa-home"></span> На главную админки
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
