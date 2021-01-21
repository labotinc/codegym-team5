$(window).on('load', () => {

  //デフォルトで今日の日付にactiveクラスが設定されている
  $('.dateList .dateListContent:first-child').addClass('active');

  $('.dateListContent').on('click', (e) => {
    //日付が黄色になる
    $('.active').removeClass('active');
    $(e.currentTarget).addClass('active');
    //日付の表示が変わる
    $(e.currentTarget).parent().next('h2').html($(e.currentTarget).text());
    //表示されている上映スケジュールがフェードアウトする
    $('#movieList').children().fadeTo(500, 0);
    //選択された日の上映スケジュールが表示される(非同期通信を使用)
    $.ajax({
      type: 'GET',
      url: 'http://localhost:10380/main/ajax',
      dataType: 'json',
      data: { date: $(e.currentTarget).val() },
    }).done((movies) => {
      console.log('Ajax通信に成功しました');
      console.log(movies);
      let checkCount = 0
      $.each(movies, (key, movie) => {
        const week = ['日', '月', '火', '水', '木', '金', '土'];
        //↓schedule.ctpのid=movieList内の要素を構成
        if (movie['schedules'].length !== 0) {
          checkCount += 1;
          //映画タイトル・上映時間・終了予定の要素及びテキスト作成
          const title = $('<p>')
            .attr('class', 'title')
            .text(movie['name']);
          const screeningTime = $('<p>')
            .attr('class', 'screeningTime')
            .text(`[上映時間：${movie['screening_time']}分]`);
          const finishDate = $('<p>')
            .attr('class', 'finishDate')
            .text(`${new Date(movie['finished_at']).getMonth() + 1}月${new Date(movie['finished_at']).getDate()}日(${week[new Date(movie['finished_at']).getDay()]})終了予定`);
          //映画タイトル・上映時間・終了予定をmovieDetailListのdiv要素に包括
          const movieDetailList = $('<div>')
            .attr('class', 'movieDetailList')
            .append(title)
            .append(screeningTime)
            .append(finishDate);
          //movieDetailListのdiv要素をmovieDetailのdiv要素に包括
          const movieDetail = $('<div>')
            .attr('class', 'movieDetail')
            .append(movieDetailList);
          //映画画像の要素を作成
          const Image = $('<img>')
            .attr('src', `/img/movies/${movie['picture_name']}`);
          const movieImage = $('<p>')
            .attr('class', 'movieImage')
            .append(Image);

          const scheduleList = $('<ul>')
            .attr('class', 'scheduleList');
          $.each(movie['schedules'], (key, schedule) => {
            //開始時刻と終了時刻の要素及びテキストを作成
            const startTime = $('<p>')
              .attr('class', 'startTime')
              .text(`${new Date(schedule['start_date']).getHours()}:${('0' + new Date(schedule['start_date']).getMinutes()).slice(-2)}`);
            const mark = $('<p>')
              .attr('class', 'mark')
              .text('〜');
            const finishTime = $('<p>')
              .attr('class', 'finishTime')
              .text(`${new Date(new Date(schedule['start_date']).setMinutes(new Date(schedule['start_date']).getMinutes() + movie['screening_time'])).getHours()}:${('0' + new Date(new Date(schedule['start_date']).setMinutes(new Date(schedule['start_date']).getMinutes() + movie['screening_time'])).getMinutes()).slice(-2)}`);
            //開始時刻と終了時刻をscheduleTimeのdiv要素に包括
            const scheduleTime = $('<div>')
              .attr('class', 'scheduleTime')
              .append(startTime)
              .append(mark)
              .append(finishTime);
            //scheduleTimeのdiv要素をscheduleListContentのli要素に包括
            const scheduleListContent = $('<li>')
              .attr('class', 'scheduleListContent')
              .append(scheduleTime);
            if (new Date(schedule['start_date']) > new Date()) {//現時点でまだ上映開始時刻が過ぎていない場合
              //予約購入ボタンの要素及びテキスト作成
              const button = $('<a>')
                .attr('href', `schedule/${schedule['id']}`)
                .text('予約購入');
              const reservationButton = $('<p>')
                .attr('class', 'reservationButton')
                .append(button);
              //scheduleListContentのdiv要素にボタン要素追加
              scheduleListContent
                .append(reservationButton);
            } else if (new Date(schedule['start_date']) < new Date()) {//現時点で上映開始時刻を過ぎていている場合
              //購入不可の要素及びテキスト作成
              const nonReservationButton = $('<p>')
                .attr('class', 'nonReservationButton')
                .text('購入不可');
              //scheduleListContentのdiv要素に購入不可の表示を追加
              scheduleListContent
                .append(nonReservationButton);
            }
            scheduleList
              .append(scheduleListContent);
          })
          const movieSchedule = $('<div>')
            .attr('class', 'movieSchedule')
            .append(movieImage)
            .append(scheduleList);

          const movieListContent = $('<li>')
            .attr('class', 'movieListContent')
            .append(movieDetail)
            .append(movieSchedule);
          if (checkCount === 1) {//上映スケジュールがある映画で１番目に読み込まれる映画の場合
            $('#movieList').html(movieListContent);
          } else if (checkCount > 1) {//上映スケジュールがある映画で２番目以降に読み込まれる映画の場合
            $('#movieList').append(movieListContent);
          }
        }
        if (checkCount === 0) {//選択されている日の上映スケジュールがない場合
          const noSchedule = $('<p>')
            .attr('class', 'noSchedule')
            .html('上映予定がありません');
          $('#movieList').html(noSchedule);
        }
      })
    }).fail(() => {
      const noSchedule = $('<p>')
        .attr('class', 'noSchedule')
        .html('何らかのエラーが発生しました');
      $('#movieList').html(noSchedule);
    });
  });

});
