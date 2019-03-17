<footer>
    <div style="clear: both"></div>
    <?php if (isset($mainMenu)): ?>
        <?php renderMenu($mainMenu, 'footer-menu', SORT_DESC); ?>
    <?php endif; ?>
    &copy;&nbsp;<nobr>2018</nobr>
    Project.
    <div class="logo">
        <img src="/i/logo.png" width="68" height="23" alt="Project"/>
    </div>
</footer>
</body>
</html>