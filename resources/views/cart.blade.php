@extends('layouts.app')

@section('content')

    <div style="display:flex;">
        <h1 style="width:60%;margin:0 auto;">■注文内容</h1>
    </div>

    <!-- カートの中身を表示 -->
    @if ($cartItems->isEmpty())
        <p>カートに商品がありません。</p>
    @else
        <ul role="list" class="w-list-unstyled">
            @foreach($cartItems as $item)
                <li class="list-item">
                    <x-cart-item :item="$item" :delete="true" />
                </li>
            @endforeach
        </ul>

        {{-- ✅ クーポン適用フォーム --}}
        <h3>使用可能なクーポン</h3>
        <form action="{{ route('cart.applyCoupon') }}" method="POST">
            @csrf
            <label for="coupon">クーポンを選択:</label>
            <select name="coupon_id" id="coupon" class="form-control">
                <option value="">クーポンを使用しない</option> {{-- ✅ 常に表示 --}}
                @foreach($coupons as $coupon)
                    <option value="{{ $coupon->id }}">{{ $coupon->code }} - 割引 {{ $coupon->discount_value }}円</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary mt-2">クーポンを適用</button>
        </form>

    @endif

    {{-- ✅ 合計金額の表示 --}}
    <div style="text-align:center; margin-top:20px;">
    <h2>合計金額: <span id="total-price">
        {{ number_format($discountedTotal) }} 円
    </span></h2>
</div>


    <div class="button-container" style="margin:0 auto;">
        <button class="back-button" onclick="location.href='{{ route('menu') }}'">戻る</button>   
        <form action="{{ route('cart.register') }}" method="POST">
            @csrf
            <button type="submit" class="registration-button">登録</button>
        </form>
    </div>

@endsection
