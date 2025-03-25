@props(['items', 'category'])
<div class="items-wrapper">
    @foreach($items as $item)
    <div class="item-container">
        <div class="item">
            <p class="item-title">{{ $item->name }}</p>
            <p><img src="{{ asset('storage/' . $item->picture) }}" alt="{{ $item->name }}" class="image-item" style="width:100%;"></p>
            <p class="item-price">{{ $item->val }}円</p>
            <p class="item-explanation">{{ $item->explanation }}</p>
            <form action="{{ route('cart.add') }}" class="order-form" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="category" value="{{ $category }}"> <!-- カテゴリを追加 -->
                <input type="hidden" name="name" value="{{ $item->name }}">
                <input type="hidden" name="price" value="{{ $item->val }}">
                <input type="hidden" name="image" value="{{ asset('storage/' . $item->picture) }}">
                <button type="submit" class="order-button">注文する</button>
            </form>
        </div>
    </div>
    @endforeach
</div>