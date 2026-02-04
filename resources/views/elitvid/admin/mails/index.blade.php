@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Письма (заявки с сайта)</h3>
                    <p class="animated fadeInDown">
                        Список писем, отправленных через форму обратной связи. Нажмите «Развернуть», чтобы прочитать содержимое.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Список писем</h3></div>
                    <div class="panel-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($mails->isEmpty())
                            <p class="text-muted">Писем пока нет.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 140px;">Дата</th>
                                            <th>Имя</th>
                                            <th>Email</th>
                                            <th>Телефон</th>
                                            <th>Организация</th>
                                            <th>Сообщение</th>
                                            <th style="width: 100px;">Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mails as $mail)
                                            <tr data-mail-id="{{ $mail->id }}">
                                                <td>
                                                    <small>{{ $mail->created_at ? $mail->created_at->format('d.m.Y H:i') : '—' }}</small>
                                                </td>
                                                <td class="admin-table-cell-truncate admin-table-cell-truncate--medium" title="{{ $mail->name }}">
                                                    {{ Str::limit($mail->name, 25) }}
                                                </td>
                                                <td class="admin-table-cell-truncate admin-table-cell-truncate--medium" title="{{ $mail->email }}">
                                                    {{ Str::limit($mail->email, 25) }}
                                                </td>
                                                <td>
                                                    {{ $mail->phone ?: '—' }}
                                                </td>
                                                <td class="admin-table-cell-truncate admin-table-cell-truncate--short" title="{{ $mail->corporation_name }}">
                                                    {{ $mail->corporation_name ? Str::limit($mail->corporation_name, 15) : '—' }}
                                                </td>
                                                <td class="admin-table-cell-truncate admin-table-cell-truncate--long" title="{{ $mail->message }}">
                                                    {{ Str::limit($mail->message, 40) }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-sm btn-default mail-toggle-details"
                                                            data-toggle="collapse"
                                                            data-target="#mail-details-{{ $mail->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="mail-details-{{ $mail->id }}">
                                                        <span class="fa fa-chevron-down"></span> Развернуть
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="mail-details-row">
                                                <td colspan="7" class="padding-0 border-none">
                                                    <div id="mail-details-{{ $mail->id }}" class="collapse mail-details-collapse">
                                                        <div class="panel panel-default" style="margin: 0; border-radius: 0; border-left: 3px solid #15BA67;">
                                                            <div class="panel-body" style="background: #f9f9f9;">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p><strong>Имя:</strong> {{ $mail->name }}</p>
                                                                        <p><strong>Email:</strong> <a href="mailto:{{ $mail->email }}">{{ $mail->email }}</a></p>
                                                                        <p><strong>Телефон:</strong> {{ $mail->phone ?: '—' }}</p>
                                                                        <p><strong>Организация:</strong> {{ $mail->corporation_name ?: '—' }}</p>
                                                                        @if($mail->file)
                                                                            <p><strong>Файл:</strong>
                                                                                <a href="{{ Storage::url($mail->file) }}" target="_blank" rel="noopener">
                                                                                    {{ basename($mail->file) }} <span class="fa fa-external-link"></span>
                                                                                </a>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p><strong>Сообщение:</strong></p>
                                                                        <div class="well well-sm" style="white-space: pre-wrap;">{{ $mail->message ?: '—' }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->

    <style>
        .mail-details-row td.border-none { border-top: none !important; }
        .mail-details-collapse .panel-body { padding: 15px; }
        .mail-toggle-details .fa-chevron-down { transition: transform 0.2s; }
        .mail-toggle-details[aria-expanded="true"] .fa-chevron-down { transform: rotate(180deg); }
    </style>
    <script>
        $(function () {
            $('.mail-details-collapse').on('show.bs.collapse', function () {
                var id = $(this).attr('id');
                $('button[data-target="#' + id + '"]').html('<span class="fa fa-chevron-down"></span> Свернуть');
            }).on('hide.bs.collapse', function () {
                var id = $(this).attr('id');
                $('button[data-target="#' + id + '"]').html('<span class="fa fa-chevron-down"></span> Развернуть');
            });
        });
    </script>
@endsection
