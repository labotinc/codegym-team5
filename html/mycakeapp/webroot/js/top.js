$(window).on('load', () => {

  // $('.mini-nav:first-child').addClass('back-black');

  $(".slick-slider").slick({
    autoplay: true, // 自動再生を設定
    autoplaySpeed: 2000, // 自動再生のスピード（ミリ秒単位）
    dots: true, // ドットインジケーターの表示
    arrows: false
  });
})
