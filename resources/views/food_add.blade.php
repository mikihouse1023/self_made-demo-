@props(['items', 'category']) {{-- category を受け取る --}}
@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container">
    <h1>■商品登録</h1>
    <div class="w-form">
        <form action="{{ route('admin.food.add') }}" id="email-form" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <!-- カテゴリ選択を追加 -->
            @error('category')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>カテゴリ</label>
            <select class="w-input" name="category" required>
                <option value="set_meals">定食</option>
                <option value="dishes">丼/麺</option>
                <option value="side_menus">サイドメニュー</option>
            </select>

            @error('name')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>商品名</label>
            <input class="w-input" maxlength="256" name="name" required>

            @error('val')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>値段</label>
            <input class="w-input" maxlength="256" name="val" type="number" required>

            @error('explanation')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>説明</label>
            <textarea maxlength="5000" name="explanation" class="w-input" required></textarea>

            @error('genre')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>ジャンル</label>
            <input class="w-input" maxlength="256" name="genre" required>

            @error('picture')
            <div class="error">※{{ $message }}</div>
            @enderror
            <label>商品画像</label>
            <input type="file" id="pictureInput" name="picture" class="w-input" accept="image/*" required>

            <div id="imagePreviewContainer" style="margin-top: 15px;">
                <img id="imagePreview" src="" alt="プレビュー画像" style="max-width: 300px; display: none;">
            </div>

            <div class="button-container">

        </form>
        <button type="button" onclick="location.href='{{ route('admin.index') }}'" class="back-button">戻る</button>

        <input type="submit" class="submit-button" value="登録">
    </div>
    <script>
        document.getElementById('pictureInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const reader = new FileReader();

            if (file) {
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</div>
</div>
</body>
@endsection