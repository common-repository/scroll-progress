<?php
/*
* Plugin Name: Scroll Progress
* Plugin URI: https://plugins.worbee.com/
* Description: Displays progress bar to indicate how far to scroll to reach bottom of the article. Useful for long content pages.
* Version: 1.3.2
* Domain Path: /languages
* Author: WorBee
* Author URI: https://plugins.worbee.com
* License: GPLv3
*/

add_action( 'wp', 'scroll_progress_plugin_init' );

function scroll_progress_plugin_add_script() {
	//css
	wp_enqueue_style( 'scroll_progress_plugin_rangeslider_css', plugins_url( '/assets/rangeslider.css', __FILE__ ), [],  $GLOBALS['scroll_progress_version']);
	wp_enqueue_style( 'scroll_progress_plugin_css', plugins_url( '/assets/style.css', __FILE__ ), [], $GLOBALS['scroll_progress_version'] );

	//js
	wp_enqueue_script( 'scroll_progress_plugin_rangeslider', plugins_url( '/assets/rangeslider.min.js', __FILE__ ), array( 'jquery' ), $GLOBALS['scroll_progress_version'] );
	wp_enqueue_script( 'scroll_progress_plugin_script', plugins_url( '/assets/script.js', __FILE__ ), array( 'jquery' ), $GLOBALS['scroll_progress_version'] );

	wp_localize_script( 'scroll_progress_plugin_rangeslider', 'scroll_progress_plugin_rangeslider_settings',
		array( get_option( 'scroll_progress_settings' ) ) );
}

function scroll_progress_plugin_init() {
	if ( is_single() || is_page() || is_singular() ) {
		add_action( 'wp_enqueue_scripts', 'scroll_progress_plugin_add_script' );
	}
}

add_action( 'admin_menu', 'scroll_progress_add_admin_menu' );
add_action( 'admin_init', 'scroll_progress_settings_init' );


function scroll_progress_add_admin_menu() {

	add_options_page( 'Scroll Progress', 'Scroll Progress', 'manage_options', 'scroll_progress', 'scroll_progress_options_page' );

}


function scroll_progress_settings_init() {

	register_setting( 'pluginPage', 'scroll_progress_settings' );


  add_settings_section(
    'scroll_progress_pluginPage_section0',
    __( 'Info', 'scroll-progress' ),
    'scroll_progress_settings_section_callback0',
    'pluginPage'
  );


  add_settings_section(
		'scroll_progress_pluginPage_section',
		__( 'Settings', 'scroll-progress' ),
		'scroll_progress_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'scroll_progress_bar_color',
		__( 'Bar color (default: #e6e6e6)', 'scroll-progress' ),
		'scroll_progress_bar_color_render',
		'pluginPage',
		'scroll_progress_pluginPage_section'
	);

	add_settings_field(
		'scroll_progress_scrolled_color',
		__( 'Scrolled color (default: #009900)', 'scroll-progress' ),
		'scroll_progress_scrolled_color_render',
		'pluginPage',
		'scroll_progress_pluginPage_section'
	);

  add_settings_field(
    'scroll_progress_indicator_show',
    __( 'Show big progress indicator circle? (default: no)', 'scroll-progress' ),
    'scroll_progress_indicator_show_render',
    'pluginPage',
    'scroll_progress_pluginPage_section'
  );

  add_settings_field(
    'scroll_progress_position_top',
    __( 'Move scroll progress to the top? (default: bottom)', 'scroll-progress' ),
    'scroll_progress_position_top_render',
    'pluginPage',
    'scroll_progress_pluginPage_section'
  );
}


function scroll_progress_bar_color_render() {
	$options = get_option( 'scroll_progress_settings' );
	?>
  <input type='text' name='scroll_progress_settings[scroll_progress_bar_color]'
         value='<?php echo $options['scroll_progress_bar_color']; ?>'>
	<?php
}


function scroll_progress_scrolled_color_render() {
	$options = get_option( 'scroll_progress_settings' );
	?>
  <input type='text' name='scroll_progress_settings[scroll_progress_scrolled_color]'
         value='<?php echo $options['scroll_progress_scrolled_color']; ?>'>
	<?php
}

function scroll_progress_indicator_show_render() {
  $options = get_option( 'scroll_progress_settings' );
  $checked = false;
  if($options['scroll_progress_indicator_show']) {
      $checked = 'checked';
  }
  ?>
    <input type='checkbox'
           name='scroll_progress_settings[scroll_progress_indicator_show]'
           <?php echo $checked;?>
           value='1'>
  <?php
}

function scroll_progress_position_top_render() {
  $options = get_option( 'scroll_progress_settings' );
  $checked = false;
  if($options['scroll_progress_position_top']) {
    $checked = 'checked';
  }
  ?>
    <input type='checkbox'
           name='scroll_progress_settings[scroll_progress_position_top]'
           <?php echo $checked;?>
           value='1'>
  <?php
}


function scroll_progress_settings_section_callback() {
	echo __( "Customize Progress slider", 'scroll-progress' );
}

function scroll_progress_settings_section_callback0() {
  echo __( "This plugin is made by", 'scroll-progress' ) . ' <a href="https://worbee.com/">WorBee</a>.';
}


function scroll_progress_options_page() {
	?>
  <form action='options.php' method='post'>

    <h2>Scroll Progress</h2>

	  <?php
	  settings_fields( 'pluginPage' );
	  do_settings_sections( 'pluginPage' );
	  submit_button();
	  ?>

  </form>
	<?php
}
