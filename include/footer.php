<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menuBuilder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sorter/sorter.php';

?>
<footer>
    <div style="clear: both"></div>

    <?= createHtmlMenu($mainMenu, 'footer-menu', SORT_DESC) ?>
    &copy;&nbsp;<nobr>2018</nobr>
    Project.
    <div class="logo">
        <img src="/i/logo.png" width="68" height="23" alt="Project"/>
    </div>
</footer>
</body>
</html>