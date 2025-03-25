@foreach($dishes as $meal)
<div class="admin-container">


    <div class="category">
        <div class="category_name">
            <p>id</p>
        </div>
        <div class="category_content">
            <p>{{ $meal->id }}</p>
        </div>

    </div>


    <div class="category">
        <div class="category_name">
            <p>商品名</p>
        </div>
        <div class="category_content">
            <p>{{ $meal->name }}</p>

        </div>
    </div>


    <div class="category">
        <div class="category_name">
            <p>値段</p>
        </div>
        <div class="category_content">
            <a>¥{{ $meal->val }}</a>

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>商品説明</p>
        </div>
        <div class="category_content">
            <a>{{ $meal->explanation }}</a>

        </div>
    </div>
    <div class="category">
        <div class="category_name">

            <p>写真</p>
        </div>
        <div class="category_content">
        <a><img class="admin_picture" src="{{ asset('storage/' . $meal->picture) }}" alt="{{ $meal->name }}">
        </a>
        </div>
    </div>
    <div class="category">
        <div class="category_name">
            <p>ジャンル</p>
        </div>
        <div class="category_content">
            <a>{{ $meal->genre }}</a>

        </div>
    </div>

</div>
@endforeach

<div class="pagination">
    {{ $dishes->appends(['tab' => 'set_meal', 'dish_page' => request('dish_page')])->links() }}
</div>