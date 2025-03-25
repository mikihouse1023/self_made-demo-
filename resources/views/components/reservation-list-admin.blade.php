<div>
    <table class="table">
        <thead>
            <tr>
                <th>注文コード</th>
                <th>ユーザーID</th>
                <th>予約時間</th>
                <th>人数</th>
                <th>予約内容</th>
                <th>合計金額</th>
                <th>予約キャンセル</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->order_code }}</td>
                    <td>{{ $reservation->user_id }}</td>
                    <td>{{ $reservation->reserved_at }}</td>
                    <td>{{ $reservation->guest_count }}</td>
                    <td>{{ $reservation->product_names }}</td>
                    <td>{{ number_format($reservation->total_amount) }}円</td>
                    <td>
                        <form action="{{ route('order.cancel', ['orderCode' => $reservation->order_code]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">キャンセル</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
