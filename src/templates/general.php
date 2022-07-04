<!DOCTYPE html>
<html lang="<?=$this->lang ?? 'ru'?>">
<head>
    <meta charset="UTF-8">
    <title><?=$this->title ?? 'No title page'?></title>
    <link rel="stylesheet" type="text/css" href="/styles/general.css">
    <link rel="stylesheet" type="text/css" href="/styles/DialogWindow.css">
    <script src="/scripts/jquery-3.3.1.min.js"></script>
    <script src="/scripts/DialogWindow.js"></script>
</head>
<body>
<div class="application">
    <?=$body ?? 'Set correct body template'?>
</div>
<div class="console">
    <?php foreach (\views\Console::getAll() as $message) : ?>
    <p><?=$message?></p>
    <?php endforeach; ?>
</div>
</body>
</html>