<?php
/**
 * Enqueue theme assets
 *
 * @package UnderstrapChild
 */

namespace UNDERSTRAP_THEME\Inc;

use UNDERSTRAP_THEME\Inc\Traits\Singleton;

class Assets {
  
  use Singleton;

  protected function __construct() {

    // load class.
    $this->setup_hooks();
  }

  protected function setup_hooks() {

    /**
     * Actions.
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'remove_parent_script_style' ], 20 );
    add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
    add_action( 'customize_controls_enqueue_scripts', [ $this, 'understrap_child_customize_controls_js' ] );
    add_action( 'login_head', [ $this, 'understrap_logo' ] );
    
    /**
     * The 'enqueue_block_assets' hook includes styles and scripts both in editor and frontend,
     * except when is_admin() is used to include them conditionally
     */
    add_action( 'enqueue_block_assets', [ $this, 'enqueue_editor_assets' ] );
  }

  /**
   * Get current theme version.
   *
   * @return string
   */
  public function get_theme_version() {
    return wp_get_theme()->get( 'Version' );
  }

  /**
   * Register parent styles.
   *
   * @return void
   */
  public function register_styles() {

    $script = "/css/child-theme".$this->getSuffix().".css";
    $version = $this->get_theme_version() . '.' . filemtime( UNDERSTRAP_DIR_PATH . $script );

    // Register styles.
    wp_register_style( 'slick-css', UNDERSTRAP_DIR_URI . '/assets/library/slick/slick.css', [], false );
    wp_register_style( 'slick-theme-css', UNDERSTRAP_DIR_URI . '/assets/library/slick/slick-theme.css', ['slick-css'], false );
    wp_register_style( 'child-understrap-styles', UNDERSTRAP_DIR_URI . $script, [], $version );

    // Enqueue Styles.
    wp_enqueue_style( 'slick-css' );
    wp_enqueue_style( 'slick-theme-css' );
    wp_enqueue_style( 'child-understrap-styles' );
  }

  /**
   * Register parent scripts.
   *
   * @return void
   */
  public function register_scripts() {

    $script = "/js/child-theme".$this->getSuffix().".js";
    $version = $this->get_theme_version() . '.' . filemtime( UNDERSTRAP_DIR_PATH . $script );

    // Register scripts.
    wp_register_script( 'slick-js', UNDERSTRAP_DIR_URI . '/assets/library/slick/slick.min.js', ['jquery'], false, true );
    wp_register_script( 'child-understrap-scripts', UNDERSTRAP_DIR_URI . $script, ['jquery', 'slick-js'], $version, true );

    // Enqueue Scripts.
    wp_enqueue_script( 'slick-js' );
    wp_enqueue_script( 'child-understrap-scripts' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }

  }

  /**
   * Enqueue editor scripts and styles.
   */
  public function enqueue_editor_assets() {
  }

  /**
   * Deregister parent scripts.
   *
   * @return void
   */
  public function remove_parent_script_style() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
  }

  /**
   * Loads javascript for showing customizer warning dialog.
   */
  public function understrap_child_customize_controls_js() {

    $script = "/js/customizer-controls.js";
    $version = $this->get_theme_version() . '.' . filemtime( UNDERSTRAP_DIR_PATH . $script );

    wp_enqueue_script(
      'understrap_child_customizer',
      get_stylesheet_directory_uri() . '/js/customizer-controls.js',
      array( 'customize-preview' ),
      $version,
      true
    );
  }

  /**
   *  Check if debug mode is active
   * 
   * @return string
   */
  private function getSuffix() {
    return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
  }

  /**
   * Check if there is custom logo
   * 
   */
  public function understrap_logo() {
    
    if( has_custom_logo() ) {
      echo '
      <style type="text/css">
          h1 a { background-image:url('. esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) ) .') !important; width: 300px !important; background-size: cover !important; }
      </style>';
    }

  }

}