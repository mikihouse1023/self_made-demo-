@extends('layouts.app')

@section('content')
<div class="container">
    <h1>QRコードをスキャンしました</h1>
    <p>注文コード: {{ $orderCode }}</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('order.scan', ['orderCode' => $orderCode]) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">読み込み完了</button>
</form>

</div>
@endsection