<?php
global $wp_query;

$comments_pagination = get_theme_mod('wordcard_comments_pagination', 1);
if (!$comments_pagination) {
    return;
}

$comments_per_page = (int) get_theme_mod('wordcard_comments_per_page', 20);
$total             = (int) ceil(get_comments_number() / $comments_per_page);
$current           = get_query_var('cpage') ? intval(get_query_var('cpage')) : 1;

if ($total <= 1) {
    return;
}
?>
<nav class="comment-navigation">
    <?php if ($current > 1) : ?>
        <a href="<?php echo esc_url(add_query_arg('cpage', $current - 1) . '#comments'); ?>" class="page-number prev">
            <i class="fa fa-chevron-left"></i>
        </a>
    <?php else : ?>
        <span class="page-number prev disabled"><i class="fa fa-chevron-left"></i></span>
    <?php endif; ?>

    <div class="comment-pagination-numbers">
        <a href="<?php echo esc_url(add_query_arg('cpage', 1) . '#comments'); ?>"
            class="page-number <?php echo $current === 1 ? 'current' : ''; ?>">1</a>

        <?php if ($current - 1 > 2) echo '<span class="space">...</span>'; ?>

        <?php if ($current - 1 >= 2 && $current - 1 < $total) : ?>
            <a href="<?php echo esc_url(add_query_arg('cpage', $current - 1) . '#comments'); ?>"
                class="page-number"><?php echo $current - 1; ?></a>
        <?php endif; ?>

        <?php if ($current !== 1 && $current !== $total) : ?>
            <span class="page-number current"><?php echo $current; ?></span>
        <?php endif; ?>

        <?php if ($current + 1 >= 2 && $current + 1 < $total) : ?>
            <a href="<?php echo esc_url(add_query_arg('cpage', $current + 1) . '#comments'); ?>"
                class="page-number"><?php echo $current + 1; ?></a>
        <?php endif; ?>

        <?php if ($current + 1 < $total - 1) echo '<span class="space">...</span>'; ?>

        <?php if ($total > 1) : ?>
            <a href="<?php echo esc_url(add_query_arg('cpage', $total) . '#comments'); ?>"
                class="page-number <?php echo $current === $total ? 'current' : ''; ?>"><?php echo $total; ?></a>
        <?php endif; ?>
    </div>

    <?php if ($current < $total) : ?>
        <a href="<?php echo esc_url(add_query_arg('cpage', $current + 1) . '#comments'); ?>" class="page-number next">
            <i class="fa fa-chevron-right"></i>
        </a>
    <?php else : ?>
        <span class="page-number next disabled"><i class="fa fa-chevron-right"></i></span>
    <?php endif; ?>

    <div class="comment-page-jump">
        <span class="jump-label">跳至第</span>
        <input type="number" id="comment-page-input" class="comment-page-input"
            min="1" max="<?php echo $total; ?>" value="<?php echo $current; ?>">
        <span class="jump-label">页</span>
        <button type="button" id="comment-page-go" class="comment-page-go">
            <i class="fa fa-arrow-right"></i>
        </button>
    </div>

</nav>