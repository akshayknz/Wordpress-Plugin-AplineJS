<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://akshaykn.vercel.app/
 * @since      1.0.0
 *
 * @package    Your_Space_Sms
 * @subpackage Your_Space_Sms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Your_Space_Sms
 * @subpackage Your_Space_Sms/admin
 * @author     Akshay <akshayakn6@gmail.com>
 */
class Your_Space_Sms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('add_meta_boxes_scheduledsms', array( $this, 'setup_scheduledsms_metaboxes' ));
		add_action( 'save_post_scheduledsms', array( $this, 'save_scheduledsms_metaboxes') );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Your_Space_Sms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Your_Space_Sms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/your-space-sms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Your_Space_Sms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Your_Space_Sms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/your-space-sms-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'apline-'.$this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/apline.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * From define_admin_hooks to render_admin_page
	 *
	 * @since    1.0.0
	 */
	public function ys_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=scheduledsms', 
			'Login with OTP', 'Login with OTP', 
			'manage_options', 'other-settings', array( $this, 'render_admin_subpage' ));
	}

	/**
	 * From ys_admin_menu to trekthehimalayas-admin-display.php
	 *
	 * @since    1.0.0
	 */
	public function render_admin_subpage() {
		require_once 'partials/your-space-sms-admin-subpage-display.php';
	}
	
	/**
	 * From define_admin_hooks to trekthehimalayas-admin-display.php
	 *
	 * @since    1.0.0
	 */
	public function create_scheduledsms_cpt() {
		/**
		 * Post Type: scheduledsms.
		 */
		register_post_type( "scheduledsms", [
			"label" => __( 'scheduledsms' ),
			"labels" => [
				"name" => __( 'Scheduled SMSs' ),
				"singular_name" => __( 'Scheduled SMS' )
			],
			"description" => "",
			"public" => false,
			"publicly_queryable" => false,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"rest_namespace" => "wp/v2",
			"has_archive" => false,
			'show_in_menu' => true,
			"show_in_nav_menus" => false,
			"delete_with_user" => false,
			"exclude_from_search" => true,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"can_export" => true,
			"rewrite" => [ "slug" => "", "with_front" => false ],
			"query_var" => true,
			"supports" => [ "title", "revisions" ],
			"show_in_graphql" => false,
		]);

	}

	/**
	 * New columns for scheduledsms CPT
	 * 
	 * @since    1.0.0
	 */
	public function scheduledsms_posts_columns( $columns )
	{
		$columns = array(
			'cb' => $columns['cb'],
			'title' => __( 'Title' ),
			'region' => __( 'Action' ),
			'status' => __( 'Body' ),
			'permalink' => __( 'To Agent' ),
			'date' => __( 'Date' ),
		);

		return $columns;
	}

	/**
	 * Column content for scheduledsms CPT
	 * 
	 * @since    1.0.0
	 */	
	public function scheduledsms_posts_column( $column, $post_id )
	{
		if ( 'region' === $column ) {
			echo 'Kerala';
		}
		if ( 'permalink' === $column ) {
			$base = get_the_permalink( $post_id, array(80, 80) ); 
			?>
				<a href="<?= $base; ?>" target="_blank">
					<?= basename($base); ?>
					<span class="dashicons dashicons-external"></span>
				</a>
			<?php
		}
		if ( 'status' === $column ) { 
			$live = get_post_status($post_id) == "publish"? true : false;
			?>
			<div class="wrapper">
				<div class="status-icon <?= $live? "live":"draft" ?>">
					<span class='dashicons dashicons-<?= $live? "yes-alt":"dismiss" ?>'></span>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * CPT column CSS styles
	 * 
	 * @since    1.0.0
	 */
	public function cpt_column_widths()
	{ ?>
		<style type="text/css">
			/**styles moved to admin\css\your-space-sms-admin.css */
		</style> <?php
	}

	/**
	 * CPT sortable columns
	 * 
	 * @since    1.0.0
	 */
	public function smashing_scheduledsms_sortable_columns( $columns )
	{
		$columns['status'] = 'status';
		$columns['region'] = 'region';
		$columns['permalink'] = 'permalink';
  		return $columns;
	}

	public function setup_scheduledsms_metaboxes(){
		add_meta_box(
			'scheduledsms_data_meta_box', 
			'Scheduled SMS settings', array($this,'render_sms_admin_meta_box'), 
			'scheduledsms', 'normal','high' );
		add_meta_box(
			'scheduledsms_preview_data_meta_box', 
			'SMS Preview', array($this,'render_sms_admin_preview_meta_box'), 
			'scheduledsms', 'normal','high' );
	}
	/**
	 * From ys_admin_menu to trekthehimalayas-admin-display.php
	 *
	 * @since    1.0.0
	 */
	public function render_sms_admin_meta_box() {
		require_once 'partials/your-space-sms-admin-display.php';
	}
	public function render_sms_admin_preview_meta_box() {
		require_once 'partials/your-space-sms-admin-preview-display.php';
	}

	public function save_scheduledsms_metaboxes( $post_id ) {
		if ( ! isset( $_POST[$this->plugin_name.'_scheduledsmss_meta_box_nonce'] ) ) {return;} //nounce is set
		if ( ! wp_verify_nonce( $_POST[$this->plugin_name.'_scheduledsmss_meta_box_nonce'], $this->plugin_name.'_scheduledsms_meta_box' ) ) {return;} //nonce is valid
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {return;} //dont save during autosave
		if ( ! current_user_can( 'edit_post', $post_id ) ) {return;} //check if user is supposed to save
		update_post_meta($post_id, $this->plugin_name.'-type',sanitize_text_field( $_POST[$this->plugin_name."-type"]));
		update_post_meta($post_id, $this->plugin_name.'-woo-action',sanitize_text_field( $_POST[$this->plugin_name."-woo-action"]));
		update_post_meta($post_id, $this->plugin_name.'-contactform-item',sanitize_text_field( $_POST[$this->plugin_name."-contactform-item"]));
		update_post_meta($post_id, $this->plugin_name.'-send-to',sanitize_text_field( $_POST[$this->plugin_name."-send-to"]));
		update_post_meta($post_id, $this->plugin_name.'-agent-phone',sanitize_text_field( $_POST[$this->plugin_name."-agent-phone"]));
		update_post_meta($post_id, $this->plugin_name.'-sms-body',wp_kses_post( $_POST[$this->plugin_name."-sms-body"]));
	}

}
