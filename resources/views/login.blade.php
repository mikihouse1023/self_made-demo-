@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="l-container">
    <img src="{{asset('images/SetMealShop_Logo.png')}}" class="image2">

    <h1>■ログイン画面</h1>
    <div class="l-form">
        <form action="{{ route('login.process')}}" method="post" novalidate>
            @csrf
            @error('email')
            <div class="error">※{{$message}}</div>
            @enderror
            
                <label>
                    メールアドレス
                </label>
                <input class="l-input" maxlength="256" name="email">
         
            @error('password')
            <div class="error">※{{ $message }}</div>
            @enderror
         
                <label>
                    パスワード
                </label>
                <input class="l-input" maxlength="256" name="password">
        
            <div class="button-container">
                <input type="submit" class="login-button" value="ログイン">
            </div>
        </form>
    </div>


    <a href="{{ route('registration')}}" class="link">ユーザー登録はこちら</a>
</div>

</body>
@endsection