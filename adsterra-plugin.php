<?php
/*
	Plugin Name: Adsterra Publisher Dashboard
	Description: Monitor your revenue and Impressions from Wordpress, for you Adsterra Ad Network Publisher account.
	Version: 1.0.0
	Tested: 5.4.2
	Requires at least: 5.4.2
	Author: XavierB
	Author URI: https://www.entertainaholic.com/
	License: GPL-2.0+
	License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/
if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new Smashing_Updater( __FILE__ );
$updater->set_username( 'ziyaad30' );
$updater->set_repository( 'adsterra-publisher-dashboard' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$updater->initialize();

// Add setting link under plugins
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'adsterra_settings_link' );
function adsterra_settings_link( array $links ) 
{
	$url = get_admin_url() . "admin.php?page=adsterra&tab=settings";
	
	//Setting link
	$settings_link = '<a href="' . $url . '">' . __('Settings', 'textdomain') . '</a>';
	$links[] = $settings_link;
	
	//Website link
	$website_link = '<a href="https://www.entertainaholic.com">Website</a>';
	$links[] = $website_link;
	return $links;
}

// Register the fields
function adsterra_register_settings() {
	add_option( 'adsterra_option_apikey', '');
	add_option( 'adsterra_option_check', '');
	register_setting( 'adsterra_options_group', 'adsterra_option_apikey', 'adsterra_callback' );
	register_setting( 'adsterra_options_group', 'adsterra_option_check', 'adsterra_callback' );
}
add_action( 'admin_init', 'adsterra_register_settings' );

// Register the options/settings page
function adsterra_register_options_page() {
	add_menu_page('Adsterra Dashboard', 'Adsterra Dashboard', 'manage_options', 'adsterra', 'adsterra_options_page');
}
add_action('admin_menu', 'adsterra_register_options_page');

// The options/settings page
function adsterra_options_page()
{
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	//Get the active tab from the $_GET param
	$default_tab = null;
	$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>
<!-- Our admin page content should all be inside .wrap -->
  <div class="wrap">
	  
	  <!-- Print the page title -->
	  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	  
	  <!-- Here are our tabs -->
	  <nav class="nav-tab-wrapper">
		  <a href="?page=adsterra" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Dashboard</a>
		  <a href="?page=adsterra&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
	  </nav>
	  
	  <div class="tab-content">
		  <?php switch($tab) :
	case 'settings':
	
	include 'adsterra_opts.php';
	
	break;
	default:
	
	include 'adsterra_stats.php';
	
	break;
	endswitch;
		  ?>
	  </div>
</div>
<?php
}
