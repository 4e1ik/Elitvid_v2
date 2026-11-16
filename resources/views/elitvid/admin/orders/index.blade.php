@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Заказы</h3>
                    <p class="animated fadeInDown">Заявки, отправленные из корзины.</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Список заказов</h3></div>
                    <div class="panel-body">
                        <form method="get" action="{{ route('admin_orders.index') }}" class="form-inline" style="margin-bottom: 16px;">
                            <label>
                                С
                                <input type="date" name="date_from" value="{{ $filter->from }}" class="form-control">
                            </label>
                            <label>
                                По
                                <input type="date" name="date_to" value="{{ $filter->to }}" class="form-control">
                            </label>
                            <button type="submit" class="btn btn-primary">Показать</button>
                            <a class="btn btn-default" href="{{ route('admin_orders.index') }}">Очистить фильтр</a>
                            <a class="btn btn-default" href="{{ route('admin_orders.export', request()->only(['date_from', 'date_to'])) }}">Скачать CSV</a>
                        </form>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if($orders->isEmpty())
                            <p class="text-muted">Заказов пока нет.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Имя</th>
                                            <th>Почта</th>
                                            <th>Телефон</th>
                                            <th>Организация</th>
                                            <th>Комментарий</th>
                                            <th>Товары</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><small>{{ $order->created_at ? $order->created_at->format('d.m.Y H:i') : '—' }}</small></td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->corporation_name ?: '—' }}</td>
                                                <td>{{ $order->comment ?: '—' }}</td>
                                                <td>
                                                    {{ $order->items->map(fn ($item) => $item->product_name.' × '.$item->quantity)->implode('; ') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($orders->hasPages())
                                <p>
                                    Страница {{ $orders->currentPage() }} из {{ $orders->lastPage() }}
                                    @if($orders->previousPageUrl())
                                        <a href="{{ $orders->previousPageUrl() }}">Назад</a>
                                    @endif
                                    @if($orders->nextPageUrl())
                                        <a href="{{ $orders->nextPageUrl() }}">Дальше</a>
                                    @endif
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
