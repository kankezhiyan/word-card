<div class="paper">
    <div id="paper-main" class="paper-main">
        <div class="post-header post-header-sticky">
            <div class="post-main post-header-info">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="post-main-title">
                            <?php the_title(); ?>
                        </div>
                        <div class="post-meta">
                            by：<?php the_author(); ?>
                        </div>
                        <?php if (get_theme_mod('wordcard_enable_words_count', true)): ?>
                            <div class="post-meta">
                                <?php echo symbols_info(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="post-meta">
                            <?php echo get_the_date('Y.m.d'); ?>
                        </div>
                <?php endwhile;
                endif; ?>
            </div>
        </div>