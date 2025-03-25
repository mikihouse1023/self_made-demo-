<div class="a-container">
    <img src="{{ asset('images/SetMealShop_Logo.png') }}" class="image1">

    <!-- ハンバーガーメニューのボタン -->
    <button class="hamburger" onclick="toggleMenu()">
        <div class="white-line"></div>
        <div class="white-line"></div>
        <div class="white-line"></div>
    </button>

    <!-- ナビゲーションメニュー -->
    <div class="header_nav">
        <a href="{{ route('index')}}">ホーム</a>
        <a href="{{ route('menu')}}">メニュー</a>
        <a href="{{ route('order.index')}}">オーダー</a>
        <a href="{{ route('minigame')}}" >ミニゲーム</a>
        <a href="{{ route('stamps.view') }}">スタンプ/クーポン</a>
        <a>お知らせ</a>
    </div>
</div>

<style>
    .hamburger {
        display: none;
        /* デフォルトでは非表示 */
        font-size: 30px;
        background: none;
        border: none;
        cursor: pointer;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        width: 100px;
        height: 90px;
        background-color: silver;
        padding: 10px;
        margin-left: auto;
        position: relative;
        /* 修正: 初期状態では relative */
        z-index: 5;
        border-radius: 10px;
     
    }

    .white-line {
        width: 100%;
        height: 10px;
        background-color: white;
        border-radius: 4px;
        transition: transform 0.3s ease, opacity 0.3s ease, background-color 0.3s ease;
    }

    .header_nav a {
        padding: 10px;
        text-decoration: none;
        color: black;
        display: inline-block;
        /* 横並びにする */
        text-align: center;
        position: relative;
        /* 擬似要素を正しく配置するため */
    }

    .header_nav a::after {
        content: "";
        display: block;
        width: 0%;
        height: 5px;
        background-color: blue;
        position: absolute;
        bottom: 0;
        left: 50%;
        border-radius: 5px;
        transform: translateX(-50%);
        transition: width 0.3s ease-in-out;
    }

    /* カーソルを合わせたときに線を100%表示 */
    .header_nav a:hover::after {
        width: 100%;
    }


    /* ハンバーガーメニューが開いたとき（×の状態） */
    .hamburger.open {
        position: fixed;
        /* 画面上部に固定 */
        background-color: red;
        z-index: 1000;
    }

    /* × の形に変化 */
    .hamburger.open .white-line:nth-child(1) {
        transform: translateY(30px) rotate(45deg);

    }

    .hamburger.open .white-line:nth-child(2) {
        opacity: 0;
        /* 真ん中の線を非表示 */
    }

    .hamburger.open .white-line:nth-child(3) {
        transform: translateY(-30px) rotate(-45deg);

    }

    /* 画面幅が768px以下のときにハンバーガーメニューを表示 */
    @media (max-width: 768px) {
        .hamburger {
            display: flex;
            position: fixed;
            /* 修正: ハンバーガーを画面上に固定 */
            right: 60px;
        }

        .header_nav {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 3;
            opacity: 0;
            visibility: hidden;
            width: 90%;
            height: 300px;
            flex-flow: column;
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s ease, visibility 0.3s ease;
            background-color: #CCFFCC;

        }

        .header_nav a {
            padding: 10px;
            text-decoration: none;
            color: black;
            display: block;
            text-align: center;
            width: 100%;
            position: relative;
            /* 擬似要素を正しく配置するために必要 */
        }
        .header_nav a:hover::after {
        width: 30%;
        height:5px;
    }


        .header_nav.show {
            opacity: 1;
            visibility: visible;
        }
    }

    /* 画面幅が769px以上のときはハンバーガーメニューを確実に非表示 */
    @media (min-width: 769px) {
        .hamburger {
            display: none;
        }
    }
</style>

<script>
    function toggleMenu() {
        document.querySelector('.header_nav').classList.toggle('show');
        document.querySelector('.hamburger').classList.toggle('open'); // .open クラスを追加
    }
</script>