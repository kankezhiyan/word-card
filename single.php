<?php
get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'post_header');
?>
<div class="post-main post-main-content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="post-content post-articel">
                <?php the_content(); ?>
            </div>
            <?php if (get_theme_mod('wordcard_enable_bottom_info', true)): ?>
                <div class="post-btn">
                    <?php if (get_theme_mod('wordcard_enable_author_page', true)): ?>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="fast-btn"><i class="fa fa-eye"></i><?php echo esc_html(get_theme_mod('wordcard_author_page_text', '作者其他文章')); ?></a>
                    <?php endif;
                    if (get_theme_mod('wordcard_enable_tag_page', true)): ?>
                        <div class="full-series">
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                $first_tag = reset($tags);
                                $tag_id = $first_tag->term_id;
                                $current_post_id = get_the_ID();

                                $prev_post = get_adjacent_post_by_tag($current_post_id, $tag_id, true);
                                if ($prev_post) {
                                    echo '<a href="' . esc_url(get_permalink($prev_post)) . '" class="fast-btn"><i class="fa fa-chevron-left"></i>'.esc_html(get_theme_mod('wordcard_tag_page_last_text', '上一篇')).'</a>';
                                }

                                echo '<a href="' . esc_url(get_tag_link($tag_id)) . '" class="fast-btn">'.esc_html(get_theme_mod('wordcard_tag_page_text', '同标签文章')).'</a>';

                                $next_post = get_adjacent_post_by_tag($current_post_id, $tag_id, false);
                                if ($next_post) {
                                    echo '<a href="' . esc_url(get_permalink($next_post)) . '" class="fast-btn">'.esc_html(get_theme_mod('wordcard_tag_page_next_text', '下一篇')).'<i class="fa fa-chevron-right"></i></a>';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
    <?php endif;
        endwhile;
    endif; ?>
</div>
<?php if (get_theme_mod('wordcard_enable_comments', true)):
    comments_template();
endif;
get_footer(); ?>