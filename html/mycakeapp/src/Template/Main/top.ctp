<?= $this->HTML->css('slick') ?>
<?= $this->HTML->css('slick-theme') ?>
<?= $this->HTML->css('top') ?>
<?php if (!empty($slideshowPictures)) : ?>
  <div class="slideshow">
    <ul class="slick-slider">
      <?php foreach ($slideshowPictures as $slideshowPicture) : ?>
        <li class="slick-slide slick-current slick-active">
          <?= $this->HTML->image('slideshow/' . $slideshowPicture['picture_name'], ['class' => 'slideshow-pic']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<div class="movies">
  <div class="subtitle">
    <p class="back-orange before-subtitle"></p>
    <p class="subtitle-name">上映映画一覧</p>
  </div>
  <div class="movie-list">
    <?php foreach ($moviePictures as $moviePicture) : ?>
      <?= $this->HTML->image('movies_top/' . $moviePicture['top_picture_name'], ['class' => 'movie-top-pic']) ?>
    <?php endforeach; ?>
  </div>
  <?= $this->HTML->link('詳しく見る', '#', ['class' => 'button normal-button back-orange']) ?>
</div>
<div class="discounts">
  <div class="subtitle">
    <p class="back-orange before-subtitle"></p>
    <p class="subtitle-name">お得な割引</p>
  </div>
  <div class="discount-list">
    <?php foreach ($discountPictures as $discountPicture) : ?>
      <?= $this->HTML->image('discounts/' . $discountPicture['picture_name'], ['class' => 'discount-pic']) ?>
    <?php endforeach; ?>
  </div>
  <?= $this->HTML->link('詳しく見る', '#', ['class' => 'button normal-button back-orange']) ?>
</div>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('slick.min') ?>
<?= $this->HTML->script('top') ?>
