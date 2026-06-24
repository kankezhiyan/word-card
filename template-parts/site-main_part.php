<?php
get_header();
if (get_theme_mod("wordcard_enable_bg_image", true)): ?>
    <div class="full-background"></div>
<?php endif;
get_template_part('template-parts/site', 'scheme_bar');
if (!is_404()) {
    get_sidebar();
}
get_template_part('template-parts/site', 'alert');
?>