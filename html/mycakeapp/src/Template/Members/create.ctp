<?php echo $this->Html->css('create'); ?>
<?php echo $this->Form->create($entity, ['novalidate' => true, 'class' => 'flex']); ?>
<div>
    <p>メールアドレス</p>
    <?php
    echo $this->Form->email('email', ['placeholder' => 'メールアドレス']);
    echo $this->Form->error('email');
    ?>
</div>
<div>
    <p>パスワード</p>
    <?php
    echo $this->Form->password('password', ['placeholder' => 'パスワード']);
    echo $this->Form->error('password');
    ?>
</div>
<div>
    <p>パスワード(確認用)</p>
    <?php
    echo $this->Form->password('rePassword', ['placeholder' => 'パスワード(確認用)']);
    echo $this->Form->error('rePassword');
    ?>
</div>
<?php
echo $this->Form->button('会員登録', ['class' => 'normal-button back-orange']);
echo $this->Form->end();
?>
