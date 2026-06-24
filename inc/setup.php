<?php
/**
 * Theme Setup
 * 注册菜单、主题功能支持
 */

function wordcard_theme_setup()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wordcard'),
        'secondary' => __('Secondary Menu', 'wordcard'),
    ));

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'wordcard_theme_setup');

add_filter('thread_comments_depth_limit', '__return_false');
