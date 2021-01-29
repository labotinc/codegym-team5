$(window).on('load', () => {

  //アカウントを削除ボタンを押した時にポップアップを表示させる
  $('.delete-account a').on('click', () => {
    const getElement = function (tagName, className, text) {
      return $(tagName).attr('class', className).text(text);
    };
    const elementAppend = function (tagName, className, ...plus) {
      return $(tagName)
        .attr('class', className)
        .append(plus);
    };
    const sentence = getElement('<p>', 'sentence', '本当にこのアカウントを消しますか?');
    const backOrange = getElement('<p>', 'button back-orange', '戻る');
    const backGray = getElement('<p>', 'button back-gray', '削除');
    const divisionButton = elementAppend('<div>', 'flex division-button', backOrange, backGray);
    const backWhite = elementAppend('<div>', 'back-white', sentence, divisionButton);
    const backBlack = elementAppend('<div>', 'back-black', backWhite);
    $('.delete-account').after(backBlack);
  });

  //戻るボタンを押したときにポップアップを消す
  $(document).on('click', '.back-orange', () => {
    $('.back-black').remove();
  });
  //削除ボタンを押した時にdeleteアクションへ遷移する
  $(document).on('click', '.back-gray', () => {
    location.href = 'http://localhost:10380/mypage/delete';
  });
});
