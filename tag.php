<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); 
?>
<section class="archive-list">
    <ul class="archive">
        <span class="archive-sub-type">
            <i class="fa fa-genderless"></i>
            <?php single_tag_title(); ?>
        </span>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <li>
                    <span class="archive-date"><?php echo get_the_date('y.m.d'); ?></span>
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
                        ?>
                    </div>
                </li>
        <?php endwhile;
        endif; ?>
    </ul>
</section>
<?php get_template_part('template-parts/site', 'paginator'); ?>
<?php get_footer(); ?>