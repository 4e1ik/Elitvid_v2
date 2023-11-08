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
            <h3>Пользователь <span>{{$data['name']}}</span> просит вас перезвонить ему.</h3>
            <h4>Обратную  связь просит осуществить по почте: <span>{{$data['email']}}</span>.</h4>
            <h4>Пользователь представляет компанию: <span>{{$data['name_corp']}}</span>.</h4>
            <h4>Номер телефона пользователя для обратной связи: <span>{{$data['phone']}}</span>.</h4>
            @if (array_key_exists('textarea', $data))
                <h4>Комментарий пользователя: <span>{{$data['textarea']}}</span>.</h4>
            @endif
        </div>
    </div>
</x-mail::message>
