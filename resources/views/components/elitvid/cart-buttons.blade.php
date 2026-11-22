@props(['product', 'inCart'])

{{-- Кнопки карточки товара по кадрам «кнопка добавить в корзину» / «кнопка удалить» --}}
@foreach (['', ' submit-application--mobile'] as $variant)
    <div class="submit-application{{ $variant }}">
        @if ($inCart)
            <form method="post" action="{{ route('cart.update', ['product' => $product->id]) }}">
                @csrf
                <input type="hidden" name="quantity" value="0">
                <button class="submit-application--button rd-cart-button" type="submit">Удалить</button>
            </form>
        @else
            <form method="post" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="submit-application--button rd-cart-button" type="submit">Добавить в корзину</button>
            </form>
        @endif
        <button class="submit-application--button {{ $variant ? 'open_popup_application1 submit-application-button--mobile' : 'open_popup_application' }}" type="button">
            Оставить заявку
        </button>
    </div>
@endforeach
