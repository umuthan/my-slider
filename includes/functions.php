<?php

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function my_slider_get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = get_intermediate_image_sizes();

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }

    return $image_sizes;
}

/**
 * Get posts of slider
 * bullets='true' nav-buttons='true' timer='5000' animation='fade' number='-1' image-style='large'
 */
function my_slider_get_slider($bullets, $navButtons, $timer, $animation, $number, $imageStyle) {
  $args = array(
    'numberposts' => $number,
    'post_type'   => 'slide'
  );

  $mySlider = get_posts($args);

  $output = '<div class="orbit" role="region" data-orbit data-options="';
  $output .= 'timerDelay:'.$timer.'; ';
  if($animation == 'fade') $output .= 'animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;';
  else if($animation == 'slide-left') $output .= 'animInFromLeft:slide-in-left; animInFromRight:slide-in-right; animOutToLeft:slide-out-left; animOutToRight:slide-out-right;';
  else if($animation == 'slide-right') $output .= 'animInFromLeft:slide-in-right; animInFromRight:slide-in-left; animOutToLeft:slide-out-right; animOutToRight:slide-out-left;';
  else if($animation == 'slide-up') $output .= 'animInFromLeft:slide-in-down; animInFromRight:slide-in-up; animOutToLeft:slide-out-up; animOutToRight:slide-out-down;';
  else if($animation == 'slide-down') $output .= 'animInFromLeft:slide-in-up; animInFromRight:slide-in-down; animOutToLeft:slide-out-down; animOutToRight:slide-out-up;';
  else if($animation == 'hinge-left') $output .= 'animInFromLeft:hinge-in-from-left; animInFromRight:hinge-in-from-right; animOutToLeft:hinge-out-from-left; animOutToRight:hinge-out-from-right;';
  else if($animation == 'hinge-right') $output .= 'animInFromLeft:hinge-in-from-right; animInFromRight:hinge-in-from-left; animOutToLeft:hinge-out-from-right; animOutToRight:hinge-out-from-left;';
  else if($animation == 'hinge-top') $output .= 'animInFromLeft:hinge-in-from-bottom; animInFromRight:hinge-in-from-top; animOutToLeft:hinge-out-from-top; animOutToRight:hinge-out-from-bottom;';
  else if($animation == 'hinge-bottom') $output .= 'animInFromLeft:hinge-in-from-top; animInFromRight:hinge-in-from-bottom; animOutToLeft:hinge-out-from-bottom; animOutToRight:hinge-out-from-top;';
  else if($animation == 'hinge-middle-x') $output .= 'animInFromLeft:hinge-in-from-middle-x; animInFromRight:hinge-in-from-middle-x; animOutToLeft:hinge-out-from-middle-x; animOutToRight:hinge-out-from-middle-x;';
  else if($animation == 'hinge-middle-y') $output .= 'animInFromLeft:hinge-in-from-middle-y; animInFromRight:hinge-in-from-middle-y; animOutToLeft:hinge-out-from-middle-y; animOutToRight:hinge-out-from-middle-y;';
  else if($animation == 'scale-in') $output .= 'animInFromLeft:scale-in-up; animInFromRight:scale-in-down; animOutToLeft:scale-out-up; animOutToRight:scale-out-down;';
  else if($animation == 'scale-out') $output .= 'animInFromLeft:scale-in-down; animInFromRight:scale-in-up; animOutToLeft:scale-out-down; animOutToRight:scale-out-up;';
  else if($animation == 'spin') $output .= 'animInFromLeft:spin-in-ccw; animInFromRight:spin-in; animOutToLeft:spin-out; animOutToRight:spin-out-ccw;';
  else if($animation == 'spin-ccw') $output .= 'animInFromLeft:spin-in; animInFromRight:spin-in-ccw; animOutToLeft:spin-out-ccw; animOutToRight:spin-out;';
  $output .= '">
  <div class="orbit-wrapper">';

    if($navButtons == 'yes') $output .= '<div class="orbit-controls">
      <button class="orbit-previous">&#9664;&#xFE0E;</button>
      <button class="orbit-next">&#9654;&#xFE0E;</button>
    </div>';

    $output .= '<ul class="orbit-container">';

  if($mySlider) {
    $slideNumber = 0;
    foreach ($mySlider as $slide) :
      $slideID = $slide->ID;
      // Slide Title
      $slideTitle = get_the_title($slideID);
      // Slide Image defined as featured image in slide
      $slideImage = get_the_post_thumbnail_url($slideID, $imageStyle);
      // Slide Web Site defined as web-site custom-field
      $slideWebSite = get_post_meta($slideID, 'web-site', true);
      // Slide Content
      $slideContent = $slide->post_content;
      if($slideNumber==0) $output .= '<li class="is-active orbit-slide">';
      else $output .= '<li class="orbit-slide">';
      $output .= '<figure class="orbit-figure">';
      if($slideWebSite) $output .= '<a href="'.$slideWebSite.'">';
      $output .= '<img class="orbit-image" src="'.$slideImage.'" alt="'.$slideTitle.'">';
      if($slideWebSite) $output .= '</a>';
      if($slideContent) $output .= '<figcaption class="orbit-caption"><div class="orbit-caption-content">'.$slideContent.'</div></figcaption>';
      $output .= '</figure>';
      $output .= '</li>';
      $slideNumber++;
    endforeach;
    wp_reset_postdata();
  }

  $output .= '</ul>
              </div>';

  if($bullets == 'yes') {
    $output .= '<nav class="orbit-bullets">';
    for ($i=0; $i < $slideNumber; $i++) {
      if($i==0) $output .= '<button class="is-active" data-slide="'.$i.'"></button>';
      else $output .= '<button data-slide="'.$i.'"></button>';
    }
    $output .= '</nav>';
  }

  $output .= '</div>';

  return $output;
}
