<div class="nav flex">
    <div class="flex">
        <?php echo $this->Html->image("header-logo.png", ['url' => ['controller' => 'main', 'action' => 'top'],'class' => 'logo']); ?>
        <ul class="main-nav flex">
            <li><?php echo $this->Html->link('トップページ', ['controller' => 'main', 'action' => 'top']); ?></li>
            <li><?php echo $this->Html->link('上映スケジュール', ['controller' => 'main', 'action' => 'schedule']); ?></li>
            <li><?php echo $this->Html->link('料金・割引', ['controller' => 'main', 'action' => 'price']); ?></li>
        </ul>
    </div>
    <ul class="user-nav flex">
        <?php if (empty($member)) : ?>
            <li><?php echo $this->Html->link('会員登録', ['controller' => 'members' , 'action' => 'create']); ?></li>
            <li><?php echo $this->Html->link('ログイン', ['controller' => 'members' , 'action' => 'login']); ?></li>
            <?php else : ?>
                <li><?php echo $this->Html->link('マイページ', ['controller' => 'mypage' , 'action' => 'top']); ?></li>
                <li><?php echo $this->Html->link('ログアウト', ['controller' => 'members' , 'action' => 'logout']); ?></li>
        <?php endif; ?>
    </ul>
</div>
