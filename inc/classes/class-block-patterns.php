<?php
/**
 * Block Patterns
 *
 * @package Understrap
 */

namespace UNDERSTRAP_THEME\Inc;

use UNDERSTRAP_THEME\Inc\Traits\Singleton;

class Block_Patterns {

  use Singleton;

  protected function __construct() {

    // load class.
    $this->setup_hooks();
  }

  protected function setup_hooks() {

    /**
     * Actions.
     */
    add_action( 'init', [ $this, 'register_block_patterns' ] );
    add_action( 'init', [ $this, 'register_block_pattern_categories' ] );
  }

  public function register_block_patterns() {
    if ( function_exists( 'register_block_pattern' ) ) {

      /**
       * Customer carousel Pattern
       */
      $carousel_content = $this->get_pattern_content( 'template-parts/components/post-carousel' );

      register_block_pattern(
        'underscore/customercarousel',
        [
          'title' => __( 'Customer carousel', 'understrap' ),
          'description' => __( 'Customer carousel', 'understrap' ),
          'categories' => [ 'carousel' ],
          'content' => $carousel_content,
        ]
      );
    }
  }

  public function get_pattern_content( $template_path ) {

    ob_start();
    get_template_part( $template_path );
    $pattern_content = ob_get_contents();
    ob_end_clean();
    return $pattern_content;
  }

  public function register_block_pattern_categories() {

    $pattern_categories = [
      'cover' => __( 'Carousel', 'understrap' ),
    ];

    if ( ! empty( $pattern_categories ) && is_array( $pattern_categories ) ) {
      foreach ( $pattern_categories as $pattern_category => $pattern_category_label ) {
        register_block_pattern_category(
          $pattern_category,
          [ 'label' => $pattern_category_label ]
        );
      }
    }
  }


}