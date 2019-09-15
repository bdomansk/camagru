<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>DEFAULT</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
    <link rel="stylesheet" type="text/css" href="/public/css/registration.css">
</head>
<body>
    <ul>
    <li><a href="/">Home</a></li>
    <li><a href="/user/registration">Registration</a></li>
    <li><a href="/user/login">Login</a></li>
    <li><a href="/user/logout">Logout</a></li>
    </ul>

    <?php if (isset($_SESSION['errorList'])): ?>
        <div class="registration-error">
            <?=$_SESSION['errorList']; unset($_SESSION['errorList'])?>
        </div>
    <?php endif;?>
    <?=$this->viewContent?>
    <?php /*
    <?=debug_print(\vendor\core\Database::$commandsAmount)?>
    <?=debug_print(\vendor\core\Database::$requests)?>
    */?>
</body>
</html>
