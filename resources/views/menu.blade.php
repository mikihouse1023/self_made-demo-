@extends('layouts.app')
@section('content')

<div class="one-button-container">
<button onclick="location.href='{{ route('cart.view') }}'" class="accounting-button">お会計</button>
</div>

<div class="tabs">

  <div class="tab-menu">
    <a href="?tab=set_meal" data-tab="set_meal" class="tab-link w-inline-block w-tab-link {{ $tab === 'set_meal' ? 'w--current' : '' }}">
    定食<br>"Set_Meal"
    </a>
    <a href="?tab=dish" data-tab="dish" class="tab-link w-inline-block w-tab-link {{ $tab === 'dish' ? 'w--current' : '' }}">
      丼・麺<br>"Bowl&Noodles"
    </a>
    <a href="?tab=side_menu" data-tab="side_menu" class="tab-link w-inline-block w-tab-link {{ $tab === 'side_menu' ? 'w--current' : '' }}">
      サイドメニュー<br>"Side_Menu"
    </a>
  </div>
</div>
<div class="tab-content">
  <div id="set_meal" class="w-tab-pane fade " style="{{ $tab === 'set_meal' ? 'display: block;' : 'display: none;' }}">
    <h1>■定食</h1>
    <x-item :items="$set_meals" category="set_meal" />
  </div>
  <div id="dish" class="w-tab-pane fade " style="{{ $tab === 'dish' ? 'display: block;' : 'display: none;' }}">
    <h1>■丼・ラーメン</h1>
    <x-item :items="$dishes" category="dishe" />
  </div>
  <div id="side_menu" class="w-tab-pane fade" style="{{ $tab === 'side_menu' ? 'display: block;' : 'display: none;' }}">
    <h1>■サイドメニュー</h1>
    <x-item :items="$side_menus" category="side_menu" />
  </div>


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