document.addEventListener("DOMContentLoaded", function () {
    const track = document.querySelector(".slides");
    const slides = document.querySelectorAll(".slide");
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");

    let currentIndex = 1; // クローンを考慮して最初は2番目のスライドを表示
    let slideWidth = slides[0].clientWidth;

    // スライダーの初期化関数
    function initializeSlider() {
        slideWidth = slides[0].clientWidth;

        // トラックの幅を再計算
        track.style.width = `${slides.length * slideWidth}px`;

        // 現在のスライド位置に合わせて位置を設定
        track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    // 最初と最後のスライドをクローン
    const firstClone = slides[0].cloneNode(true);
    const lastClone = slides[slides.length - 1].cloneNode(true);

    // クローンを追加
    track.appendChild(firstClone); // 最後に追加
    track.insertBefore(lastClone, slides[0]); // 最初に追加

    // クローン追加後のスライドリストを再取得
    const updatedSlides = document.querySelectorAll(".slide");

    // スライド位置を更新する関数
    function updateSliderPosition() {
        track.style.transition = "transform 0.5s ease-in-out";
        track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    // 次のスライドに移動
    function nextSlide() {
        if (currentIndex >= updatedSlides.length - 1) return;
        currentIndex++;
        updateSliderPosition();

        // クローンを考慮したリセット処理
        if (currentIndex === updatedSlides.length - 1) {
            setTimeout(() => {
                track.style.transition = "none";
                currentIndex = 1; // 最初の本物のスライドに戻す
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            }, 500);
        }
    }

    // 前のスライドに移動
    function prevSlide() {
        if (currentIndex <= 0) return;
        currentIndex--;
        updateSliderPosition();

        // クローンを考慮したリセット処理
        if (currentIndex === 0) {
            setTimeout(() => {
                track.style.transition = "none";
                currentIndex = updatedSlides.length - 2; // 最後の本物のスライドに戻す
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            }, 500);
        }
    }

    // イベントリスナーを設定
    prevButton.addEventListener("click", prevSlide);
    nextButton.addEventListener("click", nextSlide);

    // ページロード後にスライダーを初期化
    window.addEventListener("load", initializeSlider);

    // ウィンドウリサイズ時にスライダーを再初期化
    window.addEventListener("resize", initializeSlider);
});
