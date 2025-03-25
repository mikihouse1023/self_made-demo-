@extends('layouts.app')

@section('content')
<div class="container">
    <h1>QRコード</h1>
    <p>注文コード: {{ $orderCode }}</p>
    <div class="qr-code">
        {!! $qrCode !!}
    </div>

    <h2>QRコードの読み込みを待っています...</h2>
    <p>QRコードを読み込んだら、このページは自動的に更新されます。</p>
    <p>注文コード: <strong>{{ $orderCode }}</strong></p>
    @if ($isReserved)
        <p class="qr-notice">予約時間までにこちらのQRコードを読み込ませてください。</p>
    @endif

    <script>
    function checkScanStatus() {
        fetch("{{ route('order.check', ['orderCode' => $orderCode]) }}")
            .then(response => response.json())
            .then(data => {
                console.log("QRコードチェック:", data.scanned);
                if (data.scanned) {
                    console.log("QRコードスキャン完了！ complete.blade.php に遷移します");
                    window.location.href = "{{ route('order.complete', ['orderCode' => $orderCode]) }}";
                } else {
                    setTimeout(checkScanStatus, 3000);
                }
            })
            .catch(error => console.error("エラー発生:", error));
    }

    checkScanStatus(); // ページが開かれたらすぐに実行
</script>

    <a href="{{ route('order.view') }}" class="btn btn-secondary">注文履歴に戻る</a>
</div>
@endsection