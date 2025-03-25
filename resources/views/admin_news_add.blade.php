@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container">
    <h1>■新規ニュース登録</h1>

<div class="w-form">
<form action="{{ route('admin.news.add') }}" method="post" novalidate>
    @csrf
    @error('date')
    <div class="error">※{{ $message }}</div>
    @enderror
    <label>日付</label>
    <input type="date" class="w-input" maxlength="256" name="date" value="{{ old('date') }}">
    @error('category')
    <div class="error">※{{ $message }}</div>
    @enderror
    <label>カテゴリ</label>
    <input class="w-input" maxlength="256" name="category" value="{{ old('category') }}">
    @error('is_new')
    <div class="error">※{{ $message }}</div>
    @enderror
    <label>ニュース種別</label>
    <select id="field" name="is_new" class="w-select">
        <!--<option value="0">non_new</option>
        <option value="1">new</option>-->
        <option value="0" {{ old('is_new') == '0' ? 'selected' : '' }}>non_new</option>
        <option value="1" {{ old('is_new') == '1' ? 'selected' : '' }}>new</option>
    </select>

    @error('title')
    <div class="error">※{{ $message }}</div>
    @enderror
    <label>タイトル</label>
    <input class="w-input" maxlength="256" name="title" value="{{ old('title') }}">

    @error('description')
    <div class="error">※{{ $message }}</div>
    @enderror
    <label>詳細</label>
    <input type="textarea" class="w-input" maxlength="256" name="description" value="{{ old('description') }}">

    <input type="hidden" name="tab" value="user">
    <div class="button-container">
        <button type="button" onclick="location.href='{{ route('admin.index', ['tab' => request('tab', 'news')]) }}'" class="back-button">戻る</button>

        <input type="submit" class="submit-button" value="登録">
    </div>
</form>
</div>
</div>
@endsection