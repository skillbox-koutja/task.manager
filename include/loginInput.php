<?php if (isset($_COOKIE['login'])): ?>
    <input type="hidden"
           id="auth_login"
           name="login"
           value="<?= $_COOKIE['login']; ?>">
<?php else: ?>
    Ваш логин: <input type="text"
                      id="auth_login"
                      name="login"
                      size="30"
                      value="<?= $login; ?>">
    <?php if ($loginErr): ?>
        <span class="error"> <?= $loginErr ?></span>
    <?php endif; ?>
    <br><br>
<?php endif; ?>
