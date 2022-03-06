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


// Options page settings

// Options settings ends

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

	if( !current_user_can( 'administrator' ) ){
		return;	
	}
	
	if( isset( $_POST['post_banner_img'] ) ){
		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
	}
}

 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
//add_action( 'admin_init', 'wporg_settings_init' );


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

	$property_data = array();
	if(is_array($arr)){
		
		//echo '<pre>';
		if(array_key_exists('@attributes', $arr) && array_key_exists('modTime', $arr['@attributes']) ){
			$modTime = sanitize_text_field($arr['@attributes']['modTime']);	
			//var_dump($arr);
			$property_data['@attributes']['modTime'] = $modTime;
		}else{
			$property_data['@attributes']['modTime'] = '';
		}

		if(array_key_exists('@attributes', $arr) && array_key_exists('status', $arr['@attributes']) ){
			$status = sanitize_text_field($arr['@attributes']['status']);
			$property_data['@attributes']['status'] = $status;
		}else{
			$property_data['@attributes']['status'] = '';
		}
	
		if(array_key_exists('agentID', $arr)){
			$agentID = sanitize_text_field($arr['agentID']);
			$property_data['agentID'] = $agentID;
		}else{
			$property_data['agentID'] = '';
		}

		if(array_key_exists('uniqueID', $arr)){
			$uniqueID = sanitize_text_field($arr['uniqueID']);
			$property_data['uniqueID'] = $uniqueID;
		}else{
			$property_data['uniqueID'] = '';
		}

		if(array_key_exists('soldDetails', $arr) && array_key_exists('soldPrice', $arr['soldDetails']) ){
			$soldPrice = sanitize_text_field($arr['soldDetails']['soldPrice']);
			$property_data['soldDetails']['soldPrice'] = $soldPrice;
		}else{
			$property_data['soldDetails']['soldPrice'] = '';
		}

		if(array_key_exists('soldDetails', $arr) && array_key_exists('soldDate', $arr['soldDetails']) ){
			$soldDate = sanitize_text_field($arr['soldDetails']['soldDate']);
			$property_data['soldDetails']['soldDate'] = $soldDate;
		}else{
			$property_data['soldDetails']['soldDate'] = '';
		}

		if(array_key_exists('newConstruction', $arr)){
			$newConstruction = sanitize_text_field($arr['newConstruction']);
			$property_data['newConstruction'] = $newConstruction;
		}else{
			$property_data['newConstruction'] = '';
		}

		if(array_key_exists('tenancy', $arr)){
			$tenancy = sanitize_text_field($arr['tenancy']);
			$property_data['tenancy'] = $tenancy;
		}else{
			$property_data['tenancy'] = '';
		}
		
		if(array_key_exists('authority', $arr) && array_key_exists('@attributes', $arr['authority']) && array_key_exists('value', $arr['authority']['@attributes']) ){
			$authority = sanitize_text_field($arr['authority']['@attributes']['value']);
			$property_data['authority']['@attributes']['value'] = $authority;
		}else{
			$property_data['authority']['@attributes']['value'] = '';
		}

		if(array_key_exists('price', $arr)){
			$price = sanitize_text_field($arr['price']);
			$property_data['price'] = $price;
		}else{
			$property_data['price'] = '';
		}

		if(array_key_exists('priceView', $arr)){
			$priceView = sanitize_text_field($arr['priceView']);
			$property_data['priceView'] = $priceView;
		}else{
			$property_data['priceView'] = '';
		}
		
		if(array_key_exists('underOffer', $arr) && array_key_exists('@attributes', $arr['underOffer']) && array_key_exists('value', $arr['underOffer']['@attributes']) ){
			$underOffer = sanitize_text_field($arr['underOffer']['@attributes']['value']);
			$property_data['underOffer']['@attributes']['value'] = $underOffer;
		}else{
			$property_data['underOffer']['@attributes']['value'] = '';
		}
		
		if(array_key_exists('exclusivity', $arr) && array_key_exists('@attributes', $arr['exclusivity']) && array_key_exists('value', $arr['exclusivity']['@attributes']) ){
			$exclusivity = sanitize_text_field($arr['exclusivity']['@attributes']['value']);
			$property_data['exclusivity']['@attributes']['value'] = $exclusivity;
		}else{
			$property_data['exclusivity']['@attributes']['value'] = '';
		}
	
		if(array_key_exists('councilRates', $arr)){
			$councilRates = sanitize_text_field($arr['councilRates']);
			$property_data['councilRates'] = $councilRates;
		}else{
			$property_data['councilRates'] = '';
		}
		
		if(array_key_exists('outgoings', $arr)){
			$outgoings = sanitize_text_field($arr['outgoings']);
			$property_data['outgoings'] = $outgoings;
		}else{
			$property_data['outgoings'] = '';
		}

		if(array_key_exists('landDetails', $arr) && array_key_exists('area', $arr['landDetails'])){
			$landDetailsArea = sanitize_text_field($arr['landDetails']['area']);
			$property_data['landDetails']['area'] = $landDetailsArea;
		}else{
			$property_data['landDetails']['area'] = '';
		}

		if(array_key_exists('landDetails', $arr) && array_key_exists('frontage', $arr['landDetails'])){
			$landDetailsFrontage = sanitize_text_field($arr['landDetails']['frontage']);
			$property_data['landDetails']['frontage'] = $landDetailsFrontage;
		}else{
			$property_data['landDetails']['frontage'] = '';
		}

		if(array_key_exists('listingAgent', $arr)){
			$listingAgents = structure_raw_listing_agents($arr['listingAgent']);
			$property_data['listingAgent'] = $listingAgents;
		}else{
			$property_data['listingAgent'] = '';
		}
		
		// if(array_key_exists('address', $arr)){
		// 	$address = $arr['address'];
		// 	$property_data['address'] = $address;
		// }else{
		// 	$property_data['address'] = '';
		// }

		if(array_key_exists('address', $arr) && array_key_exists('@attributes', $arr['address']) && array_key_exists('display', $arr['address']['@attributes']) ){
			$addressDisplay = sanitize_text_field($arr['address']['@attributes']['display']);
			$property_data['address']['@attributes']['display'] = $addressDisplay;
		}else{
			$property_data['address']['@attributes']['display'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('@attributes', $arr['address']) && array_key_exists('streetview', $arr['address']['@attributes']) ){
			$addressStreetview = sanitize_text_field($arr['address']['@attributes']['streetview']);
			$property_data['address']['@attributes']['streetview'] = $addressStreetview;
		}else{
			$property_data['address']['@attributes']['streetview'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('subNumber', $arr['address']) ){
			$addressSubNumber = sanitize_text_field($arr['address']['subNumber']);
			$property_data['address']['subNumber'] = convertArraytoString($addressSubNumber);
		}else{
			$property_data['address']['subNumber'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('lotNumber', $arr['address']) ){
			$addressLotNumber = sanitize_text_field($arr['address']['lotNumber']);
			$property_data['address']['lotNumber'] = convertArraytoString($addressLotNumber);
		}else{
			$property_data['address']['lotNumber'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('streetNumber', $arr['address']) ){
			$addressStreetNumber = sanitize_text_field($arr['address']['streetNumber']);
			$property_data['address']['streetNumber'] = $addressStreetNumber;
		}else{
			$property_data['address']['streetNumber'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('street', $arr['address']) ){
			$addressStreet = sanitize_text_field($arr['address']['street']);
			$property_data['address']['street'] = $addressStreet;
		}else{
			$property_data['address']['street'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('suburb', $arr['address']) ){
			$addressSuburb = sanitize_text_field($arr['address']['suburb']);
			$property_data['address']['suburb'] = $addressSuburb;
		}else{
			$property_data['address']['suburb'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('state', $arr['address']) ){
			$addressState = sanitize_text_field($arr['address']['state']);
			$property_data['address']['state'] = $addressState;
		}else{
			$property_data['address']['state'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('postcode', $arr['address']) ){
			$addressPostcode = sanitize_text_field($arr['address']['postcode']);
			$property_data['address']['postcode'] = $addressPostcode;
		}else{
			$property_data['address']['postcode'] = '';
		}

		if(array_key_exists('address', $arr) && array_key_exists('country', $arr['address']) ){
			$addressCountry = sanitize_text_field($arr['address']['country']);
			$property_data['address']['country'] = $addressCountry;
		}else{
			$property_data['address']['country'] = '';
		}


		if(array_key_exists('category', $arr) && array_key_exists('@attributes', $arr['category']) && array_key_exists('name', $arr['category']['@attributes']) ){
			$categoryName = sanitize_text_field($arr['category']['@attributes']['name']);
			$property_data['category']['@attributes']['name'] = $categoryName;
		}else{
			$property_data['category']['@attributes']['name'] = '';
		}


		// Features start

		if(array_key_exists('features', $arr) && array_key_exists('openSpaces', $arr['features']) ){
			$featuresopenSpaces = sanitize_text_field($arr['features']['openSpaces']);
			$property_data['features']['openSpaces'] = $featuresopenSpaces;
		}else{
			$property_data['features']['openSpaces'] = '';
		}

		if(array_key_exists('features', $arr) && array_key_exists('bedrooms', $arr['features']) ){
			$featuresbedrooms = sanitize_text_field($arr['features']['bedrooms']);
			$property_data['features']['bedrooms'] = $featuresbedrooms;
		}else{
			$property_data['features']['bedrooms'] = '';
		}

		if(array_key_exists('features', $arr) && array_key_exists('bathrooms', $arr['features']) ){
			$featuresbathrooms = sanitize_text_field($arr['features']['bathrooms']);
			$property_data['features']['bathrooms'] = $featuresbathrooms;
		}else{
			$property_data['features']['bathrooms'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('garages', $arr['features']) ){
			$featuresgarages = sanitize_text_field($arr['features']['garages']);
			$property_data['features']['garages'] = $featuresgarages;
		}else{
			$property_data['features']['garages'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('carports', $arr['features']) ){
			$featurescarports = sanitize_text_field($arr['features']['carports']);
			$property_data['features']['carports'] = $featurescarports;
		}else{
			$property_data['features']['carports'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('toilets', $arr['features']) ){
			$featurestoilets = sanitize_text_field($arr['features']['toilets']);
			$property_data['features']['toilets'] = $featurestoilets;
		}else{
			$property_data['features']['toilets'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('livingAreas', $arr['features']) ){
			$featureslivingAreas = sanitize_text_field($arr['features']['livingAreas']);
			$property_data['features']['livingAreas'] = $featureslivingAreas;
		}else{
			$property_data['features']['livingAreas'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('airConditioning', $arr['features']) ){
			$featuresairConditioning = sanitize_text_field($arr['features']['airConditioning']);
			$property_data['features']['airConditioning'] = $featuresairConditioning;
		}else{
			$property_data['features']['airConditioning'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('alarmSystem', $arr['features']) ){
			$featuresalarmSystem = sanitize_text_field($arr['features']['alarmSystem']);
			$property_data['features']['alarmSystem'] = $featuresalarmSystem;
		}else{
			$property_data['features']['alarmSystem'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('builtInRobes', $arr['features']) ){
			$featuresbuiltInRobes = sanitize_text_field($arr['features']['builtInRobes']);
			$property_data['features']['builtInRobes'] = $featuresbuiltInRobes;
		}else{
			$property_data['features']['builtInRobes'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('ensuite', $arr['features']) ){
			$featuresensuite = sanitize_text_field($arr['features']['ensuite']);
			$property_data['features']['ensuite'] = $featuresensuite;
		}else{
			$property_data['features']['ensuite'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('furnished', $arr['features']) ){
			$featuresfurnished = sanitize_text_field($arr['features']['furnished']);
			$property_data['features']['furnished'] = $featuresfurnished;
		}else{
			$property_data['features']['furnished'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('furnished', $arr['features']) ){
			$featuresfurnished = sanitize_text_field($arr['features']['furnished']);
			$property_data['features']['furnished'] = $featuresfurnished;
		}else{
			$property_data['features']['furnished'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('intercom', $arr['features']) ){
			$featuresintercom = sanitize_text_field($arr['features']['intercom']);
			$property_data['features']['intercom'] = $featuresintercom;
		}else{
			$property_data['features']['intercom'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('openFirePlace', $arr['features']) ){
			$featuresopenFirePlace = sanitize_text_field($arr['features']['openFirePlace']);
			$property_data['features']['openFirePlace'] = $featuresopenFirePlace;
		}else{
			$property_data['features']['openFirePlace'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('petFriendly', $arr['features']) ){
			$featurespetFriendly = sanitize_text_field($arr['features']['petFriendly']);
			$property_data['features']['petFriendly'] = $featurespetFriendly;
		}else{
			$property_data['features']['petFriendly'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('smokers', $arr['features']) ){
			$featuressmokers = sanitize_text_field($arr['features']['smokers']);
			$property_data['features']['smokers'] = $featuressmokers;
		}else{
			$property_data['features']['smokers'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('tennisCourt', $arr['features']) ){
			$featurestennisCourt = sanitize_text_field($arr['features']['tennisCourt']);
			$property_data['features']['tennisCourt'] = $featurestennisCourt;
		}else{
			$property_data['features']['tennisCourt'] = '';
		}
		if(array_key_exists('features', $arr) && array_key_exists('vacuumSystem', $arr['features']) ){
			$featuresvacuumSystem = sanitize_text_field($arr['features']['vacuumSystem']);
			$property_data['features']['vacuumSystem'] = $featuresvacuumSystem;
		}else{
			$property_data['features']['vacuumSystem'] = '';
		}
		
		if(array_key_exists('features', $arr) && array_key_exists('otherFeatures', $arr['features']) ){
			$featuresOtherFeatures = sanitize_text_field($arr['features']['otherFeatures']);
			$property_data['features']['otherFeatures'] = $featuresOtherFeatures;
		}else{
			$property_data['features']['otherFeatures'] = '';
		}

		// Features end
		
		if(array_key_exists('headline', $arr)){
			$headline = sanitize_text_field($arr['headline']);
			$property_data['headline'] = $headline;
		}

		if(array_key_exists('description', $arr)){
			$description = sanitize_text_field($arr['description']);
			$property_data['description'] = $description;
		}

		// if(array_key_exists('description', $arr)){
		// 	$description = sanitize_text_field($arr['description']);
		// 	$property_data['description'] = $description;
		// }$property_array['inspectionTimes']['inspection']

		if( array_key_exists('inspectionTimes', $arr) && array_key_exists('inspection', $arr['inspectionTimes']) ){
			$inspectionTimes = $arr['inspectionTimes']['inspection'];
			$property_data['inspectionTimes']['inspection'] = convertArraytoString($inspectionTimes);
		}
		
		if(array_key_exists('externalLink', $arr) && array_key_exists('@attributes', $arr['externalLink']) && array_key_exists('href', $arr['externalLink']['@attributes']) ){
			$externalLinkHref = sanitize_text_field($arr['externalLink']['@attributes']['href']);
			$property_data['externalLink']['@attributes']['href'] = $externalLinkHref;
		}

		if(array_key_exists('videoLink', $arr) && array_key_exists('@attributes', $arr['videoLink']) && array_key_exists('href', $arr['videoLink']['@attributes']) ){
			$videoLinkHref = sanitize_text_field($arr['videoLink']['@attributes']['href']);
			$property_data['videoLink']['@attributes']['href'] = $videoLinkHref;
		}

		if(array_key_exists('objects', $arr)){
			if(array_key_exists('objects', $arr) && array_key_exists('img', $arr['objects']) ){
				$objectsImg = $arr['objects']['img'];
				$objectsImgNew = get_url_from_raw_array($objectsImg);
				$property_data['objects']['img'] = $objectsImgNew;
			}
			if(array_key_exists('objects', $arr) && array_key_exists('floorplan', $arr['objects']) ){
				$objectsFloorplan = $arr['objects']['floorplan'];
				$objectsFloorplanNew = get_url_from_raw_array($objectsFloorplan);
				$property_data['objects']['floorplan'] = $objectsFloorplanNew;
			}
		}

		if(array_key_exists('extraFields', $arr)){
			$extraFields = $arr['extraFields'];
			$property_data['extraFields'] = $extraFields;
				// foreach($extraFields as $extraField){
					
				// 	if(array_key_exists('@attributes', $extraField)){
				// 		//$property_data['extraFields']['@attributes'] = $extraField;
				// 		foreach($extraField['@attributes'] as $attribute_key => $attribute_value){
				// 			//$property_data['extraFields']['@attributes'] = $attribute_value;
				// 		}
					
				// 	}
		
				// }
			
		}

		//var_dump($arr['isMultiple']); // need to know the array elements
		//var_dump($arr['buildingDetails']); // need to know the array elements
		//var_dump($arr['media']); // need to know the array elements
		
		//echo '</pre>';
	}

	return $property_data;
}

function is_ab_property($arr){
	$property_criteria = array('uniqueID');
	if(array_key_exists($property_criteria[0], $arr)){
		return true;
	}else{
		return false;
	}
}

function meta_value_arr($property_info){
	$arr = array(
		'wpabl_agent_id' => $property_info['agentID'],
		'wpabl_unique_id' => $property_info['uniqueID'],
		//'wpabl_is_multiple' => '',
		'wpabl_sold_price' => $property_info['soldDetails']['soldPrice'],
		'wpabl_sold_date' => $property_info['soldDetails']['soldDate'],
		'wpabl_new_construction' => $property_info['newConstruction'],
		'wpabl_tenancy' => $property_info['tenancy'],
		'wpabl_authority' => $property_info['authority']['@attributes']['value'],
		'wpabl_price' => $property_info['price'],
		'wpabl_price_view' => $property_info['priceView'],
		'wpabl_under_offer' => $property_info['underOffer']['@attributes']['value'],
		'wpabl_exclusivity' => $property_info['exclusivity']['@attributes']['value'],
		'wpabl_council_rates' => $property_info['councilRates'],
		'wpabl_outgoings' => $property_info['outgoings'],
		'wpabl_area' => $property_info['landDetails']['area'],
		'wpabl_frontage' => $property_info['landDetails']['frontage'],
		//'wpabl_energy_rating' => '',
		'wpabl_sub_number' => $property_info['address']['subNumber'],
		'wpabl_lot_number' => $property_info['address']['lotNumber'],
		'wpabl_street_number' => $property_info['address']['streetNumber'],
		'wpabl_street' => $property_info['address']['street'],
		'wpabl_suburb' => $property_info['address']['suburb'],
		'wpabl_state' => $property_info['address']['state'],
		'wpabl_country' => $property_info['address']['country'],
		'wpabl_post_code' => $property_info['address']['postcode'],
		'wpabl_open_spaces' => '',
		'wpabl_other_features' => $property_info['features']['otherFeatures'],
		'wpabl_headline' => $property_info['headline'],
		'wpabl_inspection_times' => '',
		'wpabl_external_link' => $property_info['externalLink']['@attributes']['href'],
		'wpabl_video_link' => $property_info['videoLink']['@attributes']['href'],
	);
	return $arr;

}

function convertArraytoString($arr){
		
	if(is_array($arr)){
		$str = implode(", ", $arr);
		$str = sanitize_text_field($str);
	}else{
		$str = sanitize_text_field($arr);
	}
	return $str;

}

function getLatLong($arr, $latlng='geoLat'){
	$extraFields = $arr['extraFields'];
		$latKey = '';
		foreach($extraFields as $key => $extraField){
			
			$eF = $extraField['@attributes'];
			if(array_key_exists('name', $eF) && ($eF['name'] == $latlng) && (array_key_exists('value', $eF))){
				//echo '<pre>';
				$geoLat = $eF['value'];
				$latKey = $key;
				//echo '</pre>';
			}
			
		}
		if($latKey){
		return $extraFields[$latKey]['@attributes']['value'];
		}else
		return false;
}

function get_listing_agents($arr, $nth_agent=0){
    
    $listing_agents = $arr['listingAgent'];
    $nth_agent = (int)$nth_agent;
	if(array_key_exists($nth_agent, $listing_agents)){
		if(array_key_exists( 'email' , $listing_agents[$nth_agent] )) {
			if( $listing_agents[$nth_agent]['email'] == 'kerry-anne@kanproperty.com.au' ){

				return '47'; // 47 is Kerry-Anne's id in wp 
				
				}elseif( $listing_agents[$nth_agent]['email'] == 'ashleigh@kanproperty.com.au'){
					
					return '45'; // 45 is ashleigh's id in wp 
					
					}else{
						return '0';
						}
			
		}
	}else{
		return '0';
	}
}

function cpt_meta_value_arr($property_info){

	$lat = getLatLong($property_info, 'geoLat');
	$lng = getLatLong($property_info, 'geoLong');

	$arr = array(
		'unique_id' 					=> $property_info['uniqueID'],
		'property_address' 				=> $property_info['address']['streetNumber'].' '.$property_info['address']['street'].', '.$property_info['address']['suburb'],
		'property_lat' 					=> $lat,
		'property_lng' 					=> $lng,
		'street_number' 				=> $property_info['address']['streetNumber'],
		'route' 						=> $property_info['address']['street'],
		'neighborhood' 					=> '',
		'locality' 						=> $property_info['address']['suburb'],
		'administrative_area_level_1' 	=> $property_info['address']['state'],
		'postal_code' 					=> $property_info['address']['postcode'],
		'property_price' 				=> $property_info['priceView'],
		'property_price_label' 			=> '',
		'property_taxes' 				=> '',
		'property_hoa_dues' 			=> '',
		'property_beds' 				=> $property_info['features']['bedrooms'],
		'property_baths' 				=> $property_info['features']['bathrooms'],
		'property_size' 				=> (int)$property_info['features']['garages'] + (int)$property_info['features']['openSpaces'],
		'garage' 						=> $property_info['features']['garages'],
		'openspaces' 					=> $property_info['features']['openSpaces'],
		'carports' 						=> $property_info['features']['carports'],
		'toilets' 						=> $property_info['features']['toilets'],
		'livingareas' 					=> $property_info['features']['livingAreas'],
		'airconditioning' 				=> $property_info['features']['airConditioning'],
		'alarmsystem' 					=> $property_info['features']['alarmSystem'],
		'builtinrobes' 					=> $property_info['features']['builtInRobes'],
		'ensuite' 						=> $property_info['features']['ensuite'],
		'furnished' 					=> $property_info['features']['furnished'],
		'intercom' 						=> $property_info['features']['intercom'],
		'openfireplace' 				=> $property_info['features']['openFirePlace'],
		'petfriendly' 					=> $property_info['features']['petFriendly'],
		'smokers' 						=> $property_info['features']['smokers'],
		'tenniscourt' 					=> $property_info['features']['tennisCourt'],
		'vacuumsystem' 					=> $property_info['features']['vacuumSystem'],
		'open_time' 					=> $property_info['inspectionTimes']['inspection'],
		'built_in' 						=> '',
		'lot_width' 					=> '',
		'lot_depth' 					=> '',
		'stories' 						=> '',
		'room_count' 					=> '',
		'parking_spaces' 				=> '',
		'property_agent' 				=> get_listing_agents($property_info, 0),
		'property_agent2' 				=> get_listing_agents($property_info, 1),
		'property_floor_plans' 			=> '',
		'property_video' 				=> $property_info['videoLink']['@attributes']['href'],
		
    );
    
    return $arr;

}
// add_action('admin_init', 'abcd');
// function abcd(){
// 	$post_types = get_post_types( array( 'public' => true ), 'names' ); 
// 	var_dump( $post_types);
// }
//add_action('init', 'get_all_post_types');

add_shortcode('xmltest', 'xmltestfn');

function xmltestfn(){

	/* Store the path of source file */

	$all_files = glob(plugin_dir_path(__FILE__)."xml-files/*.xml");
    
        foreach($all_files as $file) {
			//echo '<pre>';
			//var_dump(basename($file));

			//$filePath = $file;
  
			/* Store the path of destination file */
			//$destinationFilePath = plugin_dir_path(__FILE__).'processed/'.basename($file);
			
			/* Move File from images to copyImages folder */
			// if( !rename($filePath, $destinationFilePath) ) {  
			// 	echo "File can't be moved!";  
			// }  
			// else {  
			// 	echo "File has been moved!";  
			// } 
            $xml = simplexml_load_file($file);
			$json = json_encode($xml);
        	$data_array = json_decode($json,TRUE);
			unset($data_array['@attributes']);
			//var_dump($data_array);
			foreach($data_array as $properties_array_key => $properties_array){
				
				if(is_assoc($properties_array)){
					//var_dump(is_ab_property($properties_array));
					$property_array = $properties_array;
					if(is_ab_property($property_array)){
						$property_info = process_single_property_xml_data($property_array);
						//var_dump($property_array['inspectionTimes']['inspection']);
						echo '<pre>';
						//var_dump($property_array);
						echo '</pre>';
						$integration_type = get_option('hd_integration_type');


						if($integration_type == 'plugin_cpt'){
							$post_type = 'abproperty';
							$unique_id = 'wpabl_unique_id';
						}else{
							$post_type = get_option('hd_post_types_dropdpwn');
							$unique_id = 'unique_id';
						}


						if($post_type){
						$args = array(
							'post_type' => $post_type,
							'meta_key'   => $unique_id,
							'meta_value' => $property_info['uniqueID']
						);
						$query = new WP_Query( $args );

						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$post_id = get_the_ID();
							}
						} else {
							// no posts found
						}
					
						wp_reset_postdata();

						//var_dump($query->found_posts);
						if(($query->found_posts) > 0){
							//Update post
							echo 'Update'.$post_id.'<br>';
							$post_title = $property_info['address']['streetNumber'].' ';
							$post_title .= $property_info['address']['street'].', ';
							$post_title .= $property_info['address']['suburb'];
							
							$post_content = nl2br($property_info['description']);
						
							$update_property_data = array(
								'ID' => $post_id,
								//'post_title'   => $post_title,
								'post_content' => $post_content,
								'meta_input' =>  cpt_meta_value_arr($property_info),
							  );
							  if( current_user_can( 'administrator' ) ){
								wp_update_post( $update_property_data );

								$property_type_id = $properties_array_key;
								$property_status_id = $property_info['@attributes']['status'];
						  
								wp_set_object_terms( $post_id, $property_type_id, 'property_type' );
								wp_set_object_terms( $post_id, $property_status_id, 'property_status' );
							}
							//var_dump($property_info);
							  


						}elseif(($query->found_posts) == 0){
							//Insert post
							echo 'insert';
							$post_title = $property_info['address']['streetNumber'].' ';
							$post_title .= $property_info['address']['street'].', ';
							$post_title .= $property_info['address']['suburb'];
							
							$post_content = nl2br($property_info['description']);

							$insert_property_data = array(
								'post_title'    => $post_title,
								'post_content'  => $post_content,
								'post_type' 	=> $post_type,
								'post_status'   => 'publish',
								'meta_input' 	=>  cpt_meta_value_arr($property_info),
							  );
							
							if( current_user_can( 'administrator' ) ){
								$new_post_id = wp_insert_post( $insert_property_data );
								$property_type_id = $properties_array_key;
								$property_status_id = $property_info['@attributes']['status'];
						  
								wp_set_object_terms( $new_post_id, $property_type_id, 'property_type' );
								wp_set_object_terms( $new_post_id, $property_status_id, 'property_status' );
							}
							//$new_post_id = wp_insert_post( $insert_property_data );
						
						}
						//echo '<pre>';
						//var_dump($properties_array_key); 
						//echo '</pre>';
						// echo $property_info['uniqueID'];
						// $extraFields = $property_info['extraFields'];
						// $latKey = '';
						// foreach($extraFields as $key => $extraField){
							
						// 	$eF = $extraField['@attributes'];
						// 	if(array_key_exists('name', $eF) && ($eF['name'] == 'geoLat') && (array_key_exists('value', $eF))){
						// 		//echo '<pre>';
						// 		$geoLat = $eF['value'];
						// 		$latKey = $key;
						// 		//echo '</pre>';
						// 	}
							
						// }
						//$lgid = get_listing_agents($property_info, 1);
						echo '<pre>';
						var_dump($property_info); 
						//var_dump($lgid);
						echo '</pre>';
						

						
					}// checks $post_type has a value

					}

					//echo '<pre>' . var_export($properties_array, true) . '</pre>';
					
					//var_dump($properties_array);
					//echo '<br><br><br>';
				}elseif(!is_assoc($properties_array)){
					foreach($properties_array as $property_array){
						//var_dump(is_ab_property($property_array));
						//var_dump($property_array);
						//echo '<br><br><br>';
						$property_info = process_single_property_xml_data($property_array);
						//var_dump(count($property_info['extraFields']));
						//var_dump($property_info);
						
					}
				}
			}
			//echo '</pre>';
        }

	

}

