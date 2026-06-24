<?php
/**
 * Asset Loading
 * CSS / JS 资源加载与版本化
 */

function wordcard_file_version($rel_path)
{
    $abs_path = get_template_directory() . '/' . ltrim($rel_path, '/');
    if (file_exists($abs_path)) {
        return filemtime($abs_path);
    }
    return wp_get_theme()->get('Version');
}

function wordcard_enqueue_styles()
{
    wp_enqueue_style('wordcard-reset', get_template_directory_uri() . '/wordcard/css/reset.css', array(), wordcard_file_version('wordcard/css/reset.css'));
    wp_enqueue_style('wordcard-theme-scheme', get_template_directory_uri() . '/wordcard/css/theme-scheme.css', array(), wordcard_file_version('wordcard/css/theme-scheme.css'));
    wp_enqueue_style('wordcard-article', get_template_directory_uri() . '/wordcard/css/article.css', array(), wordcard_file_version('wordcard/css/article.css'));
    wp_enqueue_style('wordcard-animation', get_template_directory_uri() . '/wordcard/css/animation.css', array(), wordcard_file_version('wordcard/css/animation.css'));
    wp_enqueue_style('wordcard-style', get_stylesheet_uri(), array('wordcard-reset', 'wordcard-theme-scheme', 'wordcard-article', 'wordcard-animation'), wordcard_file_version('style.css'));
}
add_action('wp_enqueue_scripts', 'wordcard_enqueue_styles');

function wordcard_enqueue_scripts()
{
    wp_enqueue_script('wordcard-functions', get_template_directory_uri() . '/wordcard/js/functions.js', array(), wordcard_file_version('wordcard/js/functions.js'), true);
    wp_enqueue_script('wordcard-word-card', get_template_directory_uri() . '/wordcard/js/word-card.js', array('wordcard-functions'), wordcard_file_version('wordcard/js/word-card.js'), true);
    wp_enqueue_script('wordcard-theme-scheme', get_template_directory_uri() . '/wordcard/js/theme-scheme.js', array('wordcard-functions'), wordcard_file_version('wordcard/js/theme-scheme.js'), true);

    wp_localize_script('wordcard-word-card', 'wordcardDynamicTitle', array(
        'enabled' => get_theme_mod('wordcard_enable_dynamic_title', true),
        'hidden' => esc_js(get_theme_mod('wordcard_dynamic_title_hidden', '页面已休眠')),
        'visible' => esc_js(get_theme_mod('wordcard_dynamic_title_visible', '页面已显示')),
    ));

    wp_localize_script('wordcard-word-card', 'wordcardShareText', array(
        'prefix' => esc_js(get_theme_mod('wordcard_share_text_prefix', '')),
        'suffix' => esc_js(get_theme_mod('wordcard_share_text_suffix', '')),
        'successMsg' => esc_js(get_theme_mod('wordcard_share_success_message', '已复制链接')),
        'errorMsg' => esc_js(get_theme_mod('wordcard_share_error_message', '复制链接失败')),
    ));

    wp_localize_script('wordcard-functions', 'wordcardMourningByDateConfig', array(
        'enabled' => get_theme_mod('wordcard_enable_mourning_by_date', false) ? '1' : '0',
        'dates'   => esc_js(get_theme_mod('wordcard_mourning_date_list', '12-13, 09-18, 04-04')),
    ));
}
add_action('wp_enqueue_scripts', 'wordcard_enqueue_scripts');

function wordcard_enqueue_frontpage_scripts()
{
    if (is_front_page() && get_theme_mod('wordcard_enable_sentences', true)) {
        wp_enqueue_script('wordcard-flowing-sentences', get_template_directory_uri() . '/wordcard/js/flowing-sentences.js', array(), wordcard_file_version('wordcard/js/flowing-sentences.js'), true);

        wp_localize_script('wordcard-flowing-sentences', 'wordcardSentencesConfig', array(
            'source'     => sanitize_text_field(get_theme_mod('wordcard_sentences_source', 'hitokoto')),
            'apiUrl'     => esc_url(get_theme_mod('wordcard_sentences_api_url', 'https://v1.hitokoto.cn')),
            'customUrl'  => esc_url(get_theme_mod('wordcard_sentences_custom_url', '')),
            'customLink' => esc_url(get_theme_mod('wordcard_sentences_custom_link', '/')),
            'defaultUrl' => esc_url(get_template_directory_uri() . '/hitokoto/hitokoto.json'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'wordcard_enqueue_frontpage_scripts');
