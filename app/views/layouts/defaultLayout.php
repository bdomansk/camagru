<!DOCTYPE html>
<head>
    <title>DEFAULT</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
</head>
<body>
    <b>DEFAULT LAYOUT</b>
    <?=$this->viewContent?>
    <?=debug_print(\vendor\core\Database::$commandsAmount)?>
    <?=debug_print(\vendor\core\Database::$requests)?>
</body>
</html>
