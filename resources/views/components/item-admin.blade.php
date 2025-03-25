@props(['items', 'category']) {{-- category を受け取る --}}
@foreach($items as $item)
<div class="admin-container">


    <div class="category">
        <div class="category_name">
            <p>id</p>
        </div>
        <div class="category_content">
            <a>{{ $item->id }}</a>
        </div>

    </div>


    <div class="category">
        <div class="category_name">
            <p>商品名</p>
        </div>
        <div class="category_content">
            <a>{{ $item->name }}</a>

        </div>
    </div>


    <div class="category">
        <div class="category_name">
            <p>値段</p>
        </div>
        <div class="category_content">
            <a>¥{{ $item->val }}</a>

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>商品説明</p>
        </div>
        <div class="category_content" >
            <a style="font-size:15px;" >{{ $item->explanation }}</a>

        </div>
    </div>
    <div class="category">
        <div class="category_name">

            <p>写真</p>
        </div>
        <div class="category_content">
        <img class="admin_picture" src="{{ '/storage/images/' . basename($item->picture) }}" alt="{{ $item->name }}">

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>ジャンル</p>
        </div>
        <div class="category_content">
            <a>{{ $item->genre }}</a>

        </div>
    </div>


    <div class="category">
        <div class="ed-container">
            <button type="button" class="edit-button" onclick="location.href='{{ route('admin.food.edit', ['id' => $item->id, 'category' => $category]) }}'">
                編集
            </button>
            <form class="ed-form" action="{{ route('admin.food.delete', ['id' => $item->id, 'category' => $category]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">

                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">削除</button>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="pagination">
    {{ $items->appends(request()->query())->links() }}
</div>