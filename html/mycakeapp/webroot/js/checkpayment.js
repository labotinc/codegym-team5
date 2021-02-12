$(window).on('load', () => {
  const getElement = function (tagName, className, text) {
    return $(tagName).attr('class', className).text(text);
  };
  const elementAppend = function (tagName, className, ...plus) {
    return $(tagName)
      .attr('class', className)
      .append(plus);
  };

  const paymentButtons = document.getElementsByClassName('delete-payment');
  for (let i = 0; i < paymentButtons.length; i++) {
    const deletePaymentButton = paymentButtons.item(i);
    $(deletePaymentButton).on('click', () => { //削除ボタンが押されたとき
      // ポップアップを作成 .back-black>.back-white>.divisionButton+.sentence
      const sentence = getElement('<p>', 'sentence', '本当にこのアカウントを消しますか?');
      const backOrange = getElement('<p>', 'button back-orange return', '戻る');
      const backGray = getElement('<a>', 'button back-gray delete', '削除');
      const divisionButton = elementAppend('<div>', 'flex division-button', backOrange, backGray);
      const backWhite = elementAppend('<div>', 'back-white', sentence, divisionButton);
      const backBlack = elementAppend('<div>', 'back-black', backWhite);
      $('.content').append(backBlack);
      //戻るボタンを押したときにポップアップを消す
      $('.return').on('click', () => {
        $('.back-black').remove();
      });
      //削除ボタンを押した時にdeletepaymentアクションへ遷移する
      $('.delete').on('click', () => {
        const cardId = deletePaymentButton.id;
        location.href = 'http://localhost:10380/mypage/deletepayment?id=' + cardId;
      });
    });
  };
  $('.add-payment').on('click', (e) => {
    if ($('.add-payment').hasClass('pressed')) { //無効ボタン化済みの時は↓の.add-paymentイベントは反応させない
      e.preventDefault
      e.stopImmediatePropagation();
    };
  });
  if (paymentButtons.length !== 2) {
    $('.add-payment').on('click', () => {
      location.href = 'http://localhost:10380/mypage/addpayment';
    });
  } else {
    $('.add-payment').on('click', () => {
      $('.add-payment').addClass('pressed'); //ボタンを無効化するクラス
      const addPaymentError = getElement('<p>', 'add-payment-error', '登録できるクレジットカードは2件までです');
      $('.content').append(addPaymentError);
    });
  }
});
