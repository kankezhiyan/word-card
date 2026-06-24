<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); 
?>
<section class="archive-list">
    <ul class="archive">
        <span class="archive-sub-type">
            <i class="fa fa-genderless"></i>
            <?php the_author(); ?>
        </span>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <li>
                    <span class="archive-date"><?php echo get_the_date('y.m.d'); ?></span>
                    <div class="archive-main">
                        <a class="archive-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
        endif; ?>
    </ul>
</section>
<?php get_template_part('template-parts/site', 'paginator'); ?>
<?php get_footer(); ?>