<?php
$test_section_title = esc_attr(get_theme_mod('testimonial_section_title'));
$test_category = esc_attr(get_theme_mod('testimonial_section_category'));
$test_query = new WP_Query(array('post_type' => 'post', 'cat' => $test_category, 'posts_per_page' => 6));
?>

<div class="container">
    <div class="testinomial clearfix">
        <h2><?php echo $test_section_title; ?></h2>
        <?php if ($test_query->have_posts() && $test_category) : ?>
            <div class="testimonial-slider clearfix">
                <?php while ($test_query->have_posts()) : $test_query->the_post(); ?>
                    <div class="testimonial-post-wrap wow fadeInUp" data-wow-duration="2s">
                        <div class="client-testimonial">    
                            <?php echo wp_trim_words(get_the_content(), 50); ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="author_main">
                            <div class="author">
                                <figure>
                                    <?php
                                    $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'one-paze-testimonial-thumb');
                                    $img_src = $img[0];
                                    ?>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php echo $img_src; ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" />
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/no-testimonial-thumbnail.png" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" />
                                    <?php endif; ?>
                                </figure>
                                <div class="clearfix"></div>
                                <h3 class="client-name">
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="container">
	<div class="test">
	<a href="https://www.google.de/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwihyOGZy5zMAhXoBsAKHXR4CHEQFgggMAA&url=http%3A%2F%2Fwww.miessner-schroeder.de%2F&usg=AFQjCNE_Al7asWpPGT9RfUrQoT9vTJUxPg&sig2=2j4q4yM8z_Qv4Us4NwKvXQ" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/Miessner-Schröder.png"  target="_blank"></a> ;
	<a href="https://www.google.de/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwjel56iy5zMAhXhAMAKHTD5BVoQFggeMAA&url=https%3A%2F%2Fwww.thesius.de%2F&usg=AFQjCNG4WUyBb9Fm4u1I9HSgio6cNoczXQ&sig2=ph_CKIZJ7HTtpvdT8lInTg" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/thesius.png" target="_blank"></a> ;
	<a href="https://www.google.de/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwiO1Z6ty5zMAhXNFsAKHXTHDX4QFggeMAA&url=http%3A%2F%2Fwww.diefinanzpartner.de%2F&usg=AFQjCNHR2sR8mLP-iZUw2CU_J3YI-6rIZg&sig2=1vxPYwJHMV-NXniInRKAdA" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/fp_logo.png" target="_blank"></a> ;
	<a href="" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/sooni-e1456916094533.png" target="_blank" height="70"></a> ;
	<a href="http://rohbau-sonnenschein.de/" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/rs_logo.jpg" target="_blank" height="70"></a> ;
	<a href="" target="_blank"><img src="http://www.hansjoergpein.de/wp-content/uploads/2016/02/ecs_logo1.jpg" target="_blank"></a> ;
	</div>
</div>