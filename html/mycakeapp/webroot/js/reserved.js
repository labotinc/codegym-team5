$(window).on('load', () => {

  //アカウントを削除ボタンを押した時にポップアップを表示させる
  $('.cancel').on('click', (e) => {
    const getElement = function (tagName, className, text) {
      return $(tagName).attr('class', className).text(text);
    };
    const elementAppend = function (tagName, className, ...plus) {
      return $(tagName)
        .attr('class', className)
        .append(plus);
    };
    const sentence = getElement('<p>', 'sentence', '本当にこの予約をキャンセルしますか?');
    const backOrange = getElement('<p>', 'button back-orange', '戻る');
    const backGray = getElement('<p>', 'button back-gray', '削除');
    const divisionButton = elementAppend('<div>', 'flex division-button', backOrange, backGray);
    const backWhite = elementAppend('<div>', 'back-white', sentence, divisionButton);
    const backBlack = elementAppend('<div>', 'back-black', backWhite);
    $('.backButton').after(backBlack);
    const deletePaymentSchedule = e.target.id;
    const column = $(e.target).prev().find('.seatColumn').text();
    const record = $(e.target).prev().find('.seatRecord').text();
    //戻るボタンを押したときにポップアップを消す
    $(document).on('click', '.back-orange', () => {
      $('.back-black').remove();
    });
    //削除ボタンを押した時にdeleteアクションへ遷移する
    $(document).on('click', '.back-gray', () => {
      const params = '?id=' + deletePaymentSchedule + '&column=' + column + '&record=' + record;
      location.href = 'http://localhost:10380/mypage/canceled'+ params;
    });
  });

})
