<?php
/**
 * Pagination Logic
 * 自定义首页 / 归档 / 搜索 / 分类 / 标签 / 作者 每页文章数
 */

function custom_posts_per_page($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    $mod_pagination = function ($key, $default = 1) {
        return get_theme_mod($key, $default);
    };

    $mod_per_page = function ($key, $default) {
        $per_page = get_theme_mod($key, $default);
        return $per_page ? $per_page : $default;
    };

    if (is_home()) {
        $pagination = $mod_pagination('wordcard_home_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_home_per_page', 10) : -1);
    }

    if (is_search()) {
        $pagination = $mod_pagination('wordcard_search_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_search_per_page', 15) : -1);
    }

    if (is_archive()) {
        $pagination = $mod_pagination('wordcard_archive_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_archive_per_page', 50) : -1);
    }

    if (is_category()) {
        $pagination = $mod_pagination('wordcard_category_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_category_per_page', 50) : -1);
    }

    if (is_tag()) {
        $pagination = $mod_pagination('wordcard_tag_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_tag_per_page', 50) : -1);
    }

    if (is_author()) {
        $pagination = $mod_pagination('wordcard_author_pagination', 1);
        $query->set('posts_per_page', $pagination ? $mod_per_page('wordcard_author_per_page', 50) : -1);
    }
}
add_action('pre_get_posts', 'custom_posts_per_page');
