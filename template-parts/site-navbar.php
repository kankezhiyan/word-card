<div class="header">
    <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_id' => 'navbar',
        'menu_class' => 'nav',
        'depth' => 1,
        'fallback_cb' => function () {
            wp_list_pages(array(
                'title_li' => '',
                'depth' => 1
            ));
        }
    ));
    ?>
</div>