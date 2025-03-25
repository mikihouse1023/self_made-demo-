@props(['item', 'delete' => false])

<div class="cart-item">
    <div class="cart-details">
        <!-- 商品画像 -->

        <img src="{{ $item->image }}" alt="{{ $item->name }}" style="object-fit: cover;" class="cart-image">


        <!-- 商品情報 -->

        <p class="cart-name">{{ $item->name }}</p>
        <p class="cart-price">{{ $item->price }}円（税込）</p>
    </div>

    <!-- 削除ボタン -->

    @if ($delete)
    <div class="cart-button-container">
        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="cart-remove">
            @csrf
            <button type="submit" class="cart-delete-button">削除</button>
        </form>
    </div>
    @endif

</div>