<?php echo $this->Html->css('addpayment'); ?>
<?php echo $this->Form->create($entity, ['novalidate' => true, 'class' => 'flex']);
?>

<div>
    <p>クレジットカード番号</p>
    <?php
    echo $this->Form->card_number('card_number', ['placeholder' => '1111222233334444']);
    echo $this->Form->error('card_number');
    ?>
</div>
<div>
    <p>クレジットカード名義</p>
    <?php
    echo $this->Form->name('name', ['placeholder' => 'Yamada Taro']);
    echo $this->Form->error('name');
    ?>
</div>
<div class="flex div">
    <div>
        <p>有効期限</p>
        <?php
        echo $this->Form->deadline('deadline', ['placeholder' => '20001231']);
        echo $this->Form->error('deadline');
        ?>
    </div>
    <div>
        <p>セキュリティコード</p>
        <?php
        echo $this->Form->security_code('security_code', ['placeholder' => '000']);
        echo $this->Form->error('security_code');
        ?>
    </div>
</div>
<div>
    <label id="accept">
        <?php echo $this->Form->checkbox('accept', ['hiddenField' => false]); ?>
        利用規約・プライバシーポリシーに同意の上、ご確認ください。</label>
    <?php echo $this->Form->error('accept'); ?>
</div>
<?php
echo $this->Form->button('登録', ['class' => 'normal-button back-orange']);
echo $this->Form->end();
?>
