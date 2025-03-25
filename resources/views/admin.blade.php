@extends('layouts.app_login')
@section('content')

<h1>ADMIN画面</h1>
<div class="tabs">
  <div class="tab-menu">
    <a href="?tab=set_meal" data-tab="set_meal" class="tab-link w-inline-block w-tab-link {{ $tab === 'set_meal' ? 'w--current' : '' }}">
      メニュー
    </a>
    <a href="?tab=news" data-tab="news" class="tab-link w-inline-block w-tab-link {{ $tab === 'news' ? 'w--current' : '' }}">
      ニュース
    </a>
    <a href="?tab=user" data-tab="user" class="tab-link w-inline-block w-tab-link {{ $tab === 'user' ? 'w--current' : '' }}">
      ユーザー
    </a>
    <a href="?tab=sales" data-tab="sales" class="tab-link w-inline-block w-tab-link {{ $tab === 'sales' ? 'w--current' : '' }}">
      売上管理
    </a>
    <a href="?tab=reservations" data-tab="reservations" class="tab-link w-inline-block w-tab-link {{ $tab === 'reservations' ? 'w--current' : '' }}">
      予約リスト
    </a>
  </div>
</div>

<div class="tab-content">

  <div id="set_meal" class="w-tab-pane fade " style="{{ $tab === 'set_meal' ? 'display: block;' : 'display: none;' }}">
    <div class="one-button-container"><button onclick="location.href='{{ route('admin.food_add') }}'" class="add-button">商品追加</button></div>

    <h1>■メニュー</h1>
    <h1>定食</h1>
    <x-item-admin :items="$set_meals" category="set_meals" />
    <h1>丼・麺</h1>

    <x-item-admin :items="$dishes" category="dishes" />
    <h1>サイドメニュー</h1>
    <x-item-admin :items="$side_menus" category="side_menus" />
  </div>

  <div id="news" class="w-tab-pane" style="{{ $tab === 'news' ? 'display: block;' : 'display: none;' }}">

    <h1>■ニュース</h1>
    <div class="one-button-container">
      <button class="add-button" onclick="location.href='{{ route('admin.news_add') }}'" style="margin-right:50px;">ニュース登録</button>
    </div>
    <h2>ニュース</h2>
    <x-news-admin :news="$news" />
  </div>

  <div id="user" class="w-tab-pane" style="{{ $tab === 'user' ? 'display: block;' : 'display: none;' }}">
    <h1>■ユーザー情報</h1>
    <div class="one-button-container">
      <button class="add-button" onclick="location.href='{{ route('admin.user_add') }}'" style="margin-right:50px;">ユーザー登録</button>
    </div>
    <h2>一般ユーザー</h2>
    <x-user-list-admin :users="$users" />

    <h2>管理ユーザー</h2>
    <x-admin-list-admin :admins="$admins" />


  </div>

  <div id="sales" class="w-tab-pane" style="{{ $tab === 'sales' ? 'display: block;' : 'display: none;' }}">
    <h1>■ 売上管理</h1>
    <x-sale-list-admin :sales="$sales" />
  </div>


  <div id="reservations" class="w-tab-pane" style="{{ $tab === 'reservations' ? 'display: block;' : 'display: none;' }}">
    <h1>■ 予約リスト</h1>
    <x-reservation-list-admin :reservations="$reservations" />
  </div>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const tabs = document.querySelectorAll(".tab-link");
      const panes = document.querySelectorAll(".w-tab-pane");

      const urlParams = new URLSearchParams(window.location.search);
      const activeTab = urlParams.get("tab") || "set_meal";

      // 初期表示のタブを設定
      tabs.forEach((tab) => {
        const targetId = tab.getAttribute("data-tab");
        const targetPane = document.getElementById(targetId);

        if (targetId === activeTab) {
          tab.classList.add("w--current");
          targetPane.style.display = "block";
          targetPane.style.opacity = "1";
        } else {
          tab.classList.remove("w--current");
          targetPane.style.display = "none";
          targetPane.style.opacity = "0";
        }
      });

      // タブクリック時の処理
      tabs.forEach((tab) => {
        tab.addEventListener("click", function(e) {
          e.preventDefault();
          const targetId = this.getAttribute("data-tab");
          const currentTab = document.querySelector(".tab-link.w--current");
          const currentPane = document.querySelector(".w-tab-pane[style*='display: block;']");
          const targetPane = document.getElementById(targetId);

          if (currentTab === this) return;

          // フェードアウト処理
          if (currentPane) {
            currentPane.classList.add("fade-out");
            currentPane.style.opacity = "0";

            setTimeout(() => {
              currentPane.style.display = "none";
              currentPane.classList.remove("fade-out");

              // フェードイン処理
              targetPane.style.display = "block";
              targetPane.classList.add("fade-in");
              setTimeout(() => {
                targetPane.style.opacity = "1";
                targetPane.classList.remove("fade-in");
              }, 50);
            }, 500);
          }

          // タブの状態を更新
          tabs.forEach((t) => t.classList.remove("w--current"));
          this.classList.add("w--current");

          // URLを更新
          const newUrl = new URL(window.location.href);
          newUrl.searchParams.set("tab", targetId);
          history.pushState(null, "", newUrl);
        });
      });
    });
  </script>

  @endsection