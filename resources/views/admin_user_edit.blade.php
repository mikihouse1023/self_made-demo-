@extends('layouts.app_login')
@section('content')  
<body class="login-body">
<div class="register-container">
    <h1>■ユーザー編集</h1>
    <div class="w-form">
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            @error('name')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>ユーザー名</label>
            <input class="w-input" maxlength="256" name="name" value="{{ old('name', $user->name) }}">
            @error('email')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>メールアドレス</label>
            <input class="w-input" maxlength="256" name="email" value="{{ old('email', $user->email) }}">
            @error('tel')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>電話番号</label>
            <input class="w-input" maxlength="256" name="tel" value="{{ old('tel', $user->tel) }}">
            @error('post')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>郵便番号</label>
            <input class="w-input" maxlength="256" name="post" value="{{ old('post', $user->post) }}">
            @error('address')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>住所</label>
            <input class="w-input" maxlength="256" name="address" value="{{ old('address', $user->address) }}">
            
            @error('user_type')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>ユーザー種別</label>
            <select id="field" name="user_type" class="w-select">
            <option value="0" {{ old('user_type', $user->is_admin) == 0 ? 'selected' : '' }}>一般</option>
            <option value="1" {{ old('user_type', $user->is_admin) == 1 ? 'selected' : '' }}>管理者</option>
            </select>
            <input type="hidden" name="tab" value="user">
            <div class="button-container">
            <button type="button" onclick="location.href='{{ route('admin.index', ['tab' => request('tab', 'user')]) }}'" class="back-button">戻る</button>
            <input type="submit" class="submit-button" value="更新">
            </div>
        </form>
    </div>
</div>
@endsection