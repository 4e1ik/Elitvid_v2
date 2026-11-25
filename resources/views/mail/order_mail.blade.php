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
            <h4>Заказ из корзины #{{ $order->id }}.</h4>
            <h4>Имя пользователя: <span>{{ $order->name }}</span>.</h4>
            <h4>Почта пользователя: <span>{{ $order->email }}</span>.</h4>
            <h4>Телефон для связи пользователя: <span>{{ $order->phone }}</span>.</h4>
            <h4>Название компании пользователя: <span>{{ $order->corporation_name ?: '—' }}</span>.</h4>
            <h4>Комментарий пользователя: <span>{{ $order->comment ?: '—' }}</span>.</h4>
            <h4>Товары:</h4>
            @foreach($order->items as $item)
                <h4><span>{{ $item->product_name }}</span></h4>
            @endforeach
        </div>
    </div>
</x-mail::message>
