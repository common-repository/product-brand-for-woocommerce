<?php 
/**
* Plugin Name: Product Brand For Woocommerce
* Description: This plugin allows create Product Brand plugin.
* Version: 1.0
* Copyright: 2020
* Text Domain: product-brand-for-woocommerce
* Domain Path: /languages 
*/

if (!defined('ABSPATH')) {
   	die('-1');
}
if (!defined('PRODUCTBRANDS_PLUGIN_NAME')) {
   	define('PRODUCTBRANDS_PLUGIN_NAME', 'Product Brands For Woocommerce');
}
if (!defined('PRODUCTBRANDS_PLUGIN_VERSION')) {
   	define('PRODUCTBRANDS_PLUGIN_VERSION', '1.0.0');
}
if (!defined('PRODUCTBRANDS_PLUGIN_FILE')) {
   	define('PRODUCTBRANDS_PLUGIN_FILE', __FILE__);
}
if (!defined('PRODUCTBRANDS_PLUGIN_DIR')) {
   	define('PRODUCTBRANDS_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('PRODUCTBRANDS_BASE_NAME')) {
    define('PRODUCTBRANDS_BASE_NAME', plugin_basename(PRODUCTBRANDS_PLUGIN_FILE));
}
if (!defined('PRODUCTBRANDS_DOMAIN')) {
   	define('PRODUCTBRANDS_DOMAIN', 'product-brands-for-woocommerce');
}
if (!class_exists('PRODUCTBRANDS')) {

    class PRODUCTBRANDS {

        function __construct(){
            $this->init();
            $this->includes();
        }
        
        function includes() {
            include_once('includes/pb_comman.php');
            include_once('includes/pb_admin.php');
            include_once('includes/pb_kit.php');
            include_once('includes/pb_frontend.php');
        }
        
        function init() {
            add_action( 'admin_enqueue_scripts', array($this,'our_product_brands_load_admin_script_style'));
            add_action( 'wp_enqueue_scripts',   array($this,'our_product_brands_load_script_style'));
            add_action( 'wp_enqueue_media',   array($this,'load_media'));
            add_filter( 'plugin_row_meta', array( $this, 'PRODUCTBRANDS_plugin_row_meta' ), 10, 2 );
        }


        function PRODUCTBRANDS_plugin_row_meta( $links, $file ) {
            if ( PRODUCTBRANDS_BASE_NAME === $file ) {
                $row_meta = array(
                  'rating'    =>  ' <a href="https://www.xeeshop.com/product-brand-for-woocommerce/" target="_blank">Documentation</a> | <a href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/product-brand-for-woocommerce/reviews/?filter=5" target="_blank"><img src="'.PRODUCTBRANDS_PLUGIN_DIR.'/images/star.png" class="pb_rating_div"></a>',
                );
                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }

        function our_product_brands_load_admin_script_style() {
            wp_enqueue_style( 'our_product_brands-back-style', PRODUCTBRANDS_PLUGIN_DIR . '/asset/css/backend_style.css', false, '1.0.0' );
            wp_enqueue_script( 'back_script', PRODUCTBRANDS_PLUGIN_DIR . '/asset/js/back_script.js');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker-alpha', PRODUCTBRANDS_PLUGIN_DIR . '/asset/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
            wp_enqueue_media();
            wp_upload_dir();
        }
        

        function our_product_brands_load_script_style() {

            global $ocpbrandw_comman;

            wp_enqueue_style( 'our_product_brands-front-style', PRODUCTBRANDS_PLUGIN_DIR . '/asset/css/front_style.css', false, '1.0.0' );
            wp_enqueue_script( 'front_script', PRODUCTBRANDS_PLUGIN_DIR . '/asset/js/front_script.js', array("jquery"));
            wp_enqueue_script( 'OWl-owlcarousel', PRODUCTBRANDS_PLUGIN_DIR . '/asset/js/owlcarousel/owl.carousel.js' );
            wp_enqueue_style( 'owlcarousel-min', PRODUCTBRANDS_PLUGIN_DIR . '/asset/js/owlcarousel/assets/owl.carousel.min.css', false, '1.0.0' );
            wp_enqueue_style( 'owlcarousel-theme',PRODUCTBRANDS_PLUGIN_DIR .'/asset/js/owlcarousel/assets/owl.theme.default.min.css', false,'1.0.0' );
            
            $ocpbrandw_autoplay_slider =  $ocpbrandw_comman['ocpbrandw_autoplay_slider'];
            $ocpbrandw_autopaly_speed =  $ocpbrandw_comman['ocpbrandw_autopaly_speed'];
            $ocpbrandw_navi = $ocpbrandw_comman['ocpbrandw_navi'];
            $ocpbrandw_autoscrollfocus = $ocpbrandw_comman['ocpbrandw_autoscrollfocus']; 
            $ocpbrandw_tablet = $ocpbrandw_comman['ocpbrandw_tablet']; 
            $ocpbrandw_mobile = $ocpbrandw_comman['ocpbrandw_mobile']; 
            $ocpbrandw_desktop = $ocpbrandw_comman['ocpbrandw_desktop'];

            $data = array(

                'ocpbrandw_autoplay_slider' => $ocpbrandw_autoplay_slider,
                'ocpbrandw_autopaly_speed'=>$ocpbrandw_autopaly_speed,
                'ocpbrandw_navi' =>$ocpbrandw_navi,
                'ocpbrandw_autoscrollfocus' => $ocpbrandw_autoscrollfocus,
                'ocpbrandw_tablet'=>$ocpbrandw_tablet,
                'ocpbrandw_mobile'=>$ocpbrandw_mobile,
                'ocpbrandw_desktop'=>$ocpbrandw_desktop

            );

            wp_localize_script( 'front_script', 'OCBRANDWdata', $data  );

        }
        
        function load_media() {
            wp_enqueue_media();
        }
    }
  new PRODUCTBRANDS();
}


add_action( 'plugins_loaded', 'pb_load_textdomain' );
function pb_load_textdomain() {
    load_plugin_textdomain( 'product-brand-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function pb_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'product-brand-for-woocommerce' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'pb_load_my_own_textdomain', 10, 2 );


?>