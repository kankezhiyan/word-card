<?php
/**
 * Template Tags & Custom Styles
 * 模板标签：文章统计、相邻文章、评论回调、自定义 CSS（背景图/主题变量）
 */

function wordcard_custom_bg_image_styles()
{
    $wordcard_schemes = array('day', 'sunset', 'night', 'moonlight', 'lowlight');
    $wordcard_custom_css = '';

    // 悼念模式（:root 覆盖 --global-grayscale）
    if (get_theme_mod('wordcard_enable_mourning', false)) {
        $wordcard_custom_css .= ':root { --global-grayscale: grayscale(100%); }';
    }

    // 背景图开关：关闭时所有主题都不显示图片
    $wordcard_enable_bg = get_theme_mod('wordcard_enable_bg_image', true);
    if (!$wordcard_enable_bg) {
        $wordcard_custom_css .= '[data-theme-scheme] { --bg-image: none; }';
    }

    // 各主题变量
    foreach ($wordcard_schemes as $wordcard_scheme) {
        $wordcard_rules = array();

        if ($wordcard_enable_bg) {
            $wordcard_bg_url = get_theme_mod('wordcard_bg_image_' . $wordcard_scheme . '_url', '');
            if (empty($wordcard_bg_url)) {
                $wordcard_bg_url = get_theme_mod('wordcard_bg_image_' . $wordcard_scheme . '_media', '');
            }
            if (!empty($wordcard_bg_url)) {
                $wordcard_rules[] = sprintf('--bg-image: url(%s);', esc_url($wordcard_bg_url));
            }
        }

        $wordcard_font_color = get_theme_mod('wordcard_font_color_0_' . $wordcard_scheme, '');
        if (!empty($wordcard_font_color)) {
            $wordcard_rules[] = sprintf('--font-color-0: %s;', esc_attr($wordcard_font_color));
        }

        $wordcard_border_color = get_theme_mod('wordcard_border_color_0_' . $wordcard_scheme, '');
        if (!empty($wordcard_border_color)) {
            $wordcard_rules[] = sprintf('--border-color-0: %s;', esc_attr($wordcard_border_color));
        }

        $wordcard_bg_brightness = get_theme_mod('wordcard_bg_brightness_' . $wordcard_scheme, '');
        if (!empty($wordcard_bg_brightness)) {
            $wordcard_rules[] = sprintf('--bg-brightness: brightness(%s%%);', esc_attr($wordcard_bg_brightness));
        }

        $wordcard_global_brightness = get_theme_mod('wordcard_global_brightness_' . $wordcard_scheme, '');
        if (!empty($wordcard_global_brightness)) {
            $wordcard_rules[] = sprintf('--global-brightness: brightness(%s%%);', esc_attr($wordcard_global_brightness));
        }

        $wordcard_card_brightness = get_theme_mod('wordcard_card_brightness_' . $wordcard_scheme, '');
        if (!empty($wordcard_card_brightness)) {
            $wordcard_rules[] = sprintf('--card-brightness: brightness(%s%%);', esc_attr($wordcard_card_brightness));
        }

        $wordcard_bg_contrast = get_theme_mod('wordcard_bg_contrast_' . $wordcard_scheme, '');
        if (!empty($wordcard_bg_contrast)) {
            $wordcard_rules[] = sprintf('--bg-contrast: contrast(%s%%);', esc_attr($wordcard_bg_contrast));
        }

        $wordcard_global_contrast = get_theme_mod('wordcard_global_contrast_' . $wordcard_scheme, '');
        if (!empty($wordcard_global_contrast)) {
            $wordcard_rules[] = sprintf('--global-contrast: contrast(%s%%);', esc_attr($wordcard_global_contrast));
        }

        if (!empty($wordcard_rules)) {
            $wordcard_custom_css .= sprintf(
                '[data-theme-scheme="%s"] { %s }',
                esc_attr($wordcard_scheme),
                implode(' ', $wordcard_rules)
            );
        }
    }

    if (!empty($wordcard_custom_css)) {
        echo '<style id="wordcard-custom-bg-image">' . $wordcard_custom_css . '</style>';
    }
}
add_action('wp_head', 'wordcard_custom_bg_image_styles');

function symbols_info()
{
    $post = get_post();
    if (!$post) {
        return '';
    }

    $content = $post->post_content;
    $wpm = 300;
    $clean_content = strip_shortcodes($content);
    $clean_content = wp_strip_all_tags($clean_content);
    $word_count = mb_strlen($clean_content, 'UTF-8');
    $time = (int) ceil($word_count / $wpm);

    if ($word_count >= 10000) {
        $display_count = round($word_count / 10000, 1) . '万';
    } elseif ($word_count >= 1000) {
        $display_count = round($word_count / 1000, 1) . '千';
    } else {
        $display_count = $word_count;
    }

    return sprintf(__('约%s字 | 需%s分钟', 'wordcard'), $display_count, $time);
}

function get_adjacent_post_by_tag($current_post_id, $tag_id, $prev = true)
{
    $cache_key = 'adj_by_tag_' . $current_post_id . '_' . $tag_id . '_' . ($prev ? 'p' : 'n');
    $cached = wp_cache_get($cache_key, 'wordcard');

    if (false !== $cached) {
        if (0 === $cached) {
            return null;
        }
        return get_post($cached);
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 1,
        'post__not_in' => array($current_post_id),
        'orderby' => 'date',
        'order' => $prev ? 'DESC' : 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag_id,
            ),
        ),
        'date_query' => array(
            array(
                'compare' => $prev ? '<' : '>',
                'after' => $prev ? null : get_post($current_post_id)->post_date,
                'before' => $prev ? get_post($current_post_id)->post_date : null,
            ),
        ),
        'no_found_rows' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        wp_cache_set($cache_key, $query->posts[0]->ID, 'wordcard', 3600);
        return $query->posts[0];
    }

    wp_cache_set($cache_key, 0, 'wordcard', 3600);
    return null;
}

function wordcard_comment_callback($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item'); ?>>
        <div class="comment-body">
            <div class="comment-avatar">
                <?php echo get_avatar($comment, 48); ?>
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <span class="comment-author"><?php comment_author_link(); ?></span>
                    <span class="comment-date"><?php comment_date(); ?> <?php comment_time(); ?></span>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                <div class="comment-actions">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'reply_text' => '<i class="fa fa-reply"></i>' . esc_html__('回复', 'wordcard'),
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<span class="comment-actions-link">',
                        'after'     => '</span>',
                    )));
                    ?>
                    <?php edit_comment_link('<i class="fa fa-edit"></i>' . esc_html__('编辑', 'wordcard'), '<span class="comment-actions-link">', '</span>'); ?>
                </div>
            </div>
        </div>
    <?php
}
