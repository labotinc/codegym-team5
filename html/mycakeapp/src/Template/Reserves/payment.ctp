<?php echo $this->Html->css('payment'); ?>
<?php echo $this->Form->create($reserve, ['novalidate' => true]); ?>
<p>ご登録のクレジットカード</p>
<div class="credit-card flex">
    <?php for ($i = 0; $i < count($cardsInfoOwn); $i++) : ?>
        <label>
            <div class="cardInfo flex">
                <input type="radio" name="registered_order" value="<?= $i ?>" <?php echo ($isFirstRadio = ($i === 0) ? "checked" : null); ?>>
                <div>
                    <p><?php echo h($cardsInfoOwn[$i]['name']); ?></p>
                    <p>****-****-****-<?= $cardsInfoOwn[$i]['card_number']; ?> - 有効期限 <?= date('m/y',  strtotime($cardsInfoOwn[$i]['deadline'])); ?></p>
                </div>
            </div>
        </label>
    <?php endfor; ?>
</div>
<div class="point">
    <p>ご利用ポイント</p>
    <div>
        <?php
        echo $this->Form->select('usage_of_points', [
            'no_use_point' => '利用しない',
            'use_all_points' => '全て利用する',
            'use_some_points' => '一部利用する'
        ]);
        echo $this->Form->use_point('use_point', ['placeholder' => '利用可能ポイント:' . $totalOfOwnPoints, 'data-useallpoints' => $totalOfOwnPoints]);
        if (!empty($TooManyPointsError)) : ?>
            <p class="error-message"><?= $TooManyPointsError ?></p>
        <?php
        endif;
        echo $this->Form->error('use_point');
        ?>
    </div>
</div>
<div class="flex division-button">
    <?php
    echo $this->Html->link('戻る', ['action' => 'checkdetail'], ['class' => 'button normal-button back-gray']);
    echo $this->Form->button('決定', ['class' => 'normal-button back-orange']);
    ?>
</div>
<?php echo $this->Form->end(); ?>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('payment') ?>
