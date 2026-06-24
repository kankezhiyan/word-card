<!DOCTYPE html>
<!--
 !
 !
 !
 !
 !
 !
ₘₙⁿ
▏n
█▏　､⺍
█▏ ⺰ʷʷｨ
█◣▄██◣
◥██████▋
　◥████ █▎
　　███▉ █▎
　◢████◣⌠ₘ℩
　　██◥█◣\≫
　　██　◥█◣
　　█▉　　█▊
　　█▊　　█▊
　　█▊　　█▋
　　 █▏　　█▙
　　 █
止まるんじゃねぇぞ…

-->
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />

    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://cdn.bootcdn.net" crossorigin>
    <link rel="preconnect" href="https://cdn.staticfile.net" crossorigin>

    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/lxgw-wenkai-screen-webfont/1.7.0/style.min.css" />
    <link rel="preload" as="style" href="https://cdn.staticfile.net/font-awesome/4.7.0/css/font-awesome.min.css"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.staticfile.net/font-awesome/4.7.0/css/font-awesome.min.css"></noscript>

    <?php wp_head(); ?>
</head>

<body>
    <?php wp_body_open(); ?>