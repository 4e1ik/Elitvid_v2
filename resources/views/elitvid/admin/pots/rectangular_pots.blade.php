@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Список прямоугольных кашпо</h3>
                </div>
                <ul class="nav navbar-nav">
                    <a href="{{route('create', ['route' => 'pots'])}}">
                        <button class="btn ripple btn-outline btn-primary">
                            <div>
                                <span>Добавить товар</span>
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
                    <div class="panel-heading"><h3>Прямоугольные кашпо</h3></div>
                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Материал</th>
                                    <th>Варианты кашпо</th>
                                    <th>Опубликован</th>
                                    <th style="text-align: center; width: 120px;">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($products->isNotEmpty())
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->pot->material}}</td>
                                            <td>
                                                @if($product->pot->data && is_array($product->pot->data) && count($product->pot->data) > 0)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-info" 
                                                            data-toggle="collapse" 
                                                            data-target="#variants-{{$product->id}}"
                                                            aria-expanded="false"
                                                            aria-controls="variants-{{$product->id}}"
                                                            style="margin-bottom: 5px;">
                                                        <span class="fa fa-chevron-down"></span> 
                                                        Показать варианты ({{count($product->pot->data)}})
                                                    </button>
                                                    <div class="collapse" id="variants-{{$product->id}}">
                                                        <div class="variants-list" style="margin-top: 5px;">
                                                            @foreach($product->pot->data as $index => $variant)
                                                                <div class="variant-item" style="margin-bottom: 8px; padding: 8px; background: #f5f5f5; border-radius: 3px; border-left: 3px solid #337ab7;">
                                                                    <strong>Вариант {{$index + 1}}:</strong><br>
                                                                    @if(isset($variant['size']))
                                                                        <span>Размер: <strong>{{$variant['size']}}</strong></span><br>
                                                                    @endif
                                                                    @if(isset($variant['weight']))
                                                                        <span>Вес: <strong>{{$variant['weight']}}</strong></span><br>
                                                                    @endif
                                                                    @if(isset($variant['price']))
                                                                        <span>Цена: <strong>{{$variant['price']}}</strong></span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Нет данных</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->active == 1)
                                                    <span class="label label-success">Да</span>
                                                @else
                                                    <span class="label label-default">Нет</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center; white-space: nowrap;">
                                                <a href="{{ route('products.edit', ['product' => $product]) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Редактировать"
                                                   style="margin-right: 5px;">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                                <form action="{{ route('products.destroy', ['product' => $product]) }}"
                                                      method="post" 
                                                      style="display: inline-block; margin: 0; vertical-align: top;"
                                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Удалить">
                                                        <span class="fa fa-trash"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
    
    <style>
        @media (max-width: 768px) {
            .responsive-table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .responsive-table table {
                min-width: 800px;
            }
            
            .panel-heading h3 {
                font-size: 18px;
            }
            
            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }
            
            .btn-sm {
                padding: 5px 10px;
                min-width: 32px;
            }
            
            .variants-list {
                font-size: 11px;
            }
            
            .variant-item {
                font-size: 10px;
            }
            
            /* Bootstrap Collapse автоматически обрабатывает анимацию */
            .collapse.in .variants-list {
                animation: fadeIn 0.3s ease;
            }
            
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            
            /* Обновление иконки при раскрытии */
            [data-toggle="collapse"][aria-expanded="true"] .fa-chevron-down {
                display: none;
            }
            
            [data-toggle="collapse"][aria-expanded="true"] .fa-chevron-up {
                display: inline-block;
            }
            
            [data-toggle="collapse"][aria-expanded="false"] .fa-chevron-up {
                display: none;
            }
            
            [data-toggle="collapse"][aria-expanded="false"] .fa-chevron-down {
                display: inline-block;
            }
            
            [data-toggle="collapse"] .fa-chevron-up {
                display: none;
            }
            
            .label {
                display: inline-block;
                padding: 4px 8px;
                font-size: 11px;
                font-weight: 600;
                border-radius: 3px;
            }
        }
        
        @media (max-width: 480px) {
            .content-header .panel-body {
                flex-direction: column;
            }
            
            .content-header .nav.navbar-nav {
                margin-top: 10px;
                width: 100%;
            }
            
            .content-header .nav.navbar-nav a {
                width: 100%;
            }
            
            .content-header .nav.navbar-nav button {
                width: 100%;
            }
        }
    </style>
@endsection
