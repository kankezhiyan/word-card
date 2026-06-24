<?php
/**
 * Customizer Settings
 * 主题定制器：首页 / 卡片 / 页脚 / 页面 / 文章 / 评论 / 主题 / 通用
 */

function wordcard_customize_register($wp_customize)
{
    // === 首页设置 ===
    $wp_customize->add_section('wordcard_frontpage_section', array(
        'title' => __('首页 设置', 'wordcard'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('wordcard_enable_banner', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_banner', array(
        'label' => __('启用 Banner 横幅', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_site_title', array(
        'default' => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_site_title', array(
        'label' => __('banner标题', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_site_motto', array(
        'default' => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_site_motto', array(
        'label' => __('banner副标题', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_frontpage_post', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_frontpage_post', array(
        'label' => __('显示首页文章内容', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_enable_frontpage_title', array(
        'default' => true,
        'sanitize_callback' => function ($value) use ($wp_customize) {
            $enable_post = $wp_customize->get_setting('wordcard_enable_frontpage_post')->post_value();
            if ($enable_post === null) {
                $enable_post = get_theme_mod('wordcard_enable_frontpage_post', true);
            }
            if (!wp_validate_boolean($enable_post)) {
                return false;
            }
            return wp_validate_boolean($value);
        },
    ));
    $wp_customize->add_control('wordcard_enable_frontpage_title', array(
        'label' => __('显示首页标题', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'checkbox',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_frontpage_post', true);
        },
    ));

    $wp_customize->add_setting('wordcard_enable_sentences', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_sentences', array(
        'label' => __('启用一言展示', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_sentences_source', array(
        'default' => 'hitokoto',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_sentences_source', array(
        'label' => __('数据源', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'radio',
        'choices' => array(
            'hitokoto' => __('一言接口', 'wordcard'),
            'custom' => __('自定义数据', 'wordcard'),
        ),
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_sentences', true);
        },
    ));

    $wp_customize->add_setting('wordcard_sentences_api_url', array(
        'default' => 'https://v1.hitokoto.cn',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wordcard_sentences_api_url', array(
        'label' => __('一言接口地址', 'wordcard'),
        'description' => __('不生效请检查网络或接口格式，务必使用json回调', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'url',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_sentences', true) && get_theme_mod('wordcard_sentences_source', 'hitokoto') === 'hitokoto';
        },
    ));

    $wp_customize->add_setting('wordcard_sentences_custom_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wordcard_sentences_custom_url', array(
        'label' => __('自定义数据地址', 'wordcard'),
        'description' => __('数据格式请参考主题目录hitokoto目录下hitokoto.json，或直接修改该文件。留空则自动使用该文件数据', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'url',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_sentences', true) && get_theme_mod('wordcard_sentences_source', 'hitokoto') === 'custom';
        },
    ));

    $wp_customize->add_setting('wordcard_sentences_custom_link', array(
        'default' => '/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wordcard_sentences_custom_link', array(
        'label' => __('点击一言区域跳转链接', 'wordcard'),
        'section' => 'wordcard_frontpage_section',
        'type' => 'url',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_sentences', true) && get_theme_mod('wordcard_sentences_source', 'hitokoto') === 'custom';
        },
    ));

    // === 首页卡片面板 ===
    $wp_customize->add_panel('wordcard_frontpage_card_panel', array(
        'title' => __('首页 卡片', 'wordcard'),
        'priority' => 31,
    ));

    $wp_customize->add_section('wordcard_frontpage_card_general', array(
        'title' => __('常规设置', 'wordcard'),
        'panel' => 'wordcard_frontpage_card_panel',
    ));

    $wp_customize->add_setting('wordcard_enable_frontpage_card', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_frontpage_card', array(
        'label' => __('显示首页卡片', 'wordcard'),
        'section' => 'wordcard_frontpage_card_general',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_frontpage_card_count', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            $value = absint($value);
            return max(1, min(10, $value));
        },
    ));
    $wp_customize->add_control('wordcard_frontpage_card_count', array(
        'label' => __('卡片数量（1 - 10）', 'wordcard'),
        'section' => 'wordcard_frontpage_card_general',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 10),
    ));

    for ($i = 1; $i <= 10; $i++) {
        $wp_customize->add_section('wordcard_frontpage_card_' . $i, array(
            'title' => sprintf(__('卡片 %d', 'wordcard'), $i),
            'panel' => 'wordcard_frontpage_card_panel',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_image', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wordcard_frontpage_card_' . $i . '_image', array(
            'label' => __('卡片图片（媒体库上传）', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'settings' => 'wordcard_frontpage_card_' . $i . '_image',
        )));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_image_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_image_url', array(
            'label' => __('卡片图片链接（优先使用链接则覆盖上传图片）', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'url',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_title', array(
            'default' => sprintf(__('卡片 %d 标题', 'wordcard'), $i),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_title', array(
            'label' => __('卡片标题', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'text',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_content', array(
            'default' => sprintf(__('这里是卡片 %d 的描述内容，可在主题定制中进行修改。', 'wordcard'), $i),
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_content', array(
            'label' => __('卡片描述', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'textarea',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_link_enabled', array(
            'default' => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_link_enabled', array(
            'label' => __('显示链接按钮', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_link_text', array(
            'default' => __('了解更多', 'wordcard'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_link_text', array(
            'label' => __('链接文字', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'text',
        ));

        $wp_customize->add_setting('wordcard_frontpage_card_' . $i . '_link_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('wordcard_frontpage_card_' . $i . '_link_url', array(
            'label' => __('链接地址（留空则跳转到关于页面）', 'wordcard'),
            'section' => 'wordcard_frontpage_card_' . $i,
            'type' => 'url',
        ));
    }

    // === 页脚设置 ===
    $wp_customize->add_section('wordcard_footer_section', array(
        'title' => __('页脚 设置', 'wordcard'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('wordcard_footer_copyright_time', array(
        'default' => date('Y'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_footer_copyright_time', array(
        'label' => __('版权起始日期', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_footer_copyright_author', array(
        'default' => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_footer_copyright_author', array(
        'label' => __('版权所有者', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_icp', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_icp', array(
        'label' => __('启用 ICP 信息', 'wordcard'),
        'description' => __('(仅限中国大陆地区)', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_footer_icp', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_footer_icp', array(
        'label' => __('ICP信息', 'wordcard'),
        'description' => __('XICP备XXX号', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_beian', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_beian', array(
        'label' => __('启用网安备案信息', 'wordcard'),
        'description' => __('(仅限中国大陆地区)', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_footer_beian', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_footer_beian', array(
        'label' => __('网安备案信息', 'wordcard'),
        'description' => __('X公网安备XXX号', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_coustomer_text_first', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_coustomer_text_first', array(
        'label' => __('启用自定义文本信息一', 'wordcard'),
        'description' => __('位于版权信息下的自定义文本信息一', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_coustomer_text_first', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_coustomer_text_first', array(
        'label' => __('自定义文本信息一', 'wordcard'),
        'description' => __('可使用HTML标签', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_coustomer_text_second', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_coustomer_text_second', array(
        'label' => __('启用自定义文本信息二', 'wordcard'),
        'description' => __('位于版权信息下的自定义文本信息二', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_coustomer_text_second', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_coustomer_text_second', array(
        'label' => __('自定义文本信息二', 'wordcard'),
        'description' => __('可使用HTML标签', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_bg_info', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_bg_info', array(
        'label' => __('启用背景图作者信息', 'wordcard'),
        'description' => __('如果您使用了主题默认背景图片，请保持此项开启，谢谢', 'wordcard'),
        'section' => 'wordcard_footer_section',
        'type' => 'checkbox',
    ));

    // === 页面设置（分页）===
    $wp_customize->add_section('wordcard_page_section', array(
        'title' => __('页面 设置', 'wordcard'),
        'priority' => 50,
    ));

    $sanitize_int_range = function ($min, $max) {
        return function ($value) use ($min, $max) {
            $value = absint($value);
            return max($min, min($max, $value));
        };
    };

    $wp_customize->add_setting('wordcard_home_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_home_pagination', array(
        'label' => __('启用首页分页', 'wordcard'),
        'description' => __('关闭后首页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_home_per_page', array(
        'default' => 10,
        'sanitize_callback' => $sanitize_int_range(1, 50),
    ));
    $wp_customize->add_control('wordcard_home_per_page', array(
        'label' => __('首页文章数量', 'wordcard'),
        'description' => __('设置首页每页显示的文章数量（1-50）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50),
    ));

    $wp_customize->add_setting('wordcard_search_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_search_pagination', array(
        'label' => __('启用搜索结果分页', 'wordcard'),
        'description' => __('关闭后搜索结果将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_search_per_page', array(
        'default' => 15,
        'sanitize_callback' => $sanitize_int_range(1, 50),
    ));
    $wp_customize->add_control('wordcard_search_per_page', array(
        'label' => __('搜索结果数量', 'wordcard'),
        'description' => __('设置搜索结果每页显示的文章数量（1-50）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50),
    ));

    $wp_customize->add_setting('wordcard_archive_page_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_archive_page_pagination', array(
        'label' => __('启用归档"主"页分页', 'wordcard'),
        'description' => __('关闭后归档"主"页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_archive_page_per_page', array(
        'default' => 50,
        'sanitize_callback' => $sanitize_int_range(10, 100),
    ));
    $wp_customize->add_control('wordcard_archive_page_per_page', array(
        'label' => __('归档"主"页文章数量', 'wordcard'),
        'description' => __('设置归档"主"页每页显示的文章数量（10-100）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 10, 'max' => 100),
    ));

    $wp_customize->add_setting('wordcard_archive_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_archive_pagination', array(
        'label' => __('启用归档"子"页分页', 'wordcard'),
        'description' => __('关闭后归档"子"页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_archive_per_page', array(
        'default' => 50,
        'sanitize_callback' => $sanitize_int_range(10, 100),
    ));
    $wp_customize->add_control('wordcard_archive_per_page', array(
        'label' => __('归档"子"页文章数量', 'wordcard'),
        'description' => __('设置归档"子"页每页显示的文章数量（10-100）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 10, 'max' => 100),
    ));

    $wp_customize->add_setting('wordcard_category_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_category_pagination', array(
        'label' => __('启用分类页分页', 'wordcard'),
        'description' => __('关闭后分类页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_category_per_page', array(
        'default' => 50,
        'sanitize_callback' => $sanitize_int_range(10, 100),
    ));
    $wp_customize->add_control('wordcard_category_per_page', array(
        'label' => __('分类页文章数量', 'wordcard'),
        'description' => __('设置分类页每页显示的文章数量（10-100）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 10, 'max' => 100),
    ));

    $wp_customize->add_setting('wordcard_tag_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_tag_pagination', array(
        'label' => __('启用标签页分页', 'wordcard'),
        'description' => __('关闭后标签页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_tag_per_page', array(
        'default' => 50,
        'sanitize_callback' => $sanitize_int_range(10, 100),
    ));
    $wp_customize->add_control('wordcard_tag_per_page', array(
        'label' => __('标签页文章数量', 'wordcard'),
        'description' => __('设置标签页每页显示的文章数量（10-100）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 10, 'max' => 100),
    ));

    $wp_customize->add_setting('wordcard_author_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_author_pagination', array(
        'label' => __('启用作者页分页', 'wordcard'),
        'description' => __('关闭后作者页将显示全部文章不分页', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_author_per_page', array(
        'default' => 50,
        'sanitize_callback' => $sanitize_int_range(10, 100),
    ));
    $wp_customize->add_control('wordcard_author_per_page', array(
        'label' => __('作者页文章数量', 'wordcard'),
        'description' => __('设置作者页每页显示的文章数量（10-100）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 10, 'max' => 100),
    ));

    $wp_customize->add_setting('wordcard_category_show_count', array(
        'default' => 5,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('wordcard_category_show_count', array(
        'label' => __('类目展示最大文章数', 'wordcard'),
        'description' => __('分类/标签/作者"主"页中，文章信息列表大于多少则隐藏，数量（1-20）', 'wordcard'),
        'section' => 'wordcard_page_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 20),
    ));

    // === 文章设置 ===
    $wp_customize->add_section('wordcard_theme_article_section', array(
        'title' => __('文章 设置', 'wordcard'),
        'priority' => 55,
    ));

    $wp_customize->add_setting('wordcard_enable_bottom_info', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_enable_bottom_info', array(
        'label' => __('启用底部快捷链接区', 'wordcard'),
        'description' => __('关闭后文章页将不显示底部链接区', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_enable_author_page', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_enable_author_page', array(
        'label' => __('启用底部作者快捷链接', 'wordcard'),
        'description' => __('关闭后文章页将不显示作者页链接', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_author_page_text', array(
        'default' => '作者其他文章',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_author_page_text', array(
        'label' => __('底部作者快捷链接文本', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_tag_page', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_enable_tag_page', array(
        'label' => __('启用底部标签快捷链接', 'wordcard'),
        'description' => __('关闭后文章页将不显示便签快捷链接', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_tag_page_text', array(
        'default' => '同标签文章',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_tag_page_text', array(
        'label' => __('底部标签快捷链接文本', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_tag_page_last_text', array(
        'default' => '上一篇',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_tag_page_last_text', array(
        'label' => __('底部标签上一篇链接文本', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_tag_page_next_text', array(
        'default' => '下一篇',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_tag_page_next_text', array(
        'label' => __('底部标签下一篇链接文本', 'wordcard'),
        'section' => 'wordcard_theme_article_section',
        'type' => 'text',
    ));

    // === 评论设置 ===
    $wp_customize->add_section('wordcard_theme_comment_section', array(
        'title' => __('评论 设置', 'wordcard'),
        'priority' => 55,
    ));

    $wp_customize->add_setting('wordcard_enable_comments', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_enable_comments', array(
        'label' => __('启用评论区', 'wordcard'),
        'description' => __('关闭后将不显示评论区', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_comments_pagination', array(
        'default' => 1,
        'sanitize_callback' => function ($value) {
            return absint($value);
        },
    ));
    $wp_customize->add_control('wordcard_comments_pagination', array(
        'label' => __('启用评论分页', 'wordcard'),
        'description' => __('关闭后评论将显示全部不分页', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_comments_per_page', array(
        'default' => 20,
        'sanitize_callback' => $sanitize_int_range(1, 50),
    ));
    $wp_customize->add_control('wordcard_comments_per_page', array(
        'label' => __('评论每页数量', 'wordcard'),
        'description' => __('设置评论列表每页显示的评论数量（1-50）', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50),
    ));

    $wp_customize->add_setting('wordcard_comments_closed', array(
        'default' => '评论区已关闭',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_comments_closed', array(
        'label' => __('评论区关闭文本', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_comments_empty', array(
        'default' => '暂无评论',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_comments_empty', array(
        'label' => __('无评论时文本', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_comments_textarea', array(
        'default' => '写点什么……',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_comments_textarea', array(
        'label' => __('评论撰写区占位符', 'wordcard'),
        'description' => __('无内容时显示的提示文本', 'wordcard'),
        'section' => 'wordcard_theme_comment_section',
        'type' => 'text',
    ));

    // === 主题设置面板（5 种配色）===
    $wp_customize->add_panel('wordcard_theme_panel', array(
        'title' => __('主题 设置', 'wordcard'),
        'priority' => 65,
    ));

    $wordcard_theme_defaults = array(
        'day'       => array('font_color_0' => '#105d93', 'border_color_0' => '#105d93', 'bg_brightness' => 60,  'global_brightness' => 100, 'card_brightness' => 100, 'bg_contrast' => 100, 'global_contrast' => 100),
        'sunset'    => array('font_color_0' => '#105d93', 'border_color_0' => '#105d93', 'bg_brightness' => 60,  'global_brightness' => 95,  'card_brightness' => 90,  'bg_contrast' => 100, 'global_contrast' => 100),
        'night'     => array('font_color_0' => '#105d93', 'border_color_0' => '#105d93', 'bg_brightness' => 60,  'global_brightness' => 90,  'card_brightness' => 85,  'bg_contrast' => 100, 'global_contrast' => 100),
        'moonlight' => array('font_color_0' => '#479bd2', 'border_color_0' => '#479bd2', 'bg_brightness' => 60,  'global_brightness' => 85,  'card_brightness' => 80,  'bg_contrast' => 100, 'global_contrast' => 100),
        'lowlight'  => array('font_color_0' => '#479bd2', 'border_color_0' => '#479bd2', 'bg_brightness' => 60,  'global_brightness' => 50,  'card_brightness' => 70,  'bg_contrast' => 100, 'global_contrast' => 100),
    );

    $wordcard_sanitize_brightness = function ($value) {
        $value = absint($value);
        return max(20, min(100, $value));
    };
    $wordcard_sanitize_contrast = function ($value) {
        $value = absint($value);
        return max(1, min(100, $value));
    };

    // 全局设置子菜单
    $wp_customize->add_section('wordcard_theme_global', array(
        'title' => __('全局设置', 'wordcard'),
        'panel' => 'wordcard_theme_panel',
    ));

    $wp_customize->add_setting('wordcard_enable_bg_image', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_bg_image', array(
        'label' => __('使用背景图片', 'wordcard'),
        'description' => __('关闭后将使用纯色背景', 'wordcard'),
        'section' => 'wordcard_theme_global',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_enable_mourning', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_mourning', array(
        'label' => __('悼念模式', 'wordcard'),
        'description' => __('开启后全站画面变为灰度', 'wordcard'),
        'section' => 'wordcard_theme_global',
        'type' => 'checkbox',
    ));

    // 特定日期自动悼念模式
    $wp_customize->add_setting('wordcard_enable_mourning_by_date', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_mourning_by_date', array(
        'label'       => __('特定日期自动悼念模式', 'wordcard'),
        'description' => __('开启后，若当天日期命中下方"悼念日期列表"，则全站自动变为灰度', 'wordcard'),
        'section'     => 'wordcard_theme_global',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_mourning_date_list', array(
        'default'           => '12-13, 09-18, 04-04',
        'sanitize_callback' => function ($value) {
            $value = preg_replace('/[^\d\-\.,，\/\s月日]/u', '', $value);
            return sanitize_text_field($value);
        },
    ));
    $wp_customize->add_control('wordcard_mourning_date_list', array(
        'label'       => __('悼念日期列表', 'wordcard'),
        'description' => __('使用 MM-DD 格式，多个日期用英文逗号分隔。例如：12-13, 09-18, 04-04', 'wordcard'),
        'section'     => 'wordcard_theme_global',
        'type'        => 'textarea',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_mourning_by_date', false);
        },
    ));

    // 各主题模式子菜单
    $wordcard_theme_schemes = array(
        'day'       => __('日间模式', 'wordcard'),
        'sunset'    => __('黄昏模式', 'wordcard'),
        'night'     => __('夜间模式', 'wordcard'),
        'moonlight' => __('月光模式', 'wordcard'),
        'lowlight'  => __('暗光模式', 'wordcard'),
    );

    foreach ($wordcard_theme_schemes as $wordcard_scheme_key => $wordcard_scheme_label) {
        $wp_customize->add_section('wordcard_theme_' . $wordcard_scheme_key, array(
            'title' => $wordcard_scheme_label,
            'panel' => 'wordcard_theme_panel',
        ));

        $d = $wordcard_theme_defaults[$wordcard_scheme_key];

        // 背景图片 - 媒体库选择
        $wp_customize->add_setting('wordcard_bg_image_' . $wordcard_scheme_key . '_media', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wordcard_bg_image_' . $wordcard_scheme_key . '_media', array(
            'label'    => sprintf(__('%s 背景图片（媒体库）', 'wordcard'), $wordcard_scheme_label),
            'section'  => 'wordcard_theme_' . $wordcard_scheme_key,
            'settings' => 'wordcard_bg_image_' . $wordcard_scheme_key . '_media',
        )));

        // 背景图片 - URL 覆盖
        $wp_customize->add_setting('wordcard_bg_image_' . $wordcard_scheme_key . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('wordcard_bg_image_' . $wordcard_scheme_key . '_url', array(
            'label'       => sprintf(__('%s 背景图片（URL 覆盖）', 'wordcard'), $wordcard_scheme_label),
            'description' => __('填写后优先使用该链接，覆盖媒体库图片；都留空则使用默认', 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'url',
        ));

        // 主题强调色
        $wp_customize->add_setting('wordcard_font_color_0_' . $wordcard_scheme_key, array(
            'default' => $d['font_color_0'],
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wordcard_font_color_0_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 主题强调色', 'wordcard'), $wordcard_scheme_label),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
        )));

        // 主题边框强调色
        $wp_customize->add_setting('wordcard_border_color_0_' . $wordcard_scheme_key, array(
            'default' => $d['border_color_0'],
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wordcard_border_color_0_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 主题边框强调色', 'wordcard'), $wordcard_scheme_label),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
        )));

        // 背景亮度
        $wp_customize->add_setting('wordcard_bg_brightness_' . $wordcard_scheme_key, array(
            'default' => $d['bg_brightness'],
            'sanitize_callback' => $wordcard_sanitize_brightness,
        ));

        $wp_customize->add_control('wordcard_bg_brightness_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 背景亮度', 'wordcard'), $wordcard_scheme_label),
            'description' => __('数值范围 20-100，对应 CSS 默认 ' . $d['bg_brightness'], 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'number',
            'input_attrs' => array('min' => 20, 'max' => 100),
        ));

        // 画面亮度
        $wp_customize->add_setting('wordcard_global_brightness_' . $wordcard_scheme_key, array(
            'default' => $d['global_brightness'],
            'sanitize_callback' => $wordcard_sanitize_brightness,
        ));

        $wp_customize->add_control('wordcard_global_brightness_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 画面亮度', 'wordcard'), $wordcard_scheme_label),
            'description' => __('数值范围 20-100，对应 CSS 默认 ' . $d['global_brightness'], 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'number',
            'input_attrs' => array('min' => 20, 'max' => 100),
        ));

        // 卡片亮度
        $wp_customize->add_setting('wordcard_card_brightness_' . $wordcard_scheme_key, array(
            'default' => $d['card_brightness'],
            'sanitize_callback' => $wordcard_sanitize_brightness,
        ));

        $wp_customize->add_control('wordcard_card_brightness_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 卡片亮度', 'wordcard'), $wordcard_scheme_label),
            'description' => __('数值范围 20-100，对应 CSS 默认 ' . $d['card_brightness'], 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'number',
            'input_attrs' => array('min' => 20, 'max' => 100),
        ));

        // 背景对比度
        $wp_customize->add_setting('wordcard_bg_contrast_' . $wordcard_scheme_key, array(
            'default' => $d['bg_contrast'],
            'sanitize_callback' => $wordcard_sanitize_contrast,
        ));

        $wp_customize->add_control('wordcard_bg_contrast_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 背景对比度', 'wordcard'), $wordcard_scheme_label),
            'description' => __('数值范围 1-100，对应 CSS 默认 ' . $d['bg_contrast'], 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'number',
            'input_attrs' => array('min' => 1, 'max' => 100),
        ));

        // 画面对比度
        $wp_customize->add_setting('wordcard_global_contrast_' . $wordcard_scheme_key, array(
            'default' => $d['global_contrast'],
            'sanitize_callback' => $wordcard_sanitize_contrast,
        ));

        $wp_customize->add_control('wordcard_global_contrast_' . $wordcard_scheme_key, array(
            'label'       => sprintf(__('%s 画面对比度', 'wordcard'), $wordcard_scheme_label),
            'description' => __('数值范围 1-100，对应 CSS 默认 ' . $d['global_contrast'], 'wordcard'),
            'section'     => 'wordcard_theme_' . $wordcard_scheme_key,
            'type'        => 'number',
            'input_attrs' => array('min' => 1, 'max' => 100),
        ));
    }

    // === 通用设置 ===
    $wp_customize->add_section('wordcard_currency_section', array(
        'title' => __('通用 设置', 'wordcard'),
        'priority' => 70,
    ));

    $wp_customize->add_setting('wordcard_enable_page_title', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_page_title', array(
        'label' => __('显示页面标题（全局）', 'wordcard'),
        'description' => __('关闭后全局的常规页面将不显示页面标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_enable_words_count', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_words_count', array(
        'label' => __('使用文章字数统计（全局）', 'wordcard'),
        'description' => __('关闭后将不显示文章字数统计及阅读时长', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_enable_404_title', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_404_title', array(
        'label' => __('显示404页面标题', 'wordcard'),
        'description' => __('关闭后全局的常规页面将不显示页面标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_404_title', array(
        'default' => '糟糕',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_404_title', array(
        'label' => __('404页面主标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_404_sub_title', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_404_sub_title', array(
        'label' => __('显示404页面副标题', 'wordcard'),
        'description' => __('关闭后全局的常规页面将不显示页面标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_404_sub_title', array(
        'default' => '页面走丢了',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_404_sub_title', array(
        'label' => __('404页面副标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_enable_dynamic_title', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('wordcard_enable_dynamic_title', array(
        'label' => __('启用动态标题', 'wordcard'),
        'description' => __('页面切换到后台时标题会变化', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('wordcard_dynamic_title_hidden', array(
        'default' => '页面已休眠',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_dynamic_title_hidden', array(
        'label' => __('离开时标题', 'wordcard'),
        'description' => __('页面切换到后台时显示的标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_dynamic_title', true);
        },
    ));

    $wp_customize->add_setting('wordcard_dynamic_title_visible', array(
        'default' => '页面已显示',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_dynamic_title_visible', array(
        'label' => __('返回时标题', 'wordcard'),
        'description' => __('页面切回前台时短暂显示的标题', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
        'active_callback' => function () {
            return get_theme_mod('wordcard_enable_dynamic_title', true);
        },
    ));

    $wp_customize->add_setting('wordcard_share_text_prefix', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_share_text_prefix', array(
        'label' => __('分享文本前缀', 'wordcard'),
        'description' => __('复制链接时追加在 URL 之前的文字', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_share_text_suffix', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_share_text_suffix', array(
        'label' => __('分享文本后缀', 'wordcard'),
        'description' => __('复制链接时追加在 URL 之后的文字', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_share_success_message', array(
        'default' => '已复制链接',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_share_success_message', array(
        'label' => __('分享成功提示', 'wordcard'),
        'description' => __('链接复制成功时显示的提示', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('wordcard_share_error_message', array(
        'default' => '复制链接失败',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wordcard_share_error_message', array(
        'label' => __('分享失败提示', 'wordcard'),
        'description' => __('链接复制失败时显示的提示', 'wordcard'),
        'section' => 'wordcard_currency_section',
        'type' => 'text',
    ));
}
add_action('customize_register', 'wordcard_customize_register');
