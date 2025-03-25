@extends('layouts.app')
@section('content')

<div class="carousel">
<div class="slider">
    <div class="slides">
      <div class="slide"><img src="{{ asset('images/いろいろ定食.png') }}" alt="Slide 1"></div>
      <div class="slide"><img src="{{ asset('images/いろいろ定食2.png') }}" alt="Slide 1"></div>
      <div class="slide"><img src="{{ asset('images/いろいろ定食3.png') }}" alt="Slide 1"></div>
    </div>
 
    <div class="controls">
      <button class="prev">&#10094;</button>
      <button class="next">&#10095;</button>

    </div>
  </div>
</div>
<!--
<div class="ranking-container" style="padding: 20px;">
    <h2>🥇 売上ランキング TOP10 🥇</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>順位</th>
                <th>商品名</th>
                <th>販売個数</th>
                <th>売上金額</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ranking as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total_quantity }}個</td>
                    <td>¥{{ number_format($item->total_sales) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>-->
<div class="ranking-container" style="padding: 20px;">

    {{-- ▼ ジャンル選択ドロップダウン --}}
    <form method="GET" action="{{ route('index') }}" style="margin-bottom: 15px;">
        <label for="genre">ジャンルを選択：</label>
        <select name="genre" id="genre" onchange="this.form.submit()">
            <option value="">指定なし（全体）</option>
            <option value="set_meal" {{ request('genre') == 'set_meal' ? 'selected' : '' }}>定食</option>
            <option value="dish" {{ request('genre') == 'dish' ? 'selected' : '' }}>丼/麺</option>
            <option value="side_menu" {{ request('genre') == 'side_menu' ? 'selected' : '' }}>サイドメニュー</option>
        </select>
    </form>

    {{-- ▼ 見出しの変化 --}}
    <h2>
        🥇 売上ランキング TOP10 🥇
        @if ($genre == 'set_meal')
            （定食）
        @elseif ($genre == 'dish')
            （丼/麺）
        @elseif ($genre == 'side_menu')
            （サイドメニュー）
        @endif
    </h2>

    {{-- ▼ ランキングテーブル --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>順位</th>
                <th>商品名</th>
                <th>販売個数</th>
                <th>売上金額</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ranking as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total_quantity }}個</td>
                    <td>¥{{ number_format($item->total_sales) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">該当するデータがありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<x-news :news="$news" />
@endsection