<x-mail::message>
    {{--    <div class="background" style="background-color: black; display: flex; flex-direction: column;">--}}
    {{--        Имя:--}}
    {{--        Почта:--}}
    {{--        Название компании:--}}
    {{--        Номер телефона:--}}
    {{--        @if (array_key_exists('file', $data))--}}
    {{--            Файл: {{$data['file']}}--}}
    {{--        @endif--}}

    {{--    </div>--}}

    {{--    <style>--}}
    {{--        .background {--}}
    {{--            background: rgba(0, 0, 0, 0.4);--}}
    {{--            border-radius: 15px;--}}
    {{--        }--}}

    {{--        .background .content {--}}
    {{--            padding: 30px;--}}
    {{--            display:flex;--}}
    {{--            flex-direction: column;--}}
    {{--            align-items:center;--}}
    {{--        }--}}

    {{--        .background .content span {--}}
    {{--            font-weight: bold;--}}
    {{--        }--}}
    {{--    </style>--}}

    <div class="background" style="
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
        ">
        <div class="content" style="
                color: #fff;
                padding: 30px;
                display:flex;
                flex-direction: column;
                align-items:center;
            ">
            @if (array_key_exists('name', $data))
                <h4>Комментарий пользователя: <span>{{$data['name']}}</span>.</h4>
            @endif
            @if (array_key_exists('email', $data))
                <h4>Комментарий пользователя: <span>{{$data['email']}}</span>.</h4>
            @endif
            @if (array_key_exists('name_corp', $data))
                <h4>Комментарий пользователя: <span>{{$data['name_corp']}}</span>.</h4>
            @endif
            @if (array_key_exists('phone', $data))
                <h4>Комментарий пользователя: <span>{{$data['phone']}}</span>.</h4>
            @endif
            @if (array_key_exists('textarea', $data))
                <h4>Комментарий пользователя: <span>{{$data['textarea']}}</span>.</h4>
            @endif
        </div>
    </div>
</x-mail::message>
