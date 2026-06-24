<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="post">
            <a class="post-title" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
            <div class="post-info">
                <i class="fa fa-bookmark-o"></i>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    $parent_cats = array();
                    $child_cats = array();
                    foreach ($categories as $cat) {
                        if ($cat->parent == 0) {
                            $parent_cats[] = $cat;
                        } else {
                            $child_cats[] = $cat;
                        }
                    }
                    $sorted_cats = array_merge($parent_cats, $child_cats);
                    $cat_links = array();
                    foreach ($sorted_cats as $cat) {
                        $cat_links[] = '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                    }
                    echo implode(', ', $cat_links);
                }
                ?>
            </div>
            <div class="post-info">
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="post-author">
                    by：<?php the_author(); ?>
                </a>
            </div>
            <?php if (get_theme_mod('wordcard_enable_words_count', true)): ?>
                <div class="post-info"><?php echo symbols_info(); ?></div>
            <?php endif; ?>
            <div class="post-except">
                <?php
                if (has_excerpt()) {
                    the_excerpt();
                } else {
                    $raw_content = get_the_content('');
                    $clean_content = strip_shortcodes($raw_content);
                    $clean_content = wp_strip_all_tags($clean_content);
                    $excerpt = mb_strimwidth($clean_content, 0, 240, '', 'UTF-8');
                    echo esc_html($excerpt);
                }
                ?>
                <a class="read-more" href="<?php the_permalink(); ?>"> ... </a>
            </div>
            <div class="post-date"><?php echo get_the_date('Y.m.d'); ?></div>
        </div>
    <?php endwhile;
else : ?>
    <div class="no-results">
        <i class="fa fa-folder-o"></i>
        <?php if (is_search()) : ?>
        <h2>没有相关内容</h2>
        <p>试试换个关键词</p>
        <?php else : ?>
        <h2>还没有文章</h2>
        <p>耐心等一段时间再来看吧</p>
        <?php endif; ?>
    </div>
<?php endif; ?>