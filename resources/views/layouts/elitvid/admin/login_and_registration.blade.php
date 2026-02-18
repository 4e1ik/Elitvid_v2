<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="description" content="Вход в панель администратора Elitvid">
    <meta name="author" content="Elitvid">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elitvid — Админ-панель</title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets//css/bootstrap.min.css')}}">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets/css/plugins/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets/css/plugins/simple-line-icons.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets/css/plugins/animate.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets/css/plugins/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/elitvid_assets/css/plugins/dropzone.css')}}"/>
    <link href="{{asset('/elitvid_assets/css/style.css')}}" rel="stylesheet">
    <!-- end: Css -->
    {{-- Переопределения только там, где не хватает стилей шаблона и Bootstrap --}}
    <style>
        body.form-signin-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-signin .alert-danger {
            color: #fff !important;
            background: rgba(221, 53, 69, 0.89) !important;
            border-color: #c9302c !important;
        }
        .form-signin .atomic-symbol.h3 {
            font-size: 24px !important;
            max-width: 100%;
            word-wrap: break-word;
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('/elitvid_assets/img/logomi.png') }}">
</head>

<body id="mimin" class="dashboard form-signin-wrapper">

@yield('login_and_registration')

<!-- end: Content -->
<!-- start: Javascript -->
<script src="{{asset('/elitvid_assets/js/jquery.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/bootstrap.min.js')}}"></script>


<!-- plugins -->
<script src="{{asset('/elitvid_assets/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/fullcalendar.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/jquery.nicescroll.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/jquery.vmap.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/jquery.vmap.sampledata.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/chart.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/dropzone.js')}}"></script>
<script src="{{asset('/elitvid_assets/js/plugins/jquery.nicescroll.js')}}"></script>


<!-- custom -->
<script src="{{asset('/elitvid_assets/js/main.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Страницы входа и регистрации — без лишних плагинов
    });
</script>
<!-- end: Javascript -->

</body>
</html>
