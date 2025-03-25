<div>
    <h2>売上一覧</h2>
    <table border="1">
        <thead>
            <tr>
                <th>注文コード</th>
                <th>ユーザーID</th>
                <th>購入日時</th>
                <th>購入商品</th>
                <th>合計金額</th>
                <th>使用クーポン金額</th>
                <th>クーポン適用後の金額</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->order_code }}</td>
                    <td>{{ $sale->user_id }}</td>
                    <td>{{ $sale->created_at }}</td>
                    <td>{{ $sale->product_names }}</td>
                    <td>{{ number_format($sale->total_amount) }}円</td>
                    <td>{{ number_format($sale->total_amount - $sale->discounted_total) }}円</td>
                    <td>{{ number_format($sale->discounted_total) }}円</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $sales->appends(['tab' => 'sales'])->links() }}
    </div>
</div>
