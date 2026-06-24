<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>

<section class="archive-list">
    <?php
    $lastYear = null;
    $lastMonth = null;

    if (have_posts()) :
        while (have_posts()) : the_post();
            $currentYear = get_the_date('Y');
            $currentMonth = get_the_date('m');

            if ($currentYear != $lastYear) {
                if ($lastYear != null) {
                    $lastMonth = null;
                    echo '</section>';
                    echo '<section class="archive-list">';
                }
    ?>
                <h3 class="archive-year">
                    <a class="archive-sub" href="<?php echo get_year_link($currentYear); ?>"><?php echo $currentYear; ?></a>
                </h3>
            <?php
                $lastYear = $currentYear;
            }

            if ($currentMonth != $lastMonth) {
                if ($lastMonth != null) {
                    echo '</ul>';
                }
            ?>
                <h4 class="archive-month">
                    <a class="archive-sub" href="<?php echo get_month_link($currentYear, $currentMonth); ?>"><?php echo intval($currentMonth); ?>月</a>
                </h4>
                <ul class="archive timeline">
                <?php
                $lastMonth = $currentMonth;
            }
                ?>

                <li>
                    <span class="archive-date"><?php the_time('y.m.d'); ?></span>
                    <div class="archive-main">
                        <a class="archive-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <a class="archive-info" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">by：<?php the_author(); ?></a>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            $parent_category = null;
                            foreach ($categories as $cat) {
                                if ($cat->parent == 0) {
                                    $parent_category = $cat;
                                    break;
                                }
                            }
                            if (!$parent_category) {
                                $parent_category = $categories[0];
                            }
                            echo '<a class="archive-info" href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . esc_html($parent_category->name) . '</a>';
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
    endif;
        ?>
</section>

<?php get_template_part('template-parts/site', 'paginator'); ?>

<?php get_footer(); ?>