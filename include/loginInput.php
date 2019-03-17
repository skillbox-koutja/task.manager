<?php if (isset($_COOKIE['email'])): ?>
    <input type="hidden"
           id="auth_email"
           name="email"
           value="<?= $_COOKIE['email']; ?>">
<?php else: ?>
    Ваш email: <input type="text"
                      id="auth_email"
                      name="email"
                      size="30"
                      value="<?= $email; ?>">
    <?php if ($emailErr): ?>
        <span class="error"> <?= $emailErr; ?></span>
    <?php endif; ?>
    <br><br>
<?php endif; ?>
