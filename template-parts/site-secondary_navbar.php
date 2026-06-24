<div class="secondary-navbar" id="secondary-navbar">
    <div class="nav-title">筛选：</div>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'secondary',
        'container_id' => 'sec-navbar',
        'menu_class' => 'nav-list',
        'depth' => 1,
        'fallback_cb' => false,
    ));
    ?>
</div>