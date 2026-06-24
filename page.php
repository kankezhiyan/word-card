<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>

<div class="post-main post-main-content post-articel">
    <?php if (have_posts()) : while (have_posts()) : the_post();
            if (get_theme_mod('wordcard_enable_page_title', true)): ?>
                <div class="post-main-title">
                    <?php the_title(); ?>
                </div>
            <?php endif; ?>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
    <?php endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>