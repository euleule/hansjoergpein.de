<?php

function one_paze_page_lists() {
    $pages = get_pages();
    $page_list = array();
    $page_list[0] = __('Select Page', 'one-paze');
    foreach ($pages as $page) :
        $page_list[$page->ID] = $page->post_title;
    endforeach;
    return $page_list;
}

function one_paze_category_lists() {
    $categories = get_categories(
            array(
                'hide_empty' => 0,
                'exclude' => 1
            )
    );

    $category_list = array();
    $category_list[0] = __('Select Category', 'one-paze');
    foreach ($categories as $category) :
        $category_list[$category->term_id] = $category->name;
    endforeach;
    return $category_list;
}

if(!function_exists('one_paze_get_parallax_sections')) {
    function one_paze_get_parallax_sections() {
        $sections = array('about', 'portfolio', 'services', 'blog', 'cta', 'testimonial', 'team', 'contact');
        $enabled_section = array();
        foreach ($sections as $section) :
            if (esc_attr(get_theme_mod($section . '_section_enable')) == 1) :
                $enabled_section[] = array(
                    'id' => 'plx_' . $section . '_section',
                    'menu_text' => esc_attr(get_theme_mod($section . '_section_menu_title','')),
                    'section' => $section,
                );
            endif;
        endforeach;
        return $enabled_section;
    }    
}

function one_paze_slider_bx() {
    $enable_slider_overlay = esc_attr(get_theme_mod('enable_slider_overlay', ''));
    $slider_readmore_text = esc_attr(get_theme_mod('slider_readmore_text', 'Call To Action'));
    $slider_category = esc_attr(get_theme_mod('slider_category', 0));
    $sl_args = array('post_type' => 'post', 'posts_per_page' => 5, 'cat' => $slider_category );
    $sl_query = new WP_Query($sl_args);
    
    if($slider_category != '' || $slider_category != 0) :
        if($sl_query->have_posts()) :
        ?>
            <section id="plx-slider-section">
                <ul class='main-slider'>
                    <?php 
                        while($sl_query->have_posts()) : $sl_query->the_post();
                        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'one-paze-slider-image-size');
                        $img_src = $img[0];
                        $image_url =  "style = 'background-image: url(".$img_src.")';";
                    ?>
                    <li class="slide" <?php echo $image_url; ?> >
                        <?php /* <img src="<?php echo $img_src; ?>" /> */ ?>
                        <?php if ($enable_slider_overlay == 1) : ?>
                            <div class="slider-overlay1">
                            </div>
                        <?php endif; ?>
                        <div class="slide-caption">
                            <span class="caption-title"><?php the_title(); ?></span>
                            <span class="caption-descr"><?php the_content(); ?></span>
                            <?php if($slider_readmore_text != '') : ?>
                            <a class="cta_read" href="<?php the_permalink(); ?>" >
                                <?php echo $slider_readmore_text; ?>
                            </a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <div class="slider-down-btn">
                    <span class="next-page">
                        <a href="#plx_about_section"><i class="fa fa-angle-double-down"></i></a>
                    </span>
                </div>
            </section>
        <?php
        endif;
    endif;
}

function one_paze_slider_bxr() {
    $enable_slider_overlay = esc_attr(get_theme_mod('enable_slider_overlay'));
    $slides = array();
    for ($i = 1; $i < 5; $i++) {
        $sl_imageo = esc_attr(get_theme_mod('slide' . $i . '_image'));
        $img_id = attachment_url_to_postid(esc_url($sl_imageo));
        $img_arr = wp_get_attachment_image_src($img_id, 'one-paze-slider-image-size');
        $sl_image = $img_arr[0];
        
        $sl_cap_title = wp_kses_post(get_theme_mod('slide' . $i . '_caption_title'));
        $sl_cap_descr = wp_kses_post(get_theme_mod('slide' . $i . '_caption_descr'));
        $sl_btn_text = esc_attr(get_theme_mod('slide' . $i . '_button_text'));
        $sl_btn_link = esc_attr(get_theme_mod('slide' . $i . '_button_link'));
        if ($sl_image != '') {
            $slides[] = array(
                'image' => $sl_image,
                'caption_title' => $sl_cap_title,
                'caption_descr' => $sl_cap_descr,
                'btn_text' => $sl_btn_text,
                'btn_link' => $sl_btn_link
            );
        }
    }

    if (!empty($slides)) :
        ?>
        <section id="plx-slider-section">
            <ul class='main-slider'>
                <?php
                foreach ($slides as $slide) :
                    ?>
                    <li class="slide">
                        <img src="<?php echo esc_url($slide['image']); ?>" />
                        <?php if ($enable_slider_overlay == 1) : ?>
                            <div class="slider-overlay1">
                            </div>
                        <?php endif; ?>
                        <div class="slide-caption">
                            <span class="caption-title"><?php echo $slide['caption_title']; ?></span>
                            <span class="caption-descr"><?php echo $slide['caption_descr']; ?></span>
                            <a class="cta_read" href="<?php echo esc_url($slide['btn_link']); ?>" >
                                <?php echo $slide['btn_text']; ?>
                                <!--<div class="card">
                                    <div class="face front">
                                <?php echo $slide['btn_text']; ?>
                                    </div>
                                    <div class="face back">
                                <?php echo $slide['btn_text']; ?>
                                    </div>
                                </div>-->

                            </a>
                        </div>
                    </li>                          
                    <?php
                endforeach;
                ?>
            </ul>
            <div class="slider-down-btn">
                <span class="next-page">
                    <a href="#plx_about_section"><i class="fa fa-angle-double-down"></i></a>
                </span>
            </div>
        </section>
        <?php
    endif;
}

add_action('one_paze_slider', 'one_paze_slider_bx');

function one_paze_breadcrumb_cb() {
    global $post;
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $portfolio_section_category = get_theme_mod('portfolio_section_category', 0);

    $delimiter = '&#124;'; // delimiter between crumbs

    $home = __('Home', 'one-paze'); // text for the 'Home' link

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb

    $homeLink = esc_url(home_url());

    if (is_home() || is_front_page()) {
        if ($showOnHome == 1)
            echo '<div id="onepager-breadcrumbs"><div class="ap-container"><a href="' . $homeLink . '">' . $home . '</a></div></div>';
    } else {
        echo '<div id="onepager-breadcrumbs"><div class="ap-container"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0)
                echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
            if ($portfolio_section_category != 0 && $thisCat->term_id == $portfolio_section_category){
                echo $before . single_cat_title('', false) . $after;
            } else {
                echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
            }
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1)
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                $proj_cat = esc_attr(get_theme_mod('portfolio_section_category'));
                if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo $cats;
                if ($showCurrent == 1)
                    echo $before . get_the_title() . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1)
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1)
                    echo ' ' . $delimiter . ' ';
            }
            if ($showCurrent == 1)
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            _e('Page', 'one-paze') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }

        echo '</div></div>';
    }
}

add_action('one_paze_breadcrumb', 'one_paze_breadcrumb_cb');

/** Is home page with set to display latest posts and parallax is enabled * */

/** Tgm Configuration * */
function one_paze_register_required_plugins() {

    $plugins = array(
        array(
            'name' => 'AccessPress Twitter Feed',
            'slug' => 'accesspress-twitter-feed',
            'required' => false,
        ),
        array(
            'name' => 'AccessPress Social Icons',
            'slug' => 'accesspress-social-icons',
            'required' => false,
        ),
        array(
            'name' => 'AccessPress Social Counter',
            'slug' => 'accesspress-social-counter',
            'required' => false,
        ),
        array(
            'name' => 'AccessPress Social Share',
            'slug' => 'accesspress-social-share',
            'required' => false,
        ),
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => false,
        ),
        array(
            'name' => 'Ultimate Form Builder Lite',
            'slug' => 'ultimate-form-builder-lite',
            'required' => false,
        ),
        array(
            'name' => 'AccessPress Social Login',
            'slug' => 'accesspress-social-login',
            'required' => false,
        ),
    );

    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to pre-packaged plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug' => 'themes.php', // Parent menu slug.
        'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => __('Install Required Plugins', 'one-paze'),
            'menu_title' => __('Install Plugins', 'one-paze'),
            'installing' => __('Installing Plugin: %s', 'one-paze'), // %s = plugin name.
            'oops' => __('Something went wrong with the plugin API.', 'one-paze'),
            'notice_can_install_required' => _n_noop(
                    'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop(
                    'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop(
                    'Sorry, but you do not have the correct permissions to install the %1$s plugin.', 'Sorry, but you do not have the correct permissions to install the %1$s plugins.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop(
                    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe' => _n_noop(
                    'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop(
                    'Sorry, but you do not have the correct permissions to update the %1$s plugin.', 'Sorry, but you do not have the correct permissions to update the %1$s plugins.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop(
                    'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop(
                    'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'one-paze'
            ), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop(
                    'Sorry, but you do not have the correct permissions to activate the %1$s plugin.', 'Sorry, but you do not have the correct permissions to activate the %1$s plugins.', 'one-paze'
            ), // %1$s = plugin name(s).
            'install_link' => _n_noop(
                    'Begin installing plugin', 'Begin installing plugins', 'one-paze'
            ),
            'update_link' => _n_noop(
                    'Begin updating plugin', 'Begin updating plugins', 'one-paze'
            ),
            'activate_link' => _n_noop(
                    'Begin activating plugin', 'Begin activating plugins', 'one-paze'
            ),
            'return' => __('Return to Required Plugins Installer', 'one-paze'),
            'plugin_activated' => __('Plugin activated successfully.', 'one-paze'),
            'activated_successfully' => __('The following plugin was activated successfully:', 'one-paze'),
            'plugin_already_active' => __('No action taken. Plugin %1$s was already active.', 'one-paze'), // %1$s = plugin name(s).
            'plugin_needs_higher_version' => __('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'one-paze'), // %1$s = plugin name(s).
            'complete' => __('All plugins installed and activated successfully. %1$s', 'one-paze'), // %s = dashboard link.
            'contact_admin' => __('Please contact the administrator of this site for help.', 'tgmpa'),
            'nag_type' => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'one_paze_register_required_plugins');

/** Assign Class for Blog Page Layout **/
function one_paze_assign_alt_classes( $classes ) {
    	global $post;
        static $flag = true;
        
        if($flag){
            $classes[] = 'alt-left';
            $flag = false;
        }else{
            $classes[] = 'alt-right';
            $flag = true;
        }
        
    	return $classes;
    }
if(esc_attr(get_theme_mod('blog_page_layouts')) == 'blog_image_alt_medium'){
    add_filter( 'post_class', 'one_paze_assign_alt_classes' );
} 

if( class_exists( 'WP_Customize_Control' ) ) :
    class WP_Customize_Ohelp_Control extends WP_Customize_Control{            
        public function render_content() {
            $input_attrs = $this->input_attrs;
            $info = isset($input_attrs['info']) ? $input_attrs['info'] : '';
            ?>
            <div class="help-info">
                <h4><?php _e('Instruction', 'one-paze'); ?></h4>
                <div style="font-weight: bold;">
                    <?php echo $info; ?>
                </div>
            </div>
            <?php
        }
    }
endif;

// Our Product detail's
if(class_exists( 'WP_Customize_control')){
    class Theme_Info_Product_Custom_Control extends WP_Customize_Control
    {
        public function render_content()
        {
            ?>
            <label>
                <!-- <h3 class="customize-title"><?php //echo esc_html( $this->label ); ?></h3>
                <br /> -->
                <span class="customize-text_editor_desc button">
                    <?php echo wp_kses_post( $this->description ); ?>
                </span>
            </label>
            <?php
        }
    }
}

// AccessPress Store Pro Features
if(class_exists( 'WP_Customize_control')){
    class Theme_Info_Custom_Control extends WP_Customize_Control
    {
        public function render_content()
        {
            ?>
            <label>
                <h2 class="customize-title"><?php echo esc_html( $this->label ); ?></h2>
                <br />
                <span class="customize-text_editor_desc">                  
                  <img class="feat-list-img" src="<?php echo get_template_directory_uri() ?>/inc/images/feature-list-pro.png"/>
                      <ul class="admin-pro-feature-list">   
                        <li><span><?php _e('Fully built on customizer!','one-paze'); ?> </span></li>
                        <li><span><?php _e('3 Menu Styles','one-paze'); ?> </span></li>
                        <li><span><?php _e('Full Page Slider Options','one-paze'); ?> </span></li>
                        <li><span><?php _e('Custom Template Color','one-paze'); ?> </span></li>
                        <li><span><?php _e('One click demo import functionality','one-paze'); ?> </span></li>
                        <li><span><?php _e('Highly configurable One Page home page','one-paze'); ?> </span></li>
                        <li><span><?php _e('Youtube video integration','one-paze'); ?> </span></li>
                        <li><span><?php _e('Multiple Blog layout','one-paze'); ?> </span></li>
                        <li><span><?php _e('Flexible Page Options','one-paze'); ?> </span></li>
                        <li><span><?php _e('Multiple Portfolio Page Layouts','one-paze'); ?> </span></li>
                        <li><span><?php _e('Multiple Service Page Layouts','one-paze'); ?> </span></li>
                        <li><span><?php _e('5 Page Templates','one-paze'); ?> </span></li>
                        <li><span><?php _e('13 Inbuilt Widgets','one-paze'); ?> </span></li>
                        <li><span><?php _e('13 Inbuilt useful Shortcodes','one-paze'); ?> </span></li>
                        <li><span><?php _e('Dynamic Sidebar options','one-paze'); ?> </span></li>
                        <li><span><?php _e('Advanced Typography Options','one-paze'); ?> </span></li>
                    </ul>

                    <a href="https://accesspressthemes.com/wordpress-themes/one-paze-pro" class="button button-primary buynow" target="_blank"><?php _e('Buy Now','one-paze'); ?></a>
                </span>
            </label>
            <?php
        }
    }
}
?>