<?php

class Wpabl_import_XML_Process{
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
	public function __construct( ) {

		//$this->plugin_name = $plugin_name;
		//$this->version = $version;

	}

    public function process(){
		
		$xml_data = array();

        $files = glob(plugin_dir_path(__FILE__)."xml-files/*.xml");

        foreach($files as $filename) {
            //$xml_file = file_get_contents($filename, FILE_TEXT);      
            $xml = simplexml_load_file($filename);
            $json = json_encode($xml);
    		$xml_data = json_decode($json,TRUE);
        }
		//return $files;
    }

}