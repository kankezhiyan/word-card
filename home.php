<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header'); ?>
<div class="post-list">
    <?php get_template_part('template-parts/content', 'article_list'); ?>
</div>
<?php get_template_part('template-parts/site', 'paginator');
get_footer(); ?>