<?php
include_once "models/User.php";

?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>gfdfgggdfsg</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <div class="logo"><a href="/">На главную</a></div>
        <div class="user_section">
            <?php if(\models\User::isLoggedIn()):
            $user = \models\User::getCurrentUser();
            ?>
            <span class="text-info"><?=$user->attributes['name']?></span>
                <a href="/auth/logout">Выйти</a>
            <?php else:?>
            <a href="/auth/register">Зарегистрироваться</a>
            <a href="/auth/login">Войти</a>
            <?php endif;?>
        </div>
    </header>
    <?php include $viewFile?>
</body>

</html>