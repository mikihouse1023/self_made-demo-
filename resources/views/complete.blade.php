@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>登録完了</h1>
        <p>注文が正常に登録されました。</p>

        @if(isset($gameCount) && $gameCount > 0)
            <div class="alert alert-success">
                <h3>🎮 ミニゲームの挑戦回数: {{ $gameCount }} 回 🎮</h3>
                <p>4桁の番号: <strong>{{ $gameCode }}</strong></p>
                <p>この番号を入力してミニゲームをプレイできます！</p>
                <a href="{{ route('minigame') }}" class="btn btn-primary">ミニゲームをプレイする</a>
            </div>
        @else
            <p>ミニゲームの回数はありません。</p>
        @endif

        <a href="{{ route('order.view') }}" class="btn btn-secondary">注文履歴に戻る</a>
    </div>
@endsection

