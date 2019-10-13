<?php

/* My Slider shortcode for displaying slides */
function my_slider_my_slides_shortcode($atts) {
  /* Shortcode Attributes:
      bullets: to shows bullets under slider (default: yes)
      nav-buttons: to shows nav buttons (default: yes)
      timer: duration between slides (default: 5000)
      animation : animation type for references (default: fade)
      number: number of slider to show (default: -1)
      image-style: image style for slide images (default: large)
  */
  $attributes = shortcode_atts( array(
    'bullets'     => 'yes',
    'nav-buttons' => 'yes',
    'timer'       => '5000',
    'animation'   => 'fade',
    'number'      => -1,
    'image-style' => 'large',
  ), $atts, 'my-slider' );

  /* Get references */
  $output = my_slider_get_slider(
              $attributes['bullets'],
              $attributes['nav-buttons'],
              $attributes['timer'],
              $attributes['animation'],
              $attributes['number'],
              $attributes['image-style']);

  return $output;
}
add_shortcode('my-slider', 'my_slider_my_slides_shortcode');
/* My Slider shortcode for displaying references */
