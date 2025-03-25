@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container" style=gap:20px;>
    <h1>登録情報確認</h1>
    <div class="l-form">

        <form action="{{route('registration.complete')}}" method="post" style=gap:20px;>
            @csrf
            <label>ユーザー名</label>
            <div class="text-block">{{ $data['name'] }}</div>


            <label>メールアドレス</label>
            <div class="text-block">{{ $data['email'] }}</div>

            <label>電話番号</label>
            <div class="text-block">{{ $data['tel'] }}</div>

            <label>郵便番号</label>
            <div class="text-block">{{ $data['post'] }}</div>

            <label>住所</label>
            <div class="text-block">{{ $data['address'] }}</div>

            <label>パスワード</label>
            <div class="text-block">********</div>


            <div class="button-container">
                <input type="button" class="back-button" onclick="location.href='{{ route('registration') }}'" value="戻る">
                <input type="submit" class="submit-button" value="登録する">
            </div>
        </form>


    </div>

</div>
</body>

@endsection