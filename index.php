<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menuBuilder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sorter/sorter.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/constants/session.php';

session_name('session_id');
session_start();
setcookie(session_name(), session_id(), time() + LIFETIME_SESSION);

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/auth.php';

$login = $login ?? null;
$loginErr = $loginErr ?? null;
$password = $password ?? null;
$passwordErr = $passwordErr ?? null;

require_once $_SERVER['DOCUMENT_ROOT'] . '/route/index.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$mainMenu = require_once $_SERVER['DOCUMENT_ROOT'] . '/include/main_menu.php';

$activeSectionIndex = findActiveSectionIndex($mainMenu, $urlPath);
$mainMenu = setActiveSection($mainMenu, $activeSectionIndex);

$loginUrlAction = $urlPath . '?login=true';
$logoutUrlAction = $urlPath . '?logout=true';
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-column-index">
                <h1><?= getActiveSectionTitle($mainMenu, $activeSectionIndex) ?></h1>
                <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками
                    с
                    друзьями и просматривать списки друзей.</p>
                <?php if (isset($_SESSION['lastAccess'])): ?>
                    <a href="<?= $logoutUrlAction ?>">Выйти</a>
                <?php else: ?>
                    <a href="<?= $loginUrlAction ?>">Перейти к авторизации</a>
                <?php endif; ?>
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
                        <form action="<?= $loginUrlAction ?>"
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
                            <input type="submit" name="submit_auth" value="Войти">
                            <?php if ($successAuth): ?>
                                <p class="success"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/successAuth.php'; ?></p>
                                <a href="<?= $urlPath ?>">Перейти к главной странице</a>
                            <?php endif; ?>
                            <?php if ($failureAuth): ?>
                                <p class="error"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/failureAuth.php'; ?></p>
                            <?php endif; ?>
                        </form>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    </table>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php'; ?>