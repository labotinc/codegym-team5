<?php
echo $this->Html->css('login');
echo $this->Form->create($entity, ['novalidate' => true, 'class' => 'flex']);
?>
<div>
    <p>メールアドレス</p>
    <?php echo $this->Form->email('email', ['placeholder' => 'メールアドレス']); ?>
    <?php if (!empty($AuthCError)) : ?>
        <div class="error-message"><?php echo $AuthCError; ?></div>
        <?php echo $this->Form->error('email'); ?>
    <?php endif; ?>
</div>
<div>
    <p>パスワード</p>
    <?php echo $this->Form->password('password', ['placeholder' => 'パスワード']); ?>
    <?php if (!empty($AuthCError)) : ?>
        <div class="error-message"><?php echo $AuthCError; ?></div>
        <?php echo $this->Form->error('password'); ?>
    <?php endif; ?>
</div>
<?php
echo $this->Form->button(__('ログイン'), ['class' => 'normal-button back-orange']);
echo $this->Form->end();
?>
<div class="not-able-login">
    <?php
    echo $this->Html->link('会員登録', ['action' => 'create']);
    echo $this->Html->link('パスワードを忘れた方はコチラ', ['action' => 'password']);
    ?>
</div>
