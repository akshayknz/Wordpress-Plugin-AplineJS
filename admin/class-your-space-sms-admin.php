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
		wp_enqueue_script( 
			'apline-'.$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/apline.js', 
			array( 'jquery' ), $this->version, false );
		

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
			.posts .column-region { width:9%; }
			.posts .column-status { width:9%; }
			.posts .column-permalink { width:18%; }
			.posts .column-permalink a {
				display: flex;
			}
			.posts .column-permalink .dashicons { 
				font-size:15px;
				display: flex;
				align-items: center;
				justify-content: space-around;
				opacity: .8;
			}
			.posts .column-status .wrapper{
				width:100%;
				display:flex;
				margin:2% 0 0 10%;
				display: flex;
				align-items: center;
			}
			.posts .column-status .wrapper .status-icon{
				border-radius:10px;
			}
			.posts .column-status .wrapper .status-icon.live{
				color:#3bd33b;
			}
			.posts .column-status .wrapper .status-icon.draft{
				color:#ff2f2f;
			}
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

	/**
	 * New taxonomies for all the custom functionalitites 
	 * 
	 * @since    1.0.0
	 */
	public function add_scheduledsms_taxonomies()
	{
		
	}

	public function setup_scheduledsms_metaboxes(){
		add_meta_box(
			'scheduledsms_data_meta_box', 
			'Meta Box Data', array($this,'render_admin_page'), 
			'scheduledsms', 'normal','high' );
	}
	/**
	 * From ys_admin_menu to trekthehimalayas-admin-display.php
	 *
	 * @since    1.0.0
	 */
	public function render_admin_page() {
		require_once 'partials/your-space-sms-admin-display.php';
	}
	public function scheduledsms_data_meta_box($post){
		// Add a nonce field so we can check for it later.
		wp_nonce_field( $this->plugin_name.'_affiliate_meta_box', $this->plugin_name.'_affiliates_meta_box_nonce' );

		echo '<div class="post_type_field_containers">';
		echo '<ul class="plugin_name_product_data_metabox">';
	
		echo '<li><label for="'.$this->plugin_name.'_company_name">';
		_e( 'Company Name', $this->plugin_name.'_company_name' );
		echo '</label>';
		$args = array (
	              'type'      => 'input',
				  'subtype'	  => 'text',
				  'id'	  => $this->plugin_name.'_company_name',
				  'name'	  => $this->plugin_name.'_company_name',
				  'required' => '',
				  'get_options_list' => '',
				  'value_type'=>'normal',
				  'wp_data' => 'post_meta',
				  'post_id'=> $post->ID
	          );
			  // this gets the post_meta value and echos back the input
		$this->plugin_name_render_settings_field($args);
		echo '</li><li><label for="'.$this->plugin_name.'_fullname">';
		_e( 'Full Name', $this->plugin_name.'_fullname' );
		echo '</label>';
		$args = array (
	              'type'      => 'input',
				  'subtype'	  => 'text',
				  'id'	  => $this->plugin_name.'_fullname',
				  'name'	  => $this->plugin_name.'_fullname',
				  'required' => '',
				  'get_options_list' => '',
				  'value_type'=>'normal',
				  'wp_data' => 'post_meta',
				  'post_id'=> $post->ID
	          );
			  // this gets the post_meta value and echos back the input
		$this->plugin_name_render_settings_field($args);
		echo '</li><li><label for="'.$this->plugin_name.'_email_address">';
		_e( 'Email Address', $this->plugin_name.'_email_address' );
		echo '</label>';
		unset($args);
	  	$args = array (
	              'type'      => 'input',
				  'subtype'	  => 'text',
				  'id'	  => $this->plugin_name.'_email_address',
				  'name'	  => $this->plugin_name.'_email_address',
				  'required' => '',
				  'get_options_list' => '',
				  'value_type'=>'normal',
				  'wp_data' => 'post_meta',
				  'post_id'=> $post->ID
	          );
		// this gets the post_meta value and echos back the input
		$this->plugin_name_render_settings_field($args);
		echo '</li><li><label for="'.$this->plugin_name.'_phone_number">';
		_e( 'Phone Number', $this->plugin_name.'_phone_number' );
		echo '</label>';
		unset($args);
	  	$args = array (
	              'type'      => 'input',
				  'subtype'	  => 'text',
				  'id'	  => $this->plugin_name.'_phone_number',
				  'name'	  => $this->plugin_name.'_phone_number',
				  'required' => '',
				  'get_options_list' => '',
				  'value_type'=>'normal',
				  'wp_data' => 'post_meta',
				  'post_id'=> $post->ID
	          );
		// this gets the post_meta value and echos back the input
		$this->plugin_name_render_settings_field($args);
		echo '</li>';
		// provide textarea name for $_POST variable
		$notes = get_post_meta( $post->ID, $this->plugin_name.'_notes', true );
		
		$args = array(
		'textarea_name' => $this->plugin_name.'_notes',
		); 
		echo '<li><label for="'.$this->plugin_name.'_notes">';
				_e( 'Notes', $this->plugin_name.'_notes' );
				echo '</label>';
		wp_editor( $notes, $this->plugin_name.'_notes_editor',$args); 
		echo '</li></ul></div>';
	
	}
	
	public function plugin_name_render_settings_field($args) {
		if($args['wp_data'] == 'option'){
			$wp_data_value = get_option($args['name']);
		} elseif($args['wp_data'] == 'post_meta'){
			$wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}
		
		switch ($args['type']) {
			case 'input':
				$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
				if($args['subtype'] != 'checkbox'){
					$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
					$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
					$step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
					$min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
					$max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
					if(isset($args['disabled'])){
						// hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
						echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					} else {
						echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					}
					/*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/
					
				} else {
					$checked = ($value) ? 'checked' : '';
					echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
				}
				break;
			default:
				# code...
				break;
		}
	}

}
