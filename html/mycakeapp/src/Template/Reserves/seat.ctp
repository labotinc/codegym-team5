<?= $this->HTML->css('seat') ?>
<script>
    let Reserved = JSON.parse('<?= json_encode($Reserved); ?>'); //JSの変数定義にPHP直接出力
</script>
<div class="seat_heading">
    <h1><?= $seatDetails['movie']['name']; ?></h1>
    <h2><?= $startdate ?>〜<span><?= $finishdate ?></span></h2>
</div><!-- /.seat_heading -->
<?= $this->Form->create(); ?>
<div class="seat_select">
    <?= $this->element('Theater/' . $seatDetails['theater']['file_name']); ?>
</div><!-- /.seat_select -->
<?= $this->Form->button('次へ', [
    'type' => 'submit',
    'class' => 'normal-button back-orange',
    'disabled' => 'true',
]); ?>
<?= $this->Form->end(); ?>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('seat') ?>
