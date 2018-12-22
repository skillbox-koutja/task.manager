<?php
$login = $password = '';
$successAuth = $failureAuth = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginErr = $passwordErr = '';
    if (empty($_POST['login'])) {
        $loginErr = 'Необходим логин';
    } else {
        $login = test_input($_POST['login']);
    }
    if (empty($_POST['password'])) {
        $passwordErr = 'Необходим пароль';
    } else {
        $password = test_input($_POST['password']);
    }

    if (!$loginErr && !$passwordErr) {
        if (checkAuth($login, $password)) {
            $successAuth = require_once $_SERVER['DOCUMENT_ROOT'] . '/include/successAuth.php';
            $login = $password = '';
        } else {
            $failureAuth = require_once $_SERVER['DOCUMENT_ROOT'] . '/include/failureAuth.php';
        }
    }
}

function checkAuth($login, $password)
{
    $loginStore = require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/loginStore.php';
    if (in_array($login, $loginStore)) {
        $passwordStore = require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/passwordStore.php';
        if (isset($passwordStore[$login]) && $password === $passwordStore[$login]) {
            return true;
        }
    }
    return false;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="styles.css" rel="stylesheet"/>
    <title>Project - ведение списков</title>
</head>

<body>
<div class="header">
    <div class="logo"><img src="i/logo.png" width="68" height="23" alt="Project"/></div>
    <div style="clear: both"></div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-column-index">

            <h1>Возможности проекта —</h1>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с
                друзьями и просматривать списки друзей.</p>

            <a href="/?login=true">Перейти к авторизации</a>
        </td>
        <?php if (filter_var($_GET['login'], FILTER_VALIDATE_BOOLEAN)): ?>
            <td class="right-column-index">
                <div class="project-folders-menu">
                    <ul class="project-folders-v">
                        <li class="project-folders-v-active"><span>Авторизация</span></li>
                        <li><a href="#">Регистрация</a></li>
                        <li><a href="#">Забыли пароль?</a></li>
                    </ul>
                    <div style="clear: both;"></div>
                </div>
                <div class="index-auth">
                    <form action="/?login=true"
                          method="post"
                          width="100%"
                          border="0"
                          cellspacing="0"
                          cellpadding="0">
                        Ваш логин: <input type="text"
                                           id="auth_login"
                                           name="login"
                                           size="30"
                                           value="<?= $login; ?>">
                        <?php if ($loginErr): ?>
                            <span class="error"> <?= $loginErr ?></span>
                        <?php endif; ?>
                        <br><br>
                        Ваш пароль: <input type="password"
                                           id="auth_password"
                                           name="password"
                                           size="30"
                                           value="<?= $password; ?>">
                        <?php if ($passwordErr): ?>
                            <span class="error"> <?= $passwordErr ?></span>
                        <?php endif; ?>
                        <br><br>
                        <input type="submit" name="submit" value="Войти">
                        <?php if ($successAuth): ?>
                            <p class="success"><?= $successAuth ?></p>
                        <?php endif; ?>
                        <?php if ($failureAuth): ?>
                            <p class="error"><?= $failureAuth ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </td>
        <?php endif; ?>
    </tr>
</table>

<div class="footer">&copy;&nbsp;<nobr>2018</nobr>
    Project.
</div>

</body>
</html>