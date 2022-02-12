<?php
/**
 * Plugin Name:       WPABL Import
 * Plugin URI:        https://timmermarketing.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jahur Ahmed
 * Author URI:        https://timmermarketing.com
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpabl_import
 * Domain Path:       includes/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPABL_IMPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpabl_import-activator.php
 */
function activate_wpabl_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import-activator.php';
	Wpabl_import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpabl_import-deactivator.php
 */
function deactivate_wpabl_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import-deactivator.php';
	Wpabl_import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpabl_import' );
register_deactivation_hook( __FILE__, 'deactivate_wpabl_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpabl_import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpabl_import() {

	$plugin = new Wpabl_import();
	$plugin->run();

}
run_wpabl_import();

require_once plugin_dir_path( __FILE__ ) . 'hd-wp-metabox-api/class-hd-wp-metabox-api.php';

$wpabl_options = array(
	'metabox_id'    => 'wpabl_metabox',
	'metabox_title' => 'WPABL Info',
	'metabox_classes' => '',
	'post_type'     => array( 'abproperty' ),
	'context'       => 'normal',
	'priority'      => 'high',
);

$wpabl_fields = array(
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
		'type'    => 'checkbox',
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
	// 'hd_radio_meta' => array(
	// 	'title'   => 'Radio Input',
	// 	'type'    => 'radio',
	// 	'choices' => array(
	// 		'one'   => 'Option 1',
	// 		'two'   => 'Option 2',
	// 		'three' => 'Option 3'
	// 	),
	// 	'desc'    => 'Example Radio Input',
	// 	'sanit'   => 'nohtml',
	// ),
	// 'hd_select_meta' => array(
	// 	'title'   => 'Select Input',
	// 	'type'    => 'select',
	// 	'choices' => array(
	// 		'one'   => 'Option 1',
	// 		'two'   => 'Option 2',
	// 		'three' => 'Option 3'
	// 	),
	// 	'desc'    => 'Example Select Input',
	// 	'sanit'   => 'nohtml',
	// ),
	// 'hd_multiselect_meta' => array(
	// 	'title'   => 'Multi Select Input',
	// 	'type'    => 'select',
	// 	'choices' => array(
	// 		'one'   => 'Option 1',
	// 		'two'   => 'Option 2',
	// 		'three' => 'Option 3'
	// 	),
	// 	'multiple' => true,
	// 	'desc'     => 'Example Multi Select Input',
	// 	'sanit'    => 'nohtml',
	// ),
	// 'hd_multicheck_meta' => array(
	// 	'title'   => 'Multi Checkbox Input',
	// 	'type'    => 'multicheck',
	// 	'choices' => array(
	// 		'one'   => 'Option 1',
	// 		'two'   => 'Option 2',
	// 		'three' => 'Option 3'
	// 	),
	// 	'desc'    => 'Example Multi Checkbox Input',
	// 	'sanit'   => 'nohtml',
	// ),
	// 'hd_upload_meta' => array(
	// 	'title'   => 'Upload Input',
	// 	'type'    => 'upload',
	// 	'desc'    => 'Example Upload Input',
	// 	'sanit'   => 'url',
	// ),
	// 'hd_color_meta' => array(
	// 	'title'   => 'Color Input',
	// 	'type'    => 'color',
	// 	'desc'    => 'Example Color Input',
	// 	'sanit'   => 'color',
	// ),
	// 'hd_editor_meta' => array(
	// 	'title'   => 'Editor Input',
	// 	'type'    => 'editor',
	// 	'desc'    => 'Example Editor Input',
	// 	'sanit'   => 'nohtml',
	// ),
);

$wpabl_metabox = new HD_WP_Metabox_API( $wpabl_options, $wpabl_fields );

// Add Meta Box to post
add_action( 'add_meta_boxes', 'multi_media_uploader_meta_box' );

function multi_media_uploader_meta_box() {
	add_meta_box( 'my-post-box', 'Media Field', 'multi_media_uploader_meta_box_func', 'abproperty', 'normal', 'high' );
}

function multi_media_uploader_meta_box_func($post) {
	$banner_img = get_post_meta($post->ID,'post_banner_img',true);
	?>
	<style type="text/css">
		.multi-upload-medias ul li .delete-img { position: absolute; right: 3px; top: 2px; background: aliceblue; border-radius: 50%; cursor: pointer; font-size: 14px; line-height: 20px; color: red; }
		.multi-upload-medias ul li { width: 120px; display: inline-block; vertical-align: middle; margin: 5px; position: relative; }
		.multi-upload-medias ul li img { width: 100%; }
	</style>

	<table cellspacing="10" cellpadding="10">
		<tr>
			<td>Banner Image</td>
			<td>
				<?php echo multi_media_uploader_field( 'post_banner_img', $banner_img ); ?>
			</td>
		</tr>
	</table>

	<script type="text/javascript">
		jQuery(function($) {

			$('body').on('click', '.wc_multi_upload_image_button', function(e) {
				e.preventDefault();

				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					button: { text: 'Use this image' },
					multiple: true 
				}).on('select', function() {
					var attech_ids = '';
					attachments
					var attachments = custom_uploader.state().get('selection'),
					attachment_ids = new Array(),
					i = 0;
					attachments.each(function(attachment) {
						attachment_ids[i] = attachment['id'];
						attech_ids += ',' + attachment['id'];
						if (attachment.attributes.type == 'image') {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						} else {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						}

						i++;
					});

					var ids = $(button).siblings('.attechments-ids').attr('value');
					if (ids) {
						var ids = ids + attech_ids;
						$(button).siblings('.attechments-ids').attr('value', ids);
					} else {
						$(button).siblings('.attechments-ids').attr('value', attachment_ids);
					}
					$(button).siblings('.wc_multi_remove_image_button').show();
				})
				.open();
			});

			$('body').on('click', '.wc_multi_remove_image_button', function() {
				$(this).hide().prev().val('').prev().addClass('button').html('Add Media');
				$(this).parent().find('ul').empty();
				return false;
			});

		});

		jQuery(document).ready(function() {
			jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {
				var ids = [];
				var this_c = jQuery(this);
				jQuery(this).parent().remove();
				jQuery('.multi-upload-medias ul li').each(function() {
					ids.push(jQuery(this).attr('data-attechment-id'));
				});
				jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
			});
		})
	</script>

	<?php
}


function multi_media_uploader_field($name, $value = '') {
	$image = '">Add Media';
	$image_str = '';
	$image_size = 'full';
	$display = 'none';
	$value = explode(',', $value);

	if (!empty($value)) {
		foreach ($value as $values) {
			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
				$image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
			}
		}

	}

	if($image_str){
		$display = 'inline-block';
	}

	return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}

// Save Meta Box values.
add_action( 'save_post', 'wc_meta_box_save' );

function wc_meta_box_save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;	
	}

	if( !current_user_can( 'edit_post' ) ){
		return;	
	}
	
	if( isset( $_POST['post_banner_img'] ) ){
		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
	}
}

function wporg_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'wporg', 'wporg_options' );
 
    // Register a new section in the "wporg" page.
    add_settings_section(
        'wporg_section_developers',
        __( 'The Matrix has you.', 'wporg' ), 'wporg_section_developers_callback',
        'wporg'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'wporg_field_pill', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Pill', 'wporg' ),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        array(
            'label_for'         => 'wporg_field_pill',
            'class'             => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'wporg_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function wporg_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
    <?php
}
 
/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function wporg_field_pill_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'wporg_options' );
    ?>
    <select
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
            name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'red pill', 'wporg' ); ?>
        </option>
        <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'blue pill', 'wporg' ); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
    </p>
    <?php
}
 
/**
 * Add the top level menu page.
 */
function wporg_options_page() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );
}
 
 
/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'wporg_options_page' );
 
 
/**
 * Top level menu callback function
 */
function wporg_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'wporg_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'wporg' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'wporg' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

add_shortcode('xmltest', 'xmltestfn');


function is_assoc(array $arr)
{
	return is_array($arr) && array_diff_key($arr,array_keys(array_keys($arr)));
}

function structure_raw_listing_agents($agents_arr){
	$listingAgents = array();
		foreach($agents_arr as $agent_arr){
			//var_dump($agent_arr); echo '<br>';//email
			if( array_key_exists('name', $agent_arr) && array_key_exists('email', $agent_arr) ){
				$listingAgent = array(
					'id' => $agent_arr['@attributes']['id'], 
					'name' => $agent_arr['name'],
					'telephone' => $agent_arr['telephone'],
					'email' => $agent_arr['email']
				);
				array_push($listingAgents, $listingAgent);
			}
			
		}
	return $listingAgents;
}

function get_url_from_raw_array($arr){

	$url_array = array();
	foreach($arr as $single_elem){
		$single_elem_attr = $single_elem['@attributes'];
		if( array_key_exists('url', $single_elem_attr) ){
	
			array_push($url_array, $single_elem_attr['url']);
		
		}
		
	}
	return $url_array;
}

function process_single_property_xml_data($arr){

	if(is_array($arr)){
		
		//echo '<pre>';
		if(array_key_exists('@attributes', $arr) && array_key_exists('modTime', $arr['@attributes']) ){
			$modTime = sanitize_text_field($arr['@attributes']['modTime']);	
		}

		if(array_key_exists('@attributes', $arr) && array_key_exists('status', $arr['@attributes']) ){
			$status = sanitize_text_field($arr['@attributes']['status']);
		}
	
		if(array_key_exists('agentID', $arr)){
			$agentID = sanitize_text_field($arr['agentID']);
		}

		if(array_key_exists('uniqueID', $arr)){
			$uniqueID = sanitize_text_field($arr['uniqueID']);
		}

		//var_dump($arr['isMultiple']); // need to know the array elements
		if(array_key_exists('soldDetails', $arr) && array_key_exists('soldPrice', $arr['soldDetails']) ){
			$soldPrice = sanitize_text_field($arr['soldDetails']['soldPrice']);
		}

		if(array_key_exists('soldDetails', $arr) && array_key_exists('soldDate', $arr['soldDetails']) ){
			$soldDate = sanitize_text_field($arr['soldDetails']['soldDate']);
		}

		if(array_key_exists('newConstruction', $arr)){
			$newConstruction = sanitize_text_field($arr['newConstruction']);
		}

		if(array_key_exists('tenancy', $arr)){
			$tenancy = sanitize_text_field($arr['tenancy']);
		}
		
		if(array_key_exists('authority', $arr) && array_key_exists('@attributes', $arr['authority']) && array_key_exists('value', $arr['authority']['@attributes']) ){
			$authority = sanitize_text_field($arr['authority']['@attributes']['value']);
		}

		if(array_key_exists('price', $arr)){
			$price = sanitize_text_field($arr['price']);
		}

		if(array_key_exists('priceView', $arr)){
			$priceView = sanitize_text_field($arr['priceView']);
		}
		
		if(array_key_exists('underOffer', $arr) && array_key_exists('@attributes', $arr['underOffer']) && array_key_exists('value', $arr['underOffer']['@attributes']) ){
			$underOffer = sanitize_text_field($arr['underOffer']['@attributes']['value']);
		}
		
		if(array_key_exists('exclusivity', $arr) && array_key_exists('@attributes', $arr['exclusivity']) && array_key_exists('value', $arr['exclusivity']['@attributes']) ){
			$exclusivity = sanitize_text_field($arr['exclusivity']['@attributes']['value']);
		}
	
		if(array_key_exists('councilRates', $arr)){
			$councilRates = sanitize_text_field($arr['councilRates']);
		}
		
		if(array_key_exists('outgoings', $arr)){
			$outgoings = sanitize_text_field($arr['outgoings']);
		}

		if(array_key_exists('landDetails', $arr) && array_key_exists('area', $arr['landDetails'])){
			$landDetailsArea = sanitize_text_field($arr['landDetails']['area']);
		}

		if(array_key_exists('landDetails', $arr) && array_key_exists('frontage', $arr['landDetails'])){
			$landDetailsFrontage = sanitize_text_field($arr['landDetails']['frontage']);
		}
		
		//var_dump($arr['buildingDetails']); // need to know the array elements
		
		if(array_key_exists('listingAgent', $arr)){
			$listingAgents= structure_raw_listing_agents($arr['listingAgent']);
		}
		
		if(array_key_exists('address', $arr)){
			$address = $arr['address'];
		}

		if(array_key_exists('category', $arr) && array_key_exists('@attributes', $arr['category']) && array_key_exists('name', $arr['category']['@attributes']) ){
			$categoryName = sanitize_text_field($arr['category']['@attributes']['name']);
		}

		if(array_key_exists('features', $arr)){
			$features = $arr['features'];

			foreach($features as $feature_key => $feature_value){
				if($feature_key != 'otherFeatures'){
					//all features except otherFeatures
					//echo (int)$feature_value;
				}
			}
		}
		
		if(array_key_exists('features', $arr) && array_key_exists('otherFeatures', $arr['features']) ){
			$featuresOtherFeatures = $arr['features']['otherFeatures'];
		}
		
		if(array_key_exists('headline', $arr)){
			$headline = sanitize_text_field($arr['headline']);
		}

		if(array_key_exists('description', $arr)){
			$description = sanitize_text_field($arr['description']);
		}

		//var_dump($arr['inspectionTimes']); // need to know the array elements
		
		if(array_key_exists('externalLink', $arr) && array_key_exists('@attributes', $arr['externalLink']) && array_key_exists('href', $arr['externalLink']['@attributes']) ){
			$externalLinkHref = sanitize_text_field($arr['externalLink']['@attributes']['href']);
		}

		if(array_key_exists('videoLink', $arr) && array_key_exists('@attributes', $arr['videoLink']) && array_key_exists('href', $arr['videoLink']['@attributes']) ){
			$videoLinkHref = sanitize_text_field($arr['videoLink']['@attributes']['href']);
		}

		if(array_key_exists('objects', $arr)){
			if(array_key_exists('objects', $arr) && array_key_exists('img', $arr['objects']) ){
				$objectsImg = $arr['objects']['img'];
				$objectsImgNew = get_url_from_raw_array($objectsImg);
			}
			if(array_key_exists('objects', $arr) && array_key_exists('floorplan', $arr['objects']) ){
				$objectsFloorplan = $arr['objects']['floorplan'];
				$objectsFloorplanNew = get_url_from_raw_array($objectsFloorplan);
			}
		}

		//var_dump($arr['media']); // need to know the array elements
		
		if(array_key_exists('extraFields', $arr)){
			$extraFields = $arr['extraFields'];
		
				foreach($extraFields as $extraField){
					
					if(array_key_exists('@attributes', $extraField)){
						foreach($extraField['@attributes'] as $attribute_key => $attribute_value){
							//echo $attribute_key . ': ' . $attribute_value; 
							//echo '<br>'; 
						}
					
					}
		
				}
			
		}

		//echo '</pre>';
	}
}

function is_ab_property($arr){
	$property_criteria = array('uniqueID');
	if(array_key_exists($property_criteria[0], $arr)){
		return true;
	}else{
		return false;
	}
}
function xmltestfn(){

	$all_files = glob(plugin_dir_path(__FILE__)."xml-files/*.xml");
    
        foreach($all_files as $file) {
			//echo '<pre>';
			//var_dump($file);
            $xml = simplexml_load_file($file);
			$json = json_encode($xml);
        	$data_array = json_decode($json,TRUE);
			unset($data_array['@attributes']);
			//var_dump($data_array);
			foreach($data_array as $properties_array){
				
				if(is_assoc($properties_array)){
					//var_dump(is_ab_property($properties_array));
					$property_array = $properties_array;
					if(is_ab_property($property_array)){
						process_single_property_xml_data($property_array);
						
					}
					
					//var_dump($properties_array);
					//echo '<br><br><br>';
				}elseif(!is_assoc($properties_array)){
					foreach($properties_array as $property_array){
						//var_dump(is_ab_property($property_array));
						//var_dump($property_array);
						//echo '<br><br><br>';
						process_single_property_xml_data($property_array);
						
					}
				}
			}
			//echo '</pre>';
        }

}

