<x-mail::message>
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
            <h4>Имя пользователя: <span>{{$data['name']}}</span>.</h4>
            <h4>Телефон для связи пользователя: <span>{{$data['phone']}}</span>.</h4>
        </div>
    </div>
</x-mail::message>