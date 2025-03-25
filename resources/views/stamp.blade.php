@extends('layouts.app')

@section('content')
<div class="container">
    <h1>スタンプ・クーポン</h1>
    <p>現在のスタンプ数: <strong>{{ $stamps }}</strong></p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- クーポン取得ボタン --}}
    @if($stamps >= 5 && ($stamps % 5 == 0 || !in_array(floor($stamps / 5) * 5, $redeemedStamps)))
    <form action="{{ route('stamps.redeem') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">クーポンを取得</button>
    </form>
    @else
    <p>現在のスタンプ数ではクーポンを取得できません。</p>
    @endif
    {{-- 使用可能なクーポンのリスト表示 --}}
    <h2 class="mt-4">使用可能なクーポン</h2>
    @if($coupons->isEmpty())
    <p>現在、使用可能なクーポンはありません。</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>クーポンコード</th>
                <th>割引額</th>
                <th>有効期限</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->discount_value }}円</td>
                <td>{{ \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif


    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">ホームに戻る</a>
</div>
@endsection