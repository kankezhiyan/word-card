<div class="left-returnbar" id="left-returnbar">
    <?php if (is_single() || is_archive() || is_search()) : ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" onclick="if(history.length>1){history.back();}return false;">
        <i class="fa fa-angle-double-left"></i>
        <span class="side-text">返回</span>
    </a>
    <?php
    $posts_page_id = get_option('page_for_posts');
    $posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
    ?>
    <a href="<?php echo esc_url($posts_page_url); ?>">
        <i class="fa fa-home"></i>
        <span class="side-text">主页</span>
    </a>
    <?php endif; ?>
    <div class="side-bar" id="side-bar">
        <a href="#top" id="back-to-top">
            <i class="fa fa-arrow-up"></i>
            <span class="side-text">回顶</span>
        </a>
        <a id="share-page">
            <i class="fa fa-share"></i>
            <span class="side-text">分享</span>
        </a>
    </div>
</div>
