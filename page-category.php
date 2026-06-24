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
    <div class="cat-title">类目：</div>
    <div>
        <div class="cat-list">
            <?php
            $parent_categories = get_categories(array(
                'parent' => 0,
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            ));
            foreach ($parent_categories as $cat) { ?>
                <div class="cat-item">
                    <?php echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '(' . esc_html($cat->count) . ')</a>'; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
foreach ($parent_categories as $parent_cat) {
    $query = new WP_Query(array(
        'cat' => $parent_cat->term_id,
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
            <a href="<?php echo esc_url(get_category_link($parent_cat->term_id)); ?>"><?php echo esc_html($parent_cat->name); ?></a>
        </span>
        <?php $index = 0; while ($query->have_posts()) : $query->the_post();
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
                            $child_cat = null;
                            foreach ($categories as $cat) {
                                if ($cat->parent != 0) {
                                    $child_cat = $cat;
                                    break;
                                }
                            }
                            if ($child_cat) {
                                echo '<a class="archive-info" href="' . esc_url(get_category_link($child_cat->term_id)) . '">' . esc_html($child_cat->name) . '</a>';
                            }
                        }
                        ?>
                        <a class="archive-info" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">by：<?php the_author(); ?></a>
                        <?php $tags = get_the_tags();
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
            <a class="archive-more" href="<?php echo esc_url(get_category_link($parent_cat->term_id)); ?>">查看更多<i class="fa fa-angle-double-right"></i></a>
        <?php endif; ?>
    </ul>
</section>
<?php } ?>


<?php get_template_part('template-parts/site', 'paginator'); ?>
<?php get_footer(); ?>