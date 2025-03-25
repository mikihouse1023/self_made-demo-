@foreach($admins as $admin)
<div class="admin-container">


    <div class="category">
        <div class="category_name">
            <p>id</p>
        </div>
        <div class="category_content">
            <p>{{ $admin->id }}</p>
        </div>

    </div>


    <div class="category">
        <div class="category_name">
            <p>ユーザー名</p>
        </div>
        <div class="category_content">
            <p>{{ $admin->name }}</p>

        </div>
    </div>


    <div class="category">
        <div class="category_name">
            <p>メールアドレス</p>
        </div>
        <div class="category_content">
            <a>{{ $admin->email }}</a>

        </div>
    </div>

    <div class="category">
        <div class="category_name">
            <p>電話番号</p>
        </div>
        <div class="category_content">
            <a>{{ $admin->tel }}</a>

        </div>
    </div>
    <div class="category">
        <div class="category_name">

            <p>住所</p>
        </div>
        <div class="category_content">
            <a>{{ $admin->address }}</a>
        </div>
    </div>
    <div class="category">
    <div class="ed-container">
            <button onclick="location.href='{{ route('admin.user.edit',$admin->id) }}'" class="edit-button">編集</button>
            <form action="{{ route('admin.user.delete', $admin->id) }}" method="post"">
                @csrf
                <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？');">削除</button>
            </form>
        </div>

    </div>

</div>
@endforeach