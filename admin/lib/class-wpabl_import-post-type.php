<?php

class Wpabl_import_Post_Type{
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

	}

    public function register_property_post_type(){
        $labels = array(
            'name'                  => _x( 'ABProperty', 'wpabl-import' ),
            'singular_name'         => _x( 'ABProperty', 'wpabl-import' ),
            'add_new'               => __( 'Add New', 'wpabl-import' ),
            'add_new_item'          => __( 'Add New ABProperty', 'wpabl-import' ),
            'edit_item'             => __( 'Edit ABProperty', 'wpabl-import' ),
        );     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'rewrite'            => array( 'slug' => 'property' ),
            'has_archive'        => true,
            'menu_position'      => 20,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
            'menu_icon'         => 'dashicons-building',
        );
          
        register_post_type( 'ABProperty', $args );
    }

}