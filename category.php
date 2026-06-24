<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header');
$current_cat = get_queried_object();
$child_categories = get_categories(array(
    'parent' => $current_cat->term_id,
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
));
if (!empty($child_categories)) : ?>
    <div class="cat-box">
        <div class="cat-title">子类：</div>
        <div>
            <div class="cat-list">
                <?php foreach ($child_categories as $cat) { ?>
                    <div class="cat-item">
                        <?php echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '(' . esc_html($cat->count) . ')</a>'; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<section class="archive-list">
    <ul class="archive">
        <span class="archive-sub-type">
            <i class="fa fa-genderless"></i>
            <?php single_cat_title(); ?>
        </span>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
        endif; ?>
    </ul>
</section>
<?php get_template_part('template-parts/site', 'paginator'); ?>
<?php get_footer(); ?>