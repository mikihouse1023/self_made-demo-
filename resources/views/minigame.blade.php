@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ミニゲーム</h1>

        {{-- デバッグ用: セッションデータを確認 --}}
        <p>セッションデータ: game_count = {{ session('game_count') }}, game_code = {{ session('game_code') }}</p>

        @if(session('game_count') && session('game_count') > 0)
            <p>あなたは <strong>{{ session('game_count') }}</strong> 回のミニゲームをプレイできます！</p>

            <form method="POST" action="{{ route('minigame.play') }}">
                @csrf
                <div class="form-group">
                    <label for="game_code">4桁の番号を入力してください:</label>
                    <input type="text" name="game_code" id="game_code" class="form-control" required maxlength="4" pattern="\d{4}" placeholder="例: 1234">
                </div>
                <button type="submit" class="btn btn-primary mt-2">ゲームをプレイする</button>
            </form>
        @else
            <p>ミニゲームの回数がありません。</p>
            <a href="{{ route('order.view') }}" class="btn btn-secondary">注文履歴に戻る</a>
        @endif

        @if(session('game_result'))
            <div class="alert alert-warning mt-3">
                <h3>{{ session('game_result') }}</h3>
                <p>🎯 獲得スタンプ: <strong>{{ session('stamps_earned') }}</strong> 個</p>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                <h3>{{ session('error') }}</h3>
            </div>
        @endif
    </div>
@endsection
