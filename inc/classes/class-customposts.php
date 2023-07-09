<?php
/**
 * Bootstraps the Theme.
 *
 * @package UnderstrapChild
 */

namespace UNDERSTRAP_THEME\Inc;

use UNDERSTRAP_THEME\Inc\Traits\Singleton;

class Customposts {

  use Singleton;

  protected function __construct() {
    
    $this->setup_hooks();
  }

  protected function setup_hooks() {
    
    /**
     * Actions.
     */
    add_action( 'init', [ $this, 'setup_posts_customer' ] );
    add_action( 'add_meta_boxes', [ $this, 'understrap_create_lang_mb' ] );
    add_action( 'save_post', [ $this, 'understrap_save_lang_mb' ], 1, 2 );
  }

  /**
   * Setup customer post type.
   *
   * @return void
   */
  public function setup_posts_customer() {

    register_post_type( 'customer',
      [
        'labels' => [
          'name' => __( 'Customer', 'uderstrap' ),
          'singular_name' => __( 'Customer', 'uderstrap' ),
          'add_new' => __( 'Add customer', 'uderstrap' ),
          'add_new_item' => __( 'Add customer', 'uderstrap' ),
          'edit_item' => __( 'Edit customer', 'uderstrap' ),
          'update_item' => __( 'Update customer', 'uderstrap' ),
          'search_items' => __( 'Search customer', 'uderstrap' ),
          'not_found' => __( 'No customer found', 'uderstrap' ),
          'not_found_in_trash'  => __( 'The trash is empty', 'uderstrap' ),
        ],
        'has_archive' => true,
        'public' => true,
        'rewrite' => ['slug' => 'customer'],
        'show_in_rest' => true,
        'supports' => [
          'title',
          'editor',
          'thumbnail',
          'revisions',
          'page-attributes',
        ],
        'rewrite' => true,
        'menu_icon' => 'dashicons-book',
      ]
    );


    // Register the columns.
    add_filter( "manage_customer_posts_columns", function ( $defaults ) {
      $defaults['logo'] = 'Logo';
      return $defaults;
    });

    // Handle the value for each of the new columns.
    add_action( "manage_customer_posts_custom_column", function ( $column_name, $post_id ) {
      
      //echo get_field( 'name', $post_id );
      if ( $column_name == 'logo' ) {
        if (has_post_thumbnail( $post_id ) ) {
          echo "<img width=\"100\" src=\"".wp_get_attachment_url( get_post_thumbnail_id($post_id), 'thumbnail' )."\">";
        } else {
          // Display empty image
          echo "<img width=\"100\" src=\"" . UNDERSTRAP_DIR_URI . "/assets/noimg.jpg\">";
        }
      }  
    }, 10, 2 );

  }

  /**
   * Create the metabox
   * @link https://developer.wordpress.org/reference/functions/add_meta_box/
   */
  public function understrap_create_lang_mb() {

    // Can only be used on a single post type (ie. page or post or a custom post type).
    // Must be repeated for each post type you want the metabox to appear on.
    add_meta_box(
      'understrap-lang-mb', // Metabox ID
      __( 'Languages', 'understrap' ), // Title to display
      [ $this, 'understrap_lang_mb_cb' ], // Function to call that contains the metabox content
      '', // Post type to display metabox on
      'side', // Where to put it (normal = main colum, side = sidebar, etc.)
      'default' // Priority relative to other metaboxes
    );

  }

  /**
   * Render the metabox markup
   * This is the function called in `understrap_lang_mb_cb()`
   */
  public function understrap_lang_mb_cb() {
    // Variables
    global $post; // Get the current post data
    $details = get_post_meta( $post->ID, 'understrap_lang', true ); // Get the saved values
    ?>

      <fieldset>
        <div>
          <?php
            // The `esc_attr()` function here escapes the data for
            // HTML attribute use to avoid unexpected issues
            $sel = esc_attr( $details ); 
          ?>
          <select name="understrap_lang" id="understrap_lang">
            <option value="it" <?=$sel == 'it' ? 'selected':'';?>><?php echo __( 'Italian', 'understrap' ); ?></option>
            <option value="en" <?=$sel == 'en' ? 'selected':'';?>><?php echo __( 'English', 'understrap' ); ?></option>
          </select>
        </div>
      </fieldset>

    <?php
    // Security field
    // This validates that submission came from the
    // actual dashboard and not the front end or
    // a remote server.
    wp_nonce_field( 'understrap_form_lang_mb_nonce', 'understrap_form_lang_mb_process' );
  }

  /**
   * Save the metabox
   * @param  Number $post_id The post ID
   * @param  Object $post The post data
   */
  public function understrap_save_lang_mb( $post_id, $post ) {

    // Verify that our security field exists. If not, bail.
    if ( ! isset( $_POST['understrap_form_lang_mb_process'] ) ) return;

    // Verify data came from edit/dashboard screen
    if ( ! wp_verify_nonce( $_POST['understrap_form_lang_mb_process'], 'understrap_form_lang_mb_nonce' ) ) {
      return $post->ID;
    }

    // Verify user has permission to edit post
    if ( ! current_user_can( 'edit_post', $post->ID )) {
      return $post->ID;
    }

    // Check that our custom fields are being passed along
    // This is the `name` value array. We can grab all
    // of the fields and their values at once.
    if ( ! isset( $_POST['understrap_lang'] ) ) {
      return $post->ID;
    }
    /**
     * Sanitize the submitted data
     * This keeps malicious code out of our database.
     * `wp_filter_post_kses` strips our dangerous server values
     * and allows through anything you can include a post.
     */
    $sanitized = wp_filter_post_kses( $_POST['understrap_lang'] );
    // Save our submissions to the database
    update_post_meta( $post->ID, 'understrap_lang', $sanitized );

  }

}