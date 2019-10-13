<?php

/* My Slider Post Type */
add_action( 'init', 'my_slider_create_slide_post_type' );
function my_slider_create_slide_post_type() {
  register_post_type( 'slide',
    array(
      'labels' => array(
        'name' => __( 'Slider' ),
        'singular_name' => __( 'Slide' )
      ),
      'public' => true,
      'has_archive' => false,
      'exclude_from_search' => true,
      'supports' => array( 'title', 'thumbnail', 'editor', 'custom-fields', 'page-attributes' )
    )
  );
  flush_rewrite_rules();
}
/* My Slider Post Type */
