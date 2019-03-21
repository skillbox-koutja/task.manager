<form action="<?= $loginUrlAction ?>"
      method="post"
      width="100%"
      border="0"
      cellspacing="0"
      cellpadding="0">
    Ваш email: <input type="text"
                      id="auth_email"
                      name="email"
                      size="30"
                      value="<?= $email ?>">
    <?php if ($emailErr): ?>
        <span class="error"> <?= $emailErr ?></span>
    <?php endif ?>
    <br><br>
    Ваш пароль: <input type="password"
                       id="auth_password"
                       name="password"
                       size="30"
                       value="<?= $password ?>">
    <?php if ($passwordErr): ?>
        <span class="error"> <?= $passwordErr ?></span>
    <?php endif ?>
    <br><br>
    <input type="submit" name="submit_auth" value="Войти">
    <?php if ($failureAuth): ?>
        <p class="error"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/failureAuth.php' ?></p>
    <?php endif ?>
</form>

