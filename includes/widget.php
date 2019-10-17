<?php

// Register and load the widget
function my_slider_load_widget() {
  register_widget( 'my_slider_widget' );
}
add_action( 'widgets_init', 'my_slider_load_widget' );

// Creating the widget
class my_slider_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'my_slider_widget',

      // Widget name will appear in UI
      __('My Slider Widget', 'my-slider'),

      // Widget description
      array( 'description' => __( 'Slide widget', 'my-slider' ), )
    );
  }

  // Creating widget front-end

  public function widget($args, $instance) {
    $title = apply_filters( 'widget_title', $instance['title'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    echo my_slider_get_slider($instance['bullets'], $instance['nav_buttons'], $instance['timer'], $instance['animation'], $instance['number'], $instance['image_style']);
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form($instance) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
      $bullets = $instance[ 'bullets' ];
      $navButtons = $instance[ 'nav_buttons' ];
      $timer = $instance[ 'timer' ];
      $animation = $instance[ 'animation' ];
      $number = $instance[ 'number' ];
      $imageStyle = $instance[ 'image_style' ];
      $pause = $instance[ 'pause_on_hover' ];
    } else {
      $title = __( 'Slider', 'my-slider' );
      $bullets = 'yes';
      $navButtons = 'yes';
      $timer = '5000';
      $animation = 'fade';
      $number = -1;
      $imageStyle = 'large';
      $pause = 'yes';
    }
    // Widget admin form
    echo '<p>
    <label for="'.$this->get_field_id( 'title' ).'">'.__( 'Title:' ).'</label>
    <input class="widefat" id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" type="text" value="'.esc_attr( $title ).'" />
    </p>
    <p>
    <label for="'.$this->get_field_id( 'bullets' ).'">'.__( 'Show Bullets under slider:', 'my-slider' ).'</label>
    <input type="checkbox" class="widefat" id="'.$this->get_field_id( 'bullets' ).'" name="'.$this->get_field_name( 'bullets' ).'" value="yes"';
    if(esc_attr($bullets)=='yes') echo ' checked';
    echo '>
    </p>
    <p>
    <label for="'.$this->get_field_id( 'timer' ).'">'.__( 'Number of slider:', 'my-slider' ).'</label>
    <input class="widefat" id="'.$this->get_field_id( 'timer' ).'" name="'.$this->get_field_name( 'timer' ).'" type="number" value="'.esc_attr( $timer ).'" />
    </p>
    <p>
    <label for="'.$this->get_field_id( 'nav_buttons' ).'">'.__( 'Navigation buttons:', 'my-slider' ).'</label>
    <input type="checkbox" class="widefat" id="'.$this->get_field_id( 'nav_buttons' ).'" name="'.$this->get_field_name( 'nav_buttons' ).'" value="yes"';
    if(esc_attr($navButtons)=='yes') echo ' checked';
    echo '>
    </p>
    <p>
    <label for="'.$this->get_field_id( 'animation' ).'">'.__( 'Animation:', 'my-slider' ).'</label>';
    echo '<select class="widefat" id="'.$this->get_field_id( 'animation' ).'" name="'.$this->get_field_name( 'animation' ).'">';
      echo '<option value="fade"';
      if('fade' == esc_attr($animation)) echo ' selected';
      echo '>Fade</option>';
      echo '<option value="slide-left"';
      if('slide-left' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Slide From Left', 'my-slider').'</option>';
      echo '<option value="slide-right"';
      if('slide-right' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Slide From Right', 'my-slider').'</option>';
      echo '<option value="slide-up"';
      if('slide-up' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Slide From Up', 'my-slider').'</option>';
      echo '<option value="slide-down"';
      if('slide-down' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Slide From Down', 'my-slider').'</option>';
      echo '<option value="hinge-left"';
      if('hinge-left' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Left', 'my-slider').'</option>';
      echo '<option value="hinge-right"';
      if('hinge-right' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Right', 'my-slider').'</option>';
      echo '<option value="hinge-top"';
      if('hinge-top' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Top', 'my-slider').'</option>';
      echo '<option value="hinge-bottom"';
      if('hinge-bottom' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Bottom', 'my-slider').'</option>';
      echo '<option value="hinge-middle-x"';
      if('hinge-middle-x' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Middle X', 'my-slider').'</option>';
      echo '<option value="hinge-middle-y"';
      if('hinge-middle-y' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Hinge From Middle Y', 'my-slider').'</option>';
      echo '<option value="scale-in"';
      if('scale-in' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Scale In', 'my-slider').'</option>';
      echo '<option value="scale-out"';
      if('scale-out' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Scale Out', 'my-slider').'</option>';
      echo '<option value="spin"';
      if('spin' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Spin', 'my-slider').'</option>';
      echo '<option value="spin"-ccw';
      if('spin-ccw' == esc_attr($animation)) echo ' selected';
      echo '>'.__('Spin Counter Clockwise', 'my-slider').'</option>';
    echo '</select>
    </p>
    <p>
    <label for="'.$this->get_field_id( 'number' ).'">'.__( 'Number of slides:', 'my-slider' ).'</label>
    <input class="widefat" id="'.$this->get_field_id( 'number' ).'" name="'.$this->get_field_name( 'number' ).'" type="number" value="'.esc_attr( $number ).'" />
    </p>
    <p>
    <label for="'.$this->get_field_id( 'image_style' ).'">'.__( 'Image Style:', 'my-slider' ).'</label>';
    $imageStyles = my_slider_get_all_image_sizes();
    echo '<select class="widefat" id="'.$this->get_field_id( 'image_style' ).'" name="'.$this->get_field_name( 'image_style' ).'">';
    foreach ($imageStyles as $key => $value) {
      echo '<option value="'.$key.'"';
      if($key == esc_attr($imageStyle)) echo ' selected';
      echo '>'.$key.'</option>';
    }
    echo '</select>
    </p>
    <p>
    <label for="'.$this->get_field_id( 'pause_on_hover' ).'">'.__( 'Pause on hover:', 'my-slider' ).'</label>
    <input type="checkbox" class="widefat" id="'.$this->get_field_id( 'pause_on_hover' ).'" name="'.$this->get_field_name( 'pause_on_hover' ).'" value="yes"';
    if(esc_attr($pause)=='yes') echo ' checked';
    echo '>
    </p>';
  }

  // Updating widget replacing old instances with new
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['bullets'] = ( ! empty( $new_instance['bullets'] ) ) ? strip_tags( $new_instance['bullets'] ) : '';
    $instance['nav_buttons'] = ( ! empty( $new_instance['nav_buttons'] ) ) ? strip_tags( $new_instance['nav_buttons'] ) : '';
    $instance['timer'] = ( ! empty( $new_instance['timer'] ) ) ? strip_tags( $new_instance['timer'] ) : '';
    $instance['animation'] = ( ! empty( $new_instance['animation'] ) ) ? strip_tags( $new_instance['animation'] ) : '';
    $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
    $instance['image_style'] = ( ! empty( $new_instance['image_style'] ) ) ? strip_tags( $new_instance['image_style'] ) : '';
    $instance['pause_on_hover'] = ( ! empty( $new_instance['pause_on_hover'] ) ) ? strip_tags( $new_instance['pause_on_hover'] ) : '';

    return $instance;
  }
} // Class my_slider_widget ends here
