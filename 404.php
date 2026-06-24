<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>
<div class="lost-page">
    <?php if (get_theme_mod('wordcard_enable_404_title', true)) : ?>
        <div class="lost-page-title"><?php echo esc_html(get_theme_mod('wordcard_404_title', __('糟糕', 'wordcard'))); ?></div>
    <?php endif;
    if (get_theme_mod('wordcard_enable_404_sub_title', true)) : ?>
        <p class="lost-page-sub-title"><?php echo esc_html(get_theme_mod('wordcard_404_sub_title', __('页面走丢了', 'wordcard'))); ?></p>
    <?php endif; ?>
    <div class="lost-page-content">
        <a href="<?php echo esc_url(home_url('/')); ?>" onclick="if(history.length>1){history.back();}return false;">
            <i class="fa fa-angle-double-left"></i>
            <span>返回</span>
        </a>
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">
            <i class="fa fa-home"></i>
            <span>主页</span>
        </a>
    </div>
</div>
<?php get_footer(); ?>