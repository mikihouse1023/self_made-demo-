@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container">
    <h1>新規会員登録</h1>

    <div class="l-form">
        <form action="{{route('registration.process')}}" method="post">
            @csrf
            @error('name')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>ユーザー名</label>
            <input class="l-input" maxlenght="256" name="name" value="{{ old('name') }}">

            @error('email')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>メールアドレス</label>
            <input class="l-input" maxlength="256" name="email" value="{{ old('email') }}">
           
            @error('tel')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>電話番号</label>
            <input class="l-input" maxlength="256" name="tel" value="{{ old('tel') }}">

            @error('post')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>郵便番号</label>
            <input class="l-input" maxlength="256" name="post" value="{{ old('post') }}">

            @error('address')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>住所</label>
            <input class="l-input" maxlength="256" name="address" value="{{ old('address') }}">

            @error('password')
            <div class="error">※{{$message}}</div>
            @enderror
            <label>パスワード</label>
            <input class="l-input" maxlength="256" name="password" type="password">


            <label>パスワード確認</label>
            <input class="l-input" maxlength="256" name="password_confirmation" type="password">

            <div class="button-container" style="padding-bottom:20px;">
            <input type="button" class="back-button" onclick="location.href='{{ route('login') }}'" value="戻る">
            <input type="submit" class="submit-button" value="登録">
            </div>
        </form>
       
   
    </div>

</div>
</body>

@endsection