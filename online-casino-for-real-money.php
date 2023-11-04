<?php
/**
 * online casino for real money
 *
 * @package       ONLINECASI
 * @author        Webnotics
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   online casino for real money
 * Plugin URI:    #
 * Description:   Online casino for real money |  Safe and fast payout
 * Version:       1.0.0
 * Author:        Webnotics
 * Author URI:    #
 * Text Domain:   online-casino-for-real-money
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with online casino for real money. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Include your onlinecasino code here.



// Enqueue onlinecasino CSS
function enqueue_onlinecasino_css() {
    wp_enqueue_style('onlinecasino-plugin-style', plugin_dir_url(__FILE__) . 'public/css/onlinecasino-style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_onlinecasino_css');

// Enqueue onlinecasino JavaScript
function enqueue_onlinecasino_js() {
    wp_enqueue_script('onlinecasino-plugin-script', plugin_dir_url(__FILE__) . 'public/js/onlinecasino-script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_onlinecasino_js');



// plugin setting link

function custom_plugin_action_links_onlinecasino($links, $plugin_file) {
   
    $custom_links = array(
        'docs' => '<a href="' . esc_url(admin_url('admin.php?page=onlinecasino-shortcode')) . '" >Documentation</a>',
    );
    $links = array_merge($links, $custom_links);

return $links;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'custom_plugin_action_links_onlinecasino', 10, 2);


require_once plugin_dir_path( __FILE__ ) . '/inc/onlinecasino-menu-page.php';


register_activation_hook(__FILE__, 'onlinecasino_plugin_activate');


function onlinecasino_plugin_activate() {
    init_db_onlinecasino();
}


// Initialize DB Tables
function init_db_onlinecasino() {

	// WP Globals
	global $table_prefix, $wpdb;

	// Customer Table
	$customerTable = $table_prefix . 'onlinecasino_list';

	// Create Customer Table if not exist
	if( $wpdb->get_var( "show tables like '$customerTable'" ) != $customerTable ) {

		// Query - Create Table
		$sql = "CREATE TABLE `$customerTable` (";
		$sql .= " `id` int(11) NOT NULL auto_increment, ";
		$sql .= " `title` varchar(500) NOT NULL, ";
		$sql .= " `images` varchar(500) NOT NULL, ";
		$sql .= " `play_now_link` varchar(500), ";
		$sql .= " `signup_bonus` varchar(500) NOT NULL, ";
		$sql .= " `read_reviews` varchar(500), ";
		$sql .= " `accepts_us_players` varchar(500), ";
		$sql .= " `available_games` varchar(500) NOT NULL, ";
		$sql .= " `payment_method` varchar(500), ";
		$sql .= " `features` varchar(500), ";
		$sql .= " `rating` varchar(50) NOT NULL, ";
        $sql .= " `created` varchar(100) NOT NULL,";
        $sql .= " `status` varchar(100) NOT NULL, ";
        $sql .= " `order` varchar(100) NOT NULL, ";
        $sql .= " `region` varchar(100) NOT NULL, ";
		$sql .= " PRIMARY KEY `customer_id` (`id`) ";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

		// Include Upgrade Script
		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	
		// Create Table
		dbDelta( $sql );
	}

}

add_shortcode('onlinecasinoshortcode','onlinecasinoshortcode_fun');

function onlinecasinoshortcode_fun($attr){
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . '/inc/onlinecasino-shortcode-list.php';
    return ob_get_clean();
}

// 

add_action('wp_ajax_delete_casino_post', 'delete_casino_post'); // For logged-in users
add_action('wp_ajax_nopriv_delete_casino_post', 'delete_casino_post'); 

function delete_casino_post(){
	$response = array("valid"=>false);
	$parameter1 = $_POST['parameter1'];
	$response['parameter1'] = $parameter1;


	global $wpdb;
	$tablename = $wpdb->prefix . 'onlinecasino_list';

	$data_to_update = array(
		'status' => '0'
	);
	
	$where_condition = array(
		'id' => $parameter1,
	);
	if(isset($parameter1) && !empty($parameter1)){
		$update = $wpdb->update($tablename, $data_to_update, $where_condition);
		if($update){
			$response['valid'] = true;
		}

	}
	
	wp_send_json($response);
	wp_die();
}



function returnRegionCasino(){
	// Get user's IP address (you may need to use a more reliable method in production)
$userIpAddress = $_SERVER['REMOTE_ADDR'];
// Make a request to ipinfo.io to get country and state information
$url = "https://ipinfo.io/{$userIpAddress}/json";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$decode = json_decode($response);

if(isset($decode->region) && isset($decode->country)){
    $state = $decode->region;
    $country = $decode->country;
	return $state;
}
else{
	return 0;
}

}