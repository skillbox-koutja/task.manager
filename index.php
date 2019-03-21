<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$email = $email ?? null;
$emailErr = $emailErr ?? null;
$password = $password ?? null;
$passwordErr = $passwordErr ?? null;

require_once $_SERVER['DOCUMENT_ROOT'] . '/route/index.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$mainMenu = require_once $_SERVER['DOCUMENT_ROOT'] . '/include/main_menu.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menuBuilder.php';

$activeSectionIndex = findActiveSectionIndex($mainMenu, $urlPath);
$mainMenu = setActiveSection($mainMenu, $activeSectionIndex);

$loginUrlAction = $urlPath . '?login=true';
$logoutUrlAction = $urlPath . '?logout=true';
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-column-index">
                <h1><?= getActiveSectionTitle($mainMenu, $activeSectionIndex) ?></h1>
                <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками
                    с
                    друзьями и просматривать списки друзей.</p>
                <?php if ($successAuth): ?>
                    <a href="/post/">Почта</a>
                <br>
                    <a href="<?= $logoutUrlAction ?>">Выйти</a>
                <?php else: ?>
                    <a href="<?= $loginUrlAction ?>">Перейти к авторизации</a>
                <?php endif ?>
            </td>
            <?php if (filter_var($_GET['login'] ?? false, FILTER_VALIDATE_BOOLEAN)): ?>
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
                        <?php if ($successAuth): ?>
                            <p class="success"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/successAuth.php' ?></p>
                            <a href="<?= $urlPath ?>">Перейти к главной странице</a>
                        <?php else: ?>
                            <?php include $_SERVER['DOCUMENT_ROOT'] . '/include/login/loginForm.php' ?>
                        <?php endif ?>
                    </div>
                </td>
            <?php endif ?>
        </tr>
    </table>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php' ?>