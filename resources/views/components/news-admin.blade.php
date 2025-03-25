@foreach($news as $item)
<div class="admin-container">


    <div class="category">
        <div class="category_name">
            <p>id</p>
        </div>
        <div class="category_content">
            <p>{{ $item->id }}</p>
        </div>

    </div>


    <div class="category">
        <div class="category_name">
            <p>日付</p>
        </div>
        <div class="category_content">
            <p>{{ $item->date }}</p>

        </div>
    </div>


    <div class="category">
        <div class="category_name">
            <p>カテゴリー</p>
        </div>
        <div class="category_content">
            <a>{{ $item->category }}</a>

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>タイトル</p>
        </div>
        <div class="category_content">
            <a>{{ $item->title }}</a>

        </div>
    </div>
    <div class="category" style="overflow: hidden;">
        <div class="category_name">

            <p>詳細説明</p>
        </div>
        <div class="category_content">
            <a>{{ $item->description }}</a>
        </div>
    </div>
    <div class="category">
        <div class="ed-container">
            <button type="button" class="edit-button"
                onclick="location.href='{{ route('admin.news.edit', ['id' => $item->id]) }}'">
                編集
            </button>
            <form class="ed-form" action="{{ route('admin.news.delete', ['id' => $item->id]) }}" method="POST"
                onsubmit="return confirm('本当に削除しますか？');">

                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">削除</button>
            </form>
        </div>
    </div>
</div>
@endforeach