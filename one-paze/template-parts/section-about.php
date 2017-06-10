<?php
    /**
     * About Parallax Section
     */
     $about_title = esc_attr(get_theme_mod('about_section_title'));
     $about_pg_id = esc_attr(get_theme_mod('about_section_page'));
     $about_page = get_page($about_pg_id);
?>
<div class="about clearfix">
    <?php if($about_pg_id) : ?>
        <h2 class="wow slideInLeft" data-wow-duration="2s"><?php echo $about_title; ?></h2>
        <div class="about-contents wow slideInRight" data-wow-duration="2s">
            <?php echo $about_page->post_content; ?>
        </div>
    <?php endif; ?>
</div>