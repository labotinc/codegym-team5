<!-- 白い枠アリ,タイトルなし -->
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <!-- Viewファイルの先頭に「$this->assign('title', '好きなタイトル');」でタイトル変更可 -->
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->css('reset') ?>
    <?= $this->Html->css('movie') ?>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <div id="fixed">
        <header class="flex">
            <?= $this->element('header') ?>
        </header>
        <main>
            <div class="frame-no-title">
                <div class="content flex">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </main>
        <footer class="flex">
            <?= $this->element('footer') ?>
        </footer>
    </div>
</body>

</html>
