<?php get_template_part('template-parts/site', 'main_part');
get_template_part('template-parts/site', 'main_header');
?>

<div class="post-list">
    <?php
    $search_query = get_search_query();
    $has_search_query = !empty(trim($search_query));
    if ($has_search_query) :
    ?>
        <div class="search-keyword">
            <div class="search-title">
                <h2><?php echo $search_query; ?></h2>
                <p>的搜索结果</p>
            </div>
            <div class="search-count">
                <i class="fa fa-file-o"></i>
                <p><?php echo $wp_query->found_posts; ?> 篇文章</p>
            </div>
        </div>
    <?php get_template_part('template-parts/content', 'article_list');
    else: ?>
        <div class="no-results">
            <i class="fa fa-frown-o"></i>
            <h2>什么都没搜</h2>
            <p>随便搜点什么都可以</p>
        </div>
    <?php endif; ?>
</div>

<?php get_template_part('template-parts/site', 'paginator'); ?>

<?php get_footer(); ?>