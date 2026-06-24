<div class="footer">
    <?php if (get_theme_mod('wordcard_enable_icp', false)) : ?>
        <span><a target="_blank" href="https://beian.miit.gov.cn/#/Integrated/index/"> <?php echo esc_html(get_theme_mod('wordcard_footer_icp', '')); ?></a></span>
    <?php endif;
    if (get_theme_mod('wordcard_enable_beian', false)) : ?>
        <div class="beian">
            <span><img src="<?php echo esc_url(get_template_directory_uri()) . '/wordcard/img/icp.png'; ?>" alt="beian"></span>
            <span><a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo"> <?php echo esc_html(get_theme_mod('wordcard_footer_beian', '')); ?></a></span>
        </div>
    <?php endif; ?>
    <span>&copy; <?php echo esc_html(get_theme_mod('wordcard_footer_copyright_time', date('Y'))); ?> -
        <script>
            document.write((new Date).getFullYear());
        </script>
        <?php echo esc_html(get_theme_mod('wordcard_footer_copyright_author', get_bloginfo('name'))); ?>
    </span>
    <?php if (get_theme_mod('wordcard_enable_coustomer_text_first', false)) : ?>
        <span><?php echo esc_html(get_theme_mod('wordcard_coustomer_text_first', '')); ?></span>
    <?php endif; ?>
    <?php if (get_theme_mod('wordcard_enable_coustomer_text_second', false)) : ?>
        <span><?php echo esc_html(get_theme_mod('wordcard_coustomer_text_second', '')); ?></span>
    <?php endif; ?>
    <span><a target="_blank" href="https://github.com/kankezhiyan/word-card">Word-Card</a> | <a target="_blank" href="//wordpress.org/">WordPress</a></span>
    <?php if (get_theme_mod('wordcard_enable_bg_info', false)) : ?>
        <span>background by <strong>ArseniXC</strong></span>
    <?php endif; ?>
</div>
</div>
</div>
<?php wp_footer(); ?>
</body>

</html>