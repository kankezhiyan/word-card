<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>
<?php get_template_part('template-parts/site', 'secondary_navbar'); ?>

<?php
$show_count = absint(get_theme_mod('wordcard_category_show_count', 5));
if ($show_count < 1) {
    $show_count = 1;
}
?>

<div class="cat-box">
    <div class="cat-title">作者：</div>
    <div>
        <div class="cat-list">
            <?php
            $authors = get_users(array(
                'has_published_posts' => true,
                'orderby' => 'display_name',
                'order' => 'ASC',
            ));
            foreach ($authors as $author) {
                $post_count = count_user_posts($author->ID); ?>
                <div class="cat-item">
                    <?php echo '<a href="' . esc_url(get_author_posts_url($author->ID)) . '">' . esc_html($author->display_name) . '(' . esc_html($post_count) . ')</a>'; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
foreach ($authors as $author) {
    $query = new WP_Query(array(
        'author' => $author->ID,
        'posts_per_page' => $show_count + 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ));
    if (!$query->have_posts()) {
        continue;
    }
    $has_more = $query->post_count > $show_count;
?>
    <section class="archive-list">
        <ul class="archive">
            <span class="archive-sub-type">
                <i class="fa fa-genderless"></i>
                <a href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>"><?php echo esc_html($author->display_name); ?></a>
            </span>
            <?php $index = 0;
            while ($query->have_posts()) : $query->the_post();
                if ($index >= $show_count) {
                    break;
                }
                $index++;
            ?>
                <li>
                    <span class="archive-date"><?php echo get_the_date('y.m.d'); ?></span>
                    <div class="archive-main">
                        <a class="archive-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            $parent_cat = null;
                            foreach ($categories as $cat) {
                                if ($cat->parent == 0) {
                                    $parent_cat = $cat;
                                    break;
                                }
                            }
                            if (!$parent_cat) {
                                $parent_cat = $categories[0];
                            }
                            echo '<a class="archive-info" href="' . esc_url(get_category_link($parent_cat->term_id)) . '">' . esc_html($parent_cat->name) . '</a>';
                        }
                        $tags = get_the_tags();
                        if ($tags) {
                            $first_tag = reset($tags);
                            echo '<a class="archive-info" href="' . esc_url(get_tag_link($first_tag->term_id)) . '">〔' . esc_html($first_tag->name) . '〕</a>';
                        }
                        ?>
                    </div>
                </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
            <?php if ($has_more) : ?>
                <a class="archive-more" href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>">查看更多<i class="fa fa-angle-double-right"></i></a>
            <?php endif; ?>
        </ul>
    </section>
<?php } ?>


<?php get_template_part('template-parts/site', 'paginator'); ?>
<?php get_footer(); ?>