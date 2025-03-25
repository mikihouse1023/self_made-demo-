@props(['orders'])

@foreach ($orders as $orderCode => $orderItems)
@php
// ✅ クーポン適用前の合計金額
$totalAmount = $orderItems->sum(fn($item) => $item->price * $item->quantity);

// ✅ `orders` テーブルの `discounted_total` を取得
$discountedTotal = $orderItems->first()->discounted_total ?? $totalAmount;

$isReserved = $orderItems->first()->is_reserved ?? false; // 予約状態を取得
$reservedAt = $orderItems->first()->reserved_at ?? null; // 予約時間を取得
@endphp
<div class="order-container @if($isReserved) reserved @endif">
    <h3>注文コード: {{ $orderCode }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>商品名</th>
                <th>値段</th>
                <th>数量</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->price) }}円</td>
                <td>{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>合計金額（クーポン適用前）: <strong>{{ number_format($totalAmount) }} 円</strong></h4>
    <h4>クーポン適用後の合計金額: <strong>{{ number_format($discountedTotal) }} 円</strong></h4>

    <button onclick="location.href='{{ route('order.qr', ['orderCode' => $orderCode]) }}'" class="QR-button">
        QRコードを発行
    </button>


    @if(!$isReserved)
    <!-- <form action="{{ route('order.reserve', ['orderCode' => $orderCode]) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="reserve-button">予約する</button>
            </form>-->
    <!-- 予約フォームページへ遷移 -->
    <a href="{{ route('order.reservation', ['orderCode' => $orderCode]) }}" class="btn btn-primary">予約する</a>
    @else
    <!--<span class="reserved-label">予約済み</span>-->
    <p class="reserved-label">予約済み （{{ \Carbon\Carbon::parse($reservedAt)->format('Y年n月j日 H:i') }}）</p>
            <!-- 予約解除ボタン -->
            <form action="{{ route('order.cancel', ['orderCode' => $orderCode]) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="cancel-button" onclick="return confirm('予約を解除しますか？');">予約解除</button>
            </form>
    @endif


    <form action="{{ route('order.delete', ['orderCode' => $orderCode]) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button" onclick="return confirm('この注文を削除しますか？');">
            注文を削除
        </button>
    </form>
    @endforeach