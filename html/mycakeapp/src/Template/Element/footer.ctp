<div class="nav flex">
    <div class="flex wrapper">
        <?php echo $this->Html->image("footer-logo.png", ['url' => ['controller' => 'main', 'action' => 'top'], 'class' => 'logo']); ?>
        <ul class="main-nav flex">
            <li><?php echo $this->Html->link('トップページ', ['controller' => 'main', 'action' => 'top']); ?></li>
            <li><?php echo $this->Html->link('上映スケジュール', ['controller' => 'main', 'action' => 'schedule']); ?></li>
            <li><?php echo $this->Html->link('料金・割引', ['controller' => 'main', 'action' => 'price']); ?></li>
        </ul>
    </div>
</div>
