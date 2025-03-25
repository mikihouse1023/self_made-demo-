<!--コンポーネントを作成しない場合必要
@props(['news'])-->

<div class="News">
    <div class="News-title">
    <a style=font-size:40px;>ニュース/News</a>
    </div>
    <div class="newsList">
        @foreach($news as $item)
        <div class="news-item">
            <div class="date" style="background-color:#FFCC33;">
                <p>{{ $item->date }}</p>
            </div>

            <div class="news-category" style=background-color:green;>
                <p>{{ $item->category }}</p>
            </div>
            @if($item->is_new)
            <div class="is_new" style=background-color:red;>
                <p>NEW</p>
            </div>
            @endif
        </div>
        <div class="text">
            <div class="title">
                <a>{{ $item->title }}</a>
            </div>
        </div>
        @endforeach
    </div>
</div>