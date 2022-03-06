<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://timmermarketing.com
 * @since      1.0.0
 *
 * @package    Wpabl_import
 * @subpackage Wpabl_import/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wpabl_import
 * @subpackage Wpabl_import/includes
 * @author     Jahur Ahmed <jahur@timmermarketing.com>
 */
class Wpabl_import {
    
    /**
	 * The constants loads all constants
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpabl_import_Constants    $constants.
	 */
	//protected $constants;
	
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpabl_import_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $settings_options;
	protected $settings_fields;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WPABL_IMPORT_VERSION' ) ) {
			$this->version = WPABL_IMPORT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wpabl_import';

		$this->settings_options = $this->wp_settings_options();
		$this->settings_fields = $this->wp_settings_fields();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpabl_import_Loader. Orchestrates the hooks of the plugin.
	 * - Wpabl_import_i18n. Defines internationalization functionality.
	 * - Wpabl_import_Admin. Defines all hooks for the admin area.
	 * - Wpabl_import_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
	    
	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpabl_import-constants.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpabl_import-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpabl_import-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/class-wpabl_import-post-type.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings-api/class-hd-wp-settings-api.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpabl_import-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metabox-api/class-hd-wp-metabox-api.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/class-wpabl_import-xml-process.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/class-wpabl_import-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'frontend/class-wpabl_import-public.php';
		
		
		//$this->constants = new Wpabl_import_Constants();

		$this->loader = new Wpabl_import_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpabl_import_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpabl_import_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wpabl_import_Admin( $this->get_plugin_name(), $this->get_version() );

		$wpabl_metabox = new HD_WP_Metabox_API( $this->cpt_metabox_options(), $this->cpt_metabox_fields() );
		$plugin_post_type = new Wpabl_import_Post_Type( $this->get_plugin_name(), $this->get_version() );
		$plugin_functions = new Wpabl_import_Functions( $this->get_plugin_name(), $this->get_version() );
		//
		//$plugin_admin1 = new Wpabl_import_Post_Type( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//$this->loader->add_action( 'init', $plugin_admin, 'load_all_other_admin_files' );
		
		$this->loader->add_action( 'init', $plugin_post_type, 'register_property_post_type' );

		$wpabl_settings = new HD_WP_Settings_API( $this->settings_options, $this->settings_fields );
		
		//add_action('init', '');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wpabl_import_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpabl_import_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	
	public function wp_settings_options() {
		$options = array(
			'page_title'  => 'WPABL Settings',
			'menu_title'  => 'WPABL Settings',
			'menu_slug'   => 'wpabl_settings',
			'capability'  => 'manage_options',
			'icon'        => 'dashicons-admin-generic',
			'position'    => 61
		);
		return $options;
	}
	public function wp_settings_fields() {
		$fields = array(
			/*'hd_text_setting' => array(
				'title'   => 'Text Input',
				'type'    => 'text',
				'default' => 'Hello World!',
				'desc'    => 'Example Text Input',
				'sanit'   => 'nohtml',
			),
			'hd_textarea_setting' => array(
				'title'   => 'Textarea Input',
				'type'    => 'textarea',
				'default' => 'Hello World!',
				'desc'    => 'Example Textarea Input',
				'sanit'   => 'nohtml',
			),
			'hd_section_1' => array(
				'title'   => 'Example Section',
				'type'    => 'section',
				'desc'    => 'Section Description goes here',
			),
			'hd_checkbox_setting' => array(
				'title'   => 'Checkbox Input',
				'type'    => 'checkbox',
				'default' => 1,
				'desc'    => 'Example Checkbox Input',
				'sanit'   => 'nohtml',
			),*/
			'hd_integration_type' => array(
				'title'   => 'Choose how you want to integrate this plugin',
				'type'    => 'radio',
				'default' => 'one',
				'choices' => array(
					'plugin_cpt'   => 'with ABProperty',
					'other_cpt'   => 'with existing custom post types'
				),
				'desc'    => 'Example Radio Input',
				'sanit'   => 'nohtml',
			),
			'hd_post_types_dropdpwn' => array(
				'title'   => 'Enter Post Type',
				'type'    => 'text',
				'desc'    => 'Example Select Input',
				'sanit'   => 'nohtml',
			),
			'hd_section_1' => array(
				'title'   => 'Map CPT',
				'type'    => 'section',
				'desc'    => 'Section Description goes here',
			),
			'hd_modTime' => array(
				'title'   => 'modTime',
				'type'    => 'text',
				'desc'    => 'modTime',
				'sanit'   => 'nohtml',
			),
			'hd_status' => array(
				'title'   => 'status',
				'type'    => 'text',
				'desc'    => 'status',
				'sanit'   => 'nohtml',
			),
			'hd_agentID' => array(
				'title'   => 'agentID',
				'type'    => 'text',
				'desc'    => 'agentID',
				'sanit'   => 'nohtml',
			),
			'hd_uniqueID' => array(
				'title'   => 'uniqueID',
				'type'    => 'text',
				'desc'    => 'uniqueID',
				'sanit'   => 'nohtml',
			),
			'hd_soldPrice' => array(
				'title'   => 'soldPrice',
				'type'    => 'text',
				'desc'    => 'soldPrice',
				'sanit'   => 'nohtml',
			),
			'hd_soldDate' => array(
				'title'   => 'soldDate',
				'type'    => 'text',
				'desc'    => 'soldDate',
				'sanit'   => 'nohtml',
			),
			'hd_newConstruction' => array(
				'title'   => 'newConstruction',
				'type'    => 'text',
				'desc'    => 'newConstruction',
				'sanit'   => 'nohtml',
			),
			'hd_tenancy' => array(
				'title'   => 'tenancy',
				'type'    => 'text',
				'desc'    => 'tenancy',
				'sanit'   => 'nohtml',
			),
			'hd_authority' => array(
				'title'   => 'authority',
				'type'    => 'text',
				'desc'    => 'authority',
				'sanit'   => 'nohtml',
			),
			'hd_price' => array(
				'title'   => 'price',
				'type'    => 'text',
				'desc'    => 'price',
				'sanit'   => 'nohtml',
			),
			'hd_priceView' => array(
				'title'   => 'priceView',
				'type'    => 'text',
				'desc'    => 'priceView',
				'sanit'   => 'nohtml',
			),
			'hd_underOffer' => array(
				'title'   => 'underOffer',
				'type'    => 'text',
				'desc'    => 'underOffer',
				'sanit'   => 'nohtml',
			),
			'hd_exclusivity' => array(
				'title'   => 'exclusivity',
				'type'    => 'text',
				'desc'    => 'exclusivity',
				'sanit'   => 'nohtml',
			),
			'hd_councilRates' => array(
				'title'   => 'councilRates',
				'type'    => 'text',
				'desc'    => 'councilRates',
				'sanit'   => 'nohtml',
			),
			'hd_outgoings' => array(
				'title'   => 'outgoings',
				'type'    => 'text',
				'desc'    => 'outgoings',
				'sanit'   => 'nohtml',
			),
			'hd_landDetailsArea' => array(
				'title'   => 'landDetailsArea',
				'type'    => 'text',
				'desc'    => 'landDetailsArea',
				'sanit'   => 'nohtml',
			),
			'hd_landDetailsFrontage' => array(
				'title'   => 'landDetailsFrontage',
				'type'    => 'text',
				'desc'    => 'landDetailsFrontage',
				'sanit'   => 'nohtml',
			),
			'hd_listingAgents' => array(
				'title'   => 'listingAgents',
				'type'    => 'text',
				'desc'    => 'listingAgents',
				'sanit'   => 'nohtml',
			),
			'hd_address' => array(
				'title'   => 'address',
				'type'    => 'text',
				'desc'    => 'address',
				'sanit'   => 'nohtml',
			),
			'hd_categoryName' => array(
				'title'   => 'categoryName',
				'type'    => 'text',
				'desc'    => 'categoryName',
				'sanit'   => 'nohtml',
			),
			'hd_features' => array(
				'title'   => 'features',
				'type'    => 'textarea',
				'desc'    => 'features',
				'sanit'   => 'nohtml',
			),
			'hd_headline' => array(
				'title'   => 'headline',
				'type'    => 'text',
				'desc'    => 'headline',
				'sanit'   => 'nohtml',
			),
			'hd_externalLinkHref' => array(
				'title'   => 'externalLinkHref',
				'type'    => 'text',
				'desc'    => 'externalLinkHref',
				'sanit'   => 'nohtml',
			),
			'hd_videoLinkHref' => array(
				'title'   => 'videoLinkHref',
				'type'    => 'text',
				'desc'    => 'videoLinkHref',
				'sanit'   => 'nohtml',
			),
			'hd_objectsImgNew' => array(
				'title'   => 'objectsImgNew',
				'type'    => 'textarea',
				'desc'    => 'objectsImgNew',
				'sanit'   => 'nohtml',
			),
			'hd_objectsFloorplanNew' => array(
				'title'   => 'objectsFloorplanNew',
				'type'    => 'textarea',
				'desc'    => 'objectsFloorplanNew',
				'sanit'   => 'nohtml',
			),
			'hd_extraFields' => array(
				'title'   => 'extraFields',
				'type'    => 'textarea',
				'desc'    => 'extraFields',
				'sanit'   => 'nohtml',
			),
		);
		return $fields;
	}

	public function cpt_metabox_options(){
		$options = array(
			'metabox_id'    => 'wpabl_metabox',
			'metabox_title' => 'WPABL Info',
			'metabox_classes' => '',
			'post_type'     => array( 'abproperty' ),
			'context'       => 'normal',
			'priority'      => 'high',
		);

		return $options;
	}
	public function cpt_metabox_fields(){
		$fields = array(
			'wpabl_agent_id' => array(
				'title'   => 'Agent ID',
				'type'    => 'text',
				'desc'    => '',
				'sanit'   => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_unique_id' => array(
				'title'   => 'Unique ID',
				'type'    => 'text',
				'desc'    => '',
				'sanit'   => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_is_multiple' => array(
				'title' => 'Is Multiple',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_sold_details_section_title' => array(
				'title' => 'Sold Details',
				'type' => 'section',
				'sanit'   => 'nohtml',
			),
			'wpabl_sold_price' => array(
				'title' => 'Sold Price',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_sold_date' => array(
				'title' => 'Sold Date',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_new_construction' => array(
				'title'   => 'New construction?',
				'type'    => 'text',
				'desc'    => '',
				'sanit'   => 'nohtml',
				'classes' => 'wpabl-col-1-1-lg float-left',
			),
			'wpabl_tenancy' => array(
				'title' => 'Tenancy',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_authority' => array(
				'title' => 'Authority',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_price' => array(
				'title' => 'Price',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_price_view' => array(
				'title' => 'Price view',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_under_offer' => array(
				'title' => 'Under offer',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_exclusivity' => array(
				'title' => 'Exclusivity',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_council_rates' => array(
				'title' => 'Council rates',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_outgoings' => array(
				'title' => 'Outgoings',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_land_details_title' => array(
				'title' => 'Land details',
				'type' => 'section',
				'sanit'   => 'nohtml'
			),
			'wpabl_area' => array(
				'title' => 'Area',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_frontage' => array(
				'title' => 'Frontage',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_building_details_title' => array(
				'title' => 'Building details',
				'type' => 'section',
				'sanit'   => 'nohtml'
			),
			'wpabl_energy_rating' => array(
				'title' => 'Energy rating',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_address_title' => array(
				'title' => 'Address',
				'type' => 'section',
				'sanit'   => 'nohtml'
			),
			'wpabl_sub_number' => array(
				'title' => 'Sub number',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_lot_number' => array(
				'title' => 'Lot number',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_street_number' => array(
				'title' => 'Street number',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_street' => array(
				'title' => 'Street',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_suburb' => array(
				'title' => 'Suburb',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_state' => array(
				'title' => 'State',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_country' => array(
				'title' => 'Country',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_post_code' => array(
				'title' => 'Post code',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-3-lg float-left',
			),
			'wpabl_features_title' => array(
				'title' => 'Features',
				'type' => 'section',
				'sanit'   => 'nohtml',
			),
			'wpabl_open_spaces' => array(
				'title' => 'Open spaces',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_other_features' => array(
				'title' => 'Other features',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_headline' => array(
				'title' => 'Headline',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_inspection_times' => array(
				'title' => 'Inspection times',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_external_link' => array(
				'title' => 'External link',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_video_link' => array(
				'title' => 'Video link',
				'type' => 'text',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
			'wpabl_extra_fields' => array(
				'title' => 'Extra fields',
				'type' => 'textarea',
				'desc' => '',
				'saint' => 'nohtml',
				'classes' => 'wpabl-col-1-2-lg float-left',
			),
		
		);

		return $fields;
	}
}
