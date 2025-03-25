@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container" style=height:500px;>
    <h1>会員登録が完了しました
    </h1>
    <div class="r-form">
        <p>ご利用いただきありがとうございます<br>
            今後ともご愛顧賜りますようよろしくお願い申し上げます。<br>
            どうぞよろしくお願いいたします。
        </p>


    </div>
    <div class="button-container" style="margin-top:20px;">
        <input type='button' class="back-button" onclick="location.href='{{ route('login') }}'" value="ログイン画面に戻る">
    </div>
</div>
</body>

@endsection