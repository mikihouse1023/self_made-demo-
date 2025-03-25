
@foreach($set_meals as $set_meal)
<div class="admin-container">


    <div class="category">
        <div class="category_name">
            <p>id</p>
        </div>
        <div class="category_content">
            <p>{{ $set_meal->id }}</p>
        </div>

    </div>


    <div class="category">
        <div class="category_name">
            <p>ユーザー名</p>
        </div>
        <div class="category_content">
            <p>{{ $set_meal->name }}</p>

        </div>
    </div>


    <div class="category">
        <div class="category_name">
            <p>メールアドレス</p>
        </div>
        <div class="category_content">
            <a>{{ $set_meal->email }}</a>

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>電話番号</p>
        </div>
        <div class="category_content">
            <a>{{ $set_meal->tel }}</a>

        </div>
    </div>
    <div class="category">
        <div class="category_name">

            <p>住所</p>
        </div>
        <div class="category_content">
            <a>{{ $set_meal->address }}</a>
        </div>
    </div>


</div>
@endforeach 