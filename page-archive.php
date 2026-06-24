<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>

<?php
// 归档模板分页设置
$archive_pagination = get_theme_mod('wordcard_archive_page_pagination', 1);
$archive_per_page = $archive_pagination ? get_theme_mod('wordcard_archive_page_per_page', 50) : -1;

// 统计所有年份的文章数量
$count_args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);
$count_query = new WP_Query($count_args);
$year_counts = array();
if ($count_query->have_posts()) {
    foreach ($count_query->posts as $p) {
        $year = get_post_time('Y', false, $p, false);
        if (!isset($year_counts[$year])) {
            $year_counts[$year] = 0;
        }
        $year_counts[$year]++;
    }
}
krsort($year_counts);
wp_reset_postdata();

// 获取当前页文章，按日期降序排列
$paged = max(1, get_query_var('paged'), get_query_var('page'));
$args = array(
    'post_type' => 'post',
    'posts_per_page' => $archive_per_page,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged
);
$all_posts = new WP_Query($args);

$lastYear = null;
$lastMonth = null; ?>

<div class="cat-box">
    <div class="cat-title">年份：</div>
    <div>
        <div class="cat-list">
            <?php foreach ($year_counts as $year => $count) { ?>
                <div class="cat-item">
                    <?php echo '<a href="' . esc_url(get_year_link($year)) . '">' . esc_html($year) . '(' . esc_html($count) . ')</a>'; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<section class="archive-list">
    <?php if ($all_posts->have_posts()) :
        while ($all_posts->have_posts()) : $all_posts->the_post();
            // 获取当前文章的日期信息
            $currentYear = get_the_date('Y');
            $currentMonth = get_the_date('m');

            // 年份变化时，结束之前的月份section，开始新的年份section
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

            // 月份变化时，结束之前的ul，开始新的月份section
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
        wp_reset_postdata();
    endif;
        ?>
</section>

<?php
if ($archive_pagination) {
    global $wp_query;
    $wp_query = $all_posts;
    get_template_part('template-parts/site', 'paginator');
    wp_reset_query();
}
?>

<?php get_footer(); ?>