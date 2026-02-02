@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Контент страниц</h3>
                    <p class="animated fadeInDown">
                        Управление мета-тегами, описаниями категорий и галереями для всех страниц сайта
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Список страниц</h3></div>
                    <div class="panel-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Страница</th>
                                        <th>Мета-теги</th>
                                        <th>Описание</th>
                                        <th>Галерея</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pageContents as $pageData)
                                        <tr>
                                            <td class="admin-table-cell-truncate admin-table-cell-truncate--medium" title="{{ $pageData->name }} — {{ $pageData->page }}">
                                                <strong>{{ Str::limit($pageData->name, 40) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($pageData->page, 30) }}</small>
                                            </td>
                                            <td>
                                                @if(!empty($pageData->meta_title))
                                                    <span class="text-success">✓ Заполнено</span>
                                                @else
                                                    <span class="text-muted">— Не заполнено</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($pageData->category_description))
                                                    <span class="text-success">✓ Заполнено</span>
                                                @else
                                                    <span class="text-muted">— Не заполнено</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($pageData->gallery)
                                                    <span class="text-success">✓ Настроена</span>
                                                @else
                                                    <span class="text-muted">— Не настроена</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin_page_contents.edit', $pageData) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Изменить
                                                </a>
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
