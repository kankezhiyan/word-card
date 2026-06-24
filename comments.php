<?php
if (post_password_required()) {
    return;
}

$reply_to = isset($_GET['replytocom']) ? intval($_GET['replytocom']) : 0;
$parent_comment = null;
if ($reply_to > 0) {
    $parent_comment = get_comment($reply_to);
}
?>

<div id="comments" class="comments-area">
    <div class="comments-container">
        <?php
        $comments_number    = (int) get_comments_number();
        $comments_pagination = get_theme_mod('wordcard_comments_pagination', 1);
        $comments_per_page  = $comments_pagination ? (int) get_theme_mod('wordcard_comments_per_page', 20) : 9999;
        $comments_open      = comments_open();
        $post_type_supports = post_type_supports(get_post_type(), 'comments');
        ?>

        <?php if ($comments_number > 0) : ?>
            <?php
            $all_comments = get_comments(array(
                'post_id'  => get_the_ID(),
                'status'   => 'approve',
                'orderby'  => 'comment_date_gmt',
                'order'    => 'ASC',
            ));
            ?>
            <div class="comments-header">
                <div class="comments-title">
                    <i class="fa fa-comments"></i>
                    <?php
                    printf(
                        _n('评论(%s)', '评论(%s)', $comments_number, 'wordcard'),
                        number_format_i18n($comments_number)
                    );
                    ?>
                </div>
            </div>

            <ul class="comment-list">
                <?php
                wp_list_comments(array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 48,
                    'per_page'    => $comments_per_page,
                    'callback'    => 'wordcard_comment_callback',
                ), $all_comments);
                ?>
            </ul>

            <?php if ($comments_pagination) : ?>
                <?php get_template_part('template-parts/site-comment_paginator'); ?>
            <?php endif; ?>

        <?php elseif ($comments_open && $post_type_supports) : ?>
            <div class="no-comments">
                <i class="fa fa-comment-o"></i><span><?php echo esc_html(get_theme_mod('wordcard_comments_empty', '暂无评论')); ?></span>
            </div>

        <?php elseif (!$comments_open && $post_type_supports) : ?>
            <div class="no-comments">
                <i class="fa fa-lock"></i><span><?php echo esc_html(get_theme_mod('wordcard_comments_closed', '评论已关闭')); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($comments_open && $post_type_supports) : ?>
    <div class="comments-container">
        <div id="respond" class="comment-respond">
            <div class="comments-header">
                <div class="comments-title">
                    <i class="fa fa-commenting"></i> 发表评论
                </div>
            </div>

            <?php if ($parent_comment) : ?>
                <div class="reply-container">
                    <div class="reply-statement">
                        正在回复：
                    </div>
                    <div class="reply-quote">
                        <div class="reply-quote-head">
                            <span class="reply-quote-icon"><i class="fa fa-reply"></i></span>
                            <span class="reply-quote-author"><?php echo esc_html($parent_comment->comment_author); ?></span>
                            <span class="reply-quote-date"><?php echo esc_html(get_comment_date('', $parent_comment)); ?></span>
                        </div>
                        <div class="reply-quote-content">
                            <?php echo wp_kses_post($parent_comment->comment_content); ?>
                        </div>
                    </div>
                    <div class="reply-close">
                        <a href="<?php echo esc_url(remove_query_arg('replytocom') . '#comments'); ?>">取消回复</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $current_user = wp_get_current_user();
            $user_name = $current_user->exists() ? esc_html($current_user->display_name) : '';
            $current_container = $current_user->exists() ? '<div class="comment-submit">' : '';

            comment_form(array(
                'title_reply'          => '',
                'title_reply_to'       => '',
                'cancel_reply_link'    => ' ',
                'submit_button' => '<button name="submit" type="submit" id="submit" class="submit-btn submit"><span class="submit-btn-text"><i class="fa fa-send"></i></span>发送</button>',
                'submit_field' => $current_container . '%1$s %2$s</div>',
                'comment_notes_before' => '<div class="comment-notes"><i class="fa fa-bell"></i>您尚未登录，您可<a href="' . esc_url(wp_login_url(get_permalink())) . '">登录</a>或<a href="' . esc_url(wp_registration_url()) . '">注册</a>，或填写下方信息后以<a>访客</a>身份评论</div>',
                'comment_notes_after'  => '',
                'logged_in_as'      => '<div class="logged-in-as"><span class="logged-in-text">当前身份：<a href="' . esc_url(admin_url('profile.php')) . '">' . $user_name . '</a></span><a class="logout-link" href="' . esc_url(wp_logout_url(get_permalink())) . '" title="注销">注销</a></div>',
                'fields'               => array(
                    'author' => '<div class="comment-row"><div class="comment-form-input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user-circle"></i></span></div><input id="comment-author" class="form-control" placeholder="昵称" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" /></div>',
                    'email'  => '<div class="comment-form-input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div> <input id="comment-email" class="form-control" placeholder="邮箱" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" /></div></div>',
                    'url'    => '<div class="comment-row"><div class="comment-form-input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-link"></i></span></div><input id="comment-url" class="form-control" placeholder="主站（非必填）" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div></div>',
                    'cookies' => '<div class="comment-submit"><div class="comment-cookies"><input id="comment-cookies" class="form-checkbox" name="cookies" type="checkbox" value="" />缓存身份数据</div>',
                ),
                'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" placeholder="'.esc_html(get_theme_mod('wordcard_comments_textarea', '写点什么……')).'" name="comment" cols="45" rows="5"></textarea></div>',
            ));
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>
