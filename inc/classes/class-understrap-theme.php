<?php
/**
 * Bootstraps the Theme.
 *
 * @package UnderstrapChild
 */

namespace UNDERSTRAP_THEME\Inc;

use UNDERSTRAP_THEME\Inc\Traits\Singleton;

class UNDERSTRAP_THEME {

  use Singleton;

  protected function __construct() {

    // Load class.
    Assets::get_instance();
    Customposts::get_instance();
    Block_Patterns::get_instance();
    
    $this->setup_hooks();
  }

  protected function setup_hooks() {
    
    /**
     * Actions.
     */
    add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
  }

  /**
   * Setup theme.
   *
   * @return void
   */
  public function setup_theme() {

    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );

    /**
     * Set the maximum allowed width for any content in the theme,
     * like oEmbeds and images added to posts
     *
     * @see Content Width
     * @link https://codex.wordpress.org/Content_Width
     */
    global $content_width;
    if ( ! isset( $content_width ) ) {
      $content_width = 1240;
    }
  }

}