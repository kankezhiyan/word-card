<?php get_template_part('template-parts/site', 'main_part');
if (get_theme_mod('wordcard_enable_banner', true)) {
    get_template_part('template-parts/site', 'banner');
}
get_template_part('template-parts/site', 'main_header'); ?>
<div class="post-main post-main-content">
    <?php if (get_theme_mod('wordcard_enable_frontpage_post', true)):
        if (have_posts()) : while (have_posts()) : the_post();
                if (get_theme_mod('wordcard_enable_frontpage_title', true)): ?>
                    <div class="post-main-title">
                        <?php the_title(); ?>
                    </div>
                <?php endif; ?>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
    <?php endwhile;
        endif;
    endif; ?>
    <div class="frontpage-post">
        <?php if (get_theme_mod('wordcard_enable_frontpage_card', true)):
            $card_count = max(1, min(10, absint(get_theme_mod('wordcard_frontpage_card_count', 1))));
            for ($i = 1; $i <= $card_count; $i++) {
                $card_image_url = get_theme_mod('wordcard_frontpage_card_' . $i . '_image_url', '');
                $card_image = !empty($card_image_url) ? $card_image_url : get_theme_mod('wordcard_frontpage_card_' . $i . '_image', '');
                $card_title = get_theme_mod('wordcard_frontpage_card_' . $i . '_title', sprintf(__('卡片 %d 标题', 'wordcard'), $i));
                $card_content = get_theme_mod('wordcard_frontpage_card_' . $i . '_content', sprintf(__('这里是卡片 %d 的描述内容，可在主题定制中进行修改。', 'wordcard'), $i));
                $card_link_text = get_theme_mod('wordcard_frontpage_card_' . $i . '_link_text', __('了解更多', 'wordcard'));
                $card_link_enabled = get_theme_mod('wordcard_frontpage_card_' . $i . '_link_enabled', true);
                $card_link_url = get_theme_mod('wordcard_frontpage_card_' . $i . '_link_url', '');
                if (empty($card_link_url)) {
                    $about_page = get_page_by_path('about');
                    if ($about_page) {
                        $card_link_url = get_permalink($about_page);
                    }
                }
        ?>
                <div class="front-post-container">
                    <?php if (!empty($card_image)): ?>
                        <div class="post-left">
                            <img src="<?php echo esc_url($card_image); ?>" alt="<?php echo esc_attr($card_title); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="post-right">
                        <h2 class="post-right-title"><?php echo esc_html($card_title); ?></h2>
                        <div class="post-right-content"><?php echo esc_html($card_content); ?></div>
                        <?php if ($card_link_enabled && !empty($card_link_url)): ?>
                            <div class="post-right-more"><a href="<?php echo esc_url($card_link_url); ?>"><?php echo esc_html($card_link_text); ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php
            }
        endif; ?>
    </div>
</div>
<?php get_footer(); ?>