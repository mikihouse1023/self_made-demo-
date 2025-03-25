@props(['items', 'category']) {{-- category を受け取る --}}
@extends('layouts.app_login')
@section('content')
<body class="login-body">
<div class="register-container">
    <h1>■商品編集
    </h1>
    <div class="w-form">
    <form action="{{ route('admin.food.update', ['id' => $item->id, 'category' => $category]) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <label>カテゴリ</label>
            <select class="w-input" name="category" required>
                <option value="set_meals" {{ $category === 'set_meals' ? 'selected' : '' }}>定食</option>
                <option value="dishes" {{ $category === 'dishes' ? 'selected' : '' }}>丼/麺</option>
                <option value="side_menus" {{ $category === 'side_menus' ? 'selected' : '' }}>サイドメニュー</option>
            </select>

            <label>商品名</label>
            <input class="w-input" name="name" value="{{ old('name', $item->name) }}" required>

            <label>値段</label>
            <input class="w-input" name="val" type="number" value="{{ old('val', $item->val) }}" required>

            <label>説明</label>
            <textarea name="explanation" class="w-input" required>{{ old('explanation', $item->explanation) }}</textarea>

            <label>ジャンル</label>
            <input class="w-input" name="genre" value="{{ old('genre', $item->genre) }}" required>

            <label>商品画像</label>
            <input type="file" id="pictureInput" name="picture" class="w-input" accept="image/*">

            <div id="imagePreviewContainer" style="margin-top: 15px;">
                <img id="imagePreview" src="{{ asset('storage/' . $item->picture) }}" alt="プレビュー画像" style="max-width: 300px; display: block;">
            </div>


       
        <div class="button-container">
            <button type="button" onclick="location.href='{{ route('admin.index') }}'" class="back-button">戻る</button>

            <input type="submit" class="submit-button" value="更新">
            </form>
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
@endsection