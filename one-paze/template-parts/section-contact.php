<?php
/**
 * Contact Section
 */
$contact_section_email = esc_attr(get_theme_mod('contact_section_email'));
$contact_section_address = esc_attr(get_theme_mod('contact_section_address'));
$contact_section_phone = esc_attr(get_theme_mod('contact_section_phone'));
$contact_section_gmap_lat = esc_attr(get_theme_mod('contact_section_gmap_lat'));
$contact_section_gmap_long = esc_attr(get_theme_mod('contact_section_gmap_long'));
$contact_section_gmap_display = esc_attr(get_theme_mod('contact_section_gmap_display'));
?>
<section class="Imga">
<a href="https://www.google.de/maps/place/Rheinallee+88,+55120+Mainz/data=!4m2!3m1!1s0x47bd965be23d378f:0xa0188c1d40d8c7b3?sa=X&ved=0ahUKEwjIwuzepZTPAhXEXSwKHe1cB84Q8gEIGzAA"><img id="img1" src="http://www.hansjoergpein.de/wp-content/uploads/2016/04/Rohbau-und-Sonnenschein1_98-1-e1460374060398.jpg" alt="Smiley face" width="1500px">
</a>
</section>
<a name="Contact"></a>;
<?php echo do_shortcode("[huge_it_forms id='3']"); ?>
<div class="container">
    <div class="clearfix">

        <div class="contact-info clearfix">
            <?php if ($contact_section_email != '') : ?>
                <div class="wow fadeInLeft" data-wow-duration="2s">
                    <a href="mailto: <?php echo $contact_section_email; ?>">
                        <i class="fa fa-envelope"></i>
                        <div class="clearfix"></div>
                        <span><?php echo $contact_section_email; ?></span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($contact_section_address != '') : ?>
                <div class="wow fadeInDown" data-wow-duration="2s">
		    <a href="https://www.google.de/maps/place/Rheinallee+88,+55120+Mainz/data=!4m2!3m1!1s0x47bd965be23d378f:0xa0188c1d40d8c7b3?sa=X&ved=0ahUKEwiqtYGhtprMAhUMKpoKHSWXAtIQ8gEIHjAA" target="blank">
                        <i class="fa fa-map-marker"></i>
                        <div class="clearfix"></div>
                        <span><?php echo $contact_section_address; ?></span>
		    </a>
                </div>
            <?php endif; ?>

            <?php if ($contact_section_phone != '') : ?>
                <div class="wow fadeInRight" data-wow-duration="2s">
                    
                        <i class="fa fa-mobile"></i>
                        <div class="clearfix"></div>
                        <span><?php echo $contact_section_phone; ?></span>
                    
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if ($contact_section_gmap_display == 1) : ?>
    <?php if(is_active_sidebar('contact_section_map')) : ?>
    <div class="res-map-overlay">
        <?php dynamic_sidebar('contact_section_map'); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>