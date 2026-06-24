<div class="banner">
    <div class="banner-container">
        <div class="avatar-box"><a id="avatar" class="avatar"
                href=""><img src="<?php echo esc_url(get_site_icon_url()); ?>" class="avatar-style" alt="avatar"></a>
        </div>
        <div class="title-box">
            <div id="site-title" class="site-title"><?php echo esc_html(get_theme_mod('wordcard_site_title', get_bloginfo('name'))); ?></div>
            <div class="motto-box"><span id="site-motto" class="site-motto"><?php echo esc_html(get_theme_mod('wordcard_site_motto', get_bloginfo('description'))); ?></span></div>
            <?php if (get_theme_mod('wordcard_enable_sentences', true)) : ?>
            <a id="sentences" class="sentences" href="" target="_blank">
                <div class="sentences-box">
                    <span id="words" class="sentences-words"></span>
                    <span id="author" class="sentences-author"></span>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div id="scroll-down" class="scroll-down">
        <i id="scroll-trigger" class="scroll-trigger fa fa-angle-down"></i>
    </div>
</div>