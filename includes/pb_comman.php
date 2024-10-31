<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('OCPBRANDW_comman')) {

    class OCPBRANDW_comman {

        protected static $instance;

        public static function instance() {

            if (!isset(self::$instance)) {

                self::$instance = new self();

                self::$instance->init();

            }
            
             return self::$instance;
        }


                  

        function init() {

               global $ocpbrandw_comman;

               $optionget = array(

                'enable_disable_plugin' => 'yes',

                'ocpbrandw_autoplay_slider'=>'yes',

                'ocpbrandw_autopaly_speed'=>'5000',

                'ocpbrandw_navi'=>'arrows',

                'ocpbrandw_autoscrollfocus'=>'yes',

                'ocpbrandw_tablet'=>'2',

                'ocpbrandw_mobile'=>'2',

                'ocpbrandw_desktop'=>'3',

                'ocpbrandw_show_brand_title' => 'yes',

                'ocpbrandw_show_brand_single_page' => 'yes',
                
                'ocpbrandw_slider_or_loop' => 'slider',

                'ocpbrandw_add_to_back_color' =>'#000000',

                'ocpbrandw_add_to_text_color' => '#ffffff',

                'Single_brand_position' => 'before_add_to_cart_form',

                'shop_page_brand_show' => '',

                'brand_title_text' => 'Brand',

                'brand_image_size' => '50',

                'show_brand_view_shop' => 'only_title',

                'show_brand_view_single_product' => 'both',
 
               );

            foreach ($optionget as $key_optionget => $value_optionget) {

               $ocpbrandw_comman[$key_optionget] = get_option( $key_optionget,$value_optionget );
               
            }
        }

    }
    OCPBRANDW_comman::instance();
}