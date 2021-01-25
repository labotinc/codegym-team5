<?php echo $this->Html->css('password'); ?>
<?php echo $this->Form->create($entity, ['novalidate' => true, 'class' => 'flex']); ?>
<div>
    <p>メールアドレス</p>
    <?php
    echo $this->Form->email('email', ['placeholder' => 'メールアドレス']);
    echo $this->Form->error('email');
    ?>
</div>
<div>
    <p>新しいパスワード</p>
    <?php
    echo $this->Form->password('password', ['placeholder' => '新しいパスワード']);
    echo $this->Form->error('password');
    ?>
</div>
<div>
    <p>新しいパスワード(確認用)</p>
    <?php
    echo $this->Form->password('rePassword', ['placeholder' => '新しいパスワード(確認用)']);
    echo $this->Form->error('rePassword');
    ?>
</div>
<?php
echo $this->Form->button('再登録', ['class' => 'normal-button back-orange']);
echo $this->Form->end();
?>
