<?= $this->HTML->css('price') ?>
<div class="fees">
    <h3>基本料金</h3>
    <?php foreach ($fees as $fee) : ?>
        <div class="flex">
            <p><?= h($fee->name) ?></p>
            <p><?= $this->Number->format($fee->fee) . '円' ?></p>
        </div>
    <?php endforeach; ?>
</div>
<div class="discounts">
    <h3>お得な割引サービス</h3>
    <?php foreach ($maxDiscountsResult as $discount) : ?>
        <div class="test">
            <p class="discount-name"><?= h($discount['name']) ?></p>
            <div class="flex">
                <p><?= h($discount['detail']) ?></p>
                <p><?= $this->Number->format($discount['displayed_amount']) . '円' ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <?php foreach ($discountsResult as $discount) : ?>
        <div class="test">
            <p class="discount-name"><?= h($discount['name']) ?></p>
            <div class="flex">
                <p><?= h($discount['detail']) ?></p>
                <p><?= '基本料金-' . $this->Number->format($discount['displayed_amount']) . '円' ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
