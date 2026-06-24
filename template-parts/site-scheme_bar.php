<div id="theme-mask" class="theme-mask"></div>
<div id="sitting-content" class="theme-switch">
    <div class="theme-band">
        <div id="theme-user" class="theme-side">
            <?php if (is_user_logged_in()) { ?>
                <i class="fa fa-user"></i>
            <?php } else { ?>
                <i class="fa fa-user-plus"></i>
            <?php } ?>
        </div>
        <ul class="theme-box">
            <li id="theme-1" class="theme-item"><span>时</span></li>
            <li id="theme-2" class="theme-item"><span>昼</span></li>
            <li id="theme-3" class="theme-item"><span>暮</span></li>
            <li id="theme-4" class="theme-item"><span>夜</span></li>
            <li id="theme-5" class="theme-item"><span>宵</span></li>
            <li id="theme-6" class="theme-item"><span>荧</span></li>
        </ul>
        <div id="theme-search" class="theme-side">
            <i class="fa fa-search"></i>
        </div>
    </div>
    <div id="theme-user-box" class="theme-container">
        <div class="theme-bar">
            <?php if (is_user_logged_in()) { ?>
                <div class="theme-bar-avatar">
                    <?php echo get_avatar(get_current_user_id(), 48); ?>
                </div>
                <div class="theme-bar-content">
                    <a href="<?php echo get_edit_user_link(get_current_user_id()); ?>" class="theme-bar-user-name"><?php echo esc_html(wp_get_current_user()->display_name); ?></a>
                    <div class="theme-bar-user">
                        <?php if (current_user_can('manage_options')) : ?>
                            <a href="<?php echo admin_url(); ?>" target="_blank">管理</a>
                        <?php else : ?>
                            <span>管理</span>
                        <?php endif; ?>
                        |
                        <a href="<?php echo wp_logout_url(home_url()); ?>">注销</a>
                        |
                        <?php if (current_user_can('edit_posts')) : ?>
                            <a href="<?php echo admin_url('post-new.php'); ?>" target="_blank">写作</a>
                        <?php else : ?>
                            <span>写作</span>
                        <?php endif; ?>
                        |
                        <?php $post_count = count_user_posts(get_current_user_id());
                        if ($post_count > 0) : ?>
                            <a href="<?php echo get_author_posts_url(get_current_user_id()); ?>">文章</a>
                        <?php else : ?>
                            <span>文章</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } else { ?>
                <div>
                    <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="theme-no-login">登录</a>
                    |
                    <a href="<?php echo esc_url(wp_registration_url()); ?>" class="theme-no-login">注册</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="theme-search-box" class="theme-container">
        <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="theme-bar">
            <span class="theme-search-text"><i class="fa fa-search"></i></span>
            <input id="theme-search" class="theme-search-input" placeholder="搜索全站" name="s" type="search" value="<?php echo get_search_query(); ?>" />
            <button id="theme-search-btn" class="theme-search-btn" type="submit">搜索</button>
        </form>
    </div>
</div>