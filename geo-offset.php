<?php 
/*
Plugin Name: Geo Offset Duplicate Listings
Plugin URI: http://coderspress.com/
Description: Adds 0.00001 to Listing Longitude Coordinates
Version: 2015.0922
Updated: 22nd September 2015
Author: sMarty 
Author URI: http://coderspress.com
WP_Requires: 3.8.1
WP_Compatible: 4.3.1
License: http://creativecommons.org/licenses/GPL/2.0
*/

add_action( 'init', 'geoo_plugin_updater' );
function geoo_plugin_updater() {
	if ( is_admin() ) { 
	include_once( dirname( __FILE__ ) . '/updater.php' );
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'geo-offset',
			'api_url' => 'https://api.github.com/repos/CodersPress/geo-offset',
			'raw_url' => 'https://raw.github.com/CodersPress/geo-offset/master',
			'github_url' => 'https://github.com/CodersPress/geo-offset',
			'zip_url' => 'https://github.com/CodersPress/geo-offset/zipball/master',
			'sslverify' => true,
			'access_token' => '1e661fb0d28c5300bae25bcc23ef8a92e760f194',
		);
		new WP_GEOO_UPDATER( $config );
	}
}

add_action('admin_menu', 'geo_offset_menu');
function geo_offset_menu() {
	add_menu_page('GEO Offset', 'GEO Offset', 'administrator', __FILE__, 'geo_offset_page',plugins_url('/images/geo-icon.gif', __FILE__));
}

function geo_offset_page() { ?>

<div class="wrap">
    <h2>Geo Offset Duplicate Listings.</h2>
    <hr />
    <table class="widefat" style="width:600px;">

		<thead style="background:#2EA2CC;color:#fff;">
            <tr>
                <th style="color:#fff;">Open this page to run this script.</th>
            </tr>
        </thead>
			<tr>
<td><?php 
global $wpdb;

$geo = $wpdb->get_results("SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'map-log' GROUP BY meta_value HAVING Count(meta_value) > 1");

if($geo)
	{
		foreach ( $geo as $geoo ) 
		{
			$wpdb->query("UPDATE $wpdb->postmeta SET meta_value = meta_value+0.00001 WHERE meta_id = $geoo->meta_id");
			echo "Checking....  Finished.<br />";
		} 
	} else { echo "No duplicate coordinates found...."; }

?></td>
			</tr>
  </table>
</div>

<?php
}
?>