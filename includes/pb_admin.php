<?php 

if (!defined('ABSPATH'))
  exit;


/*============ Start form Woocommerce Product Brands code ================= */

if (!class_exists('PRODUCTBRANDS_ADMIN')) {

    class PRODUCTBRANDS_ADMIN {

        protected static $PRODUCTBRANDS_ADMIN_instance;

        public static function PRODUCTBRANDS_ADMIN_instance() {
            if (!isset(self::$PRODUCTBRANDS_ADMIN_instance)) {
                self::$PRODUCTBRANDS_ADMIN_instance = new self();
                self::$PRODUCTBRANDS_ADMIN_instance->init();
            }
            return self::$PRODUCTBRANDS_ADMIN_instance;
        }

        function init() {

            add_action( 'init', array($this,'ocpbw_create_brands' ));
            add_action( 'brands_add_form_fields', array($this,'ocpbw_add_category_image' ));
            add_action( 'created_brands', array($this,'ocpbw_save_category_image' ));
            add_action( 'brands_edit_form_fields', array($this,'ocpbw_update_category_image' ));
            add_action( 'edited_brands', array($this,'ocpbw_updated_category_image' ));
            add_filter('manage_edit-brands_columns', array($this,'ocpbw_manage_my_category_columns'));
            add_filter ('manage_brands_custom_column', array($this,'ocpbw_manage_category_custom_fields'), 10,3);
            add_action('admin_menu', array($this, 'ocpbw_admin_menu') );
            add_action( 'init',  array($this, 'OCWG_save_options'));
        }

        
        function ocpbw_admin_menu() {
            add_menu_page(
                __( 'Brands Setting', 'product-brands-for-woocommerce' ),
                __( 'Brands Setting', 'product-brands-for-woocommerce' ),
                'manage_options',
                'ocwpb-brand-general-setting',
                array($this,'ocpbrandw_general_setting'),
                'dashicons-tag',
                10
            );
        }

        /* general setting */
        function ocpbrandw_general_setting() {
             global $ocpbrandw_comman; ?>

            <div class="wrap">
                <h2><?php echo __('Brands Settings','product-brands-for-woocommerce');?></h2>
            </div>
            <div class="ocpbrandw_container">
                <form method="post" class="oc_ocpbrandw">
                    <?php wp_nonce_field( 'ocpbrandw_nonce_action', 'ocpbrandw_nonce_field' ); ?>
                    <div class="ocpbrandw_table_main">
                        <h2>General Slider Setting</h2>
                        <table class="ocpbrandw_table">
                            <tr>
                                <th><label><?php echo __('Enable/disable Plugin','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="checkbox" name="ocpbrandw_comman[enable_disable_plugin]" value="yes" <?php if ($ocpbrandw_comman['enable_disable_plugin'] == "yes" ) { echo 'checked="checked"'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('AutoPlay','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="checkbox" name="ocpbrandw_comman[ocpbrandw_autoplay_slider]" value="yes" <?php if ($ocpbrandw_comman['ocpbrandw_autoplay_slider'] == "yes" ) { echo 'checked="checked"'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('AutoPlay Speed','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="number" class="regular-text" name="ocpbrandw_comman[ocpbrandw_autopaly_speed]" value="<?php echo $ocpbrandw_comman['ocpbrandw_autopaly_speed']; ?>">
                                </td>
                            </tr>
                            <tr class="item_slider_section">
                                <th><label><?php echo __('Number Of Item in slider','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="number" class="regular-text" name="ocpbrandw_comman[ocpbrandw_desktop]" value="<?php echo $ocpbrandw_comman['ocpbrandw_desktop']; ?>"><label>In Desktop</label><br>
                                    <input type="number" class="regular-text" name="ocpbrandw_comman[ocpbrandw_tablet]" value="<?php echo $ocpbrandw_comman['ocpbrandw_tablet']; ?>"><label>In Tablet</label><br>
                                    <input type="number" class="regular-text" name="ocpbrandw_comman[ocpbrandw_mobile]" value="<?php echo $ocpbrandw_comman['ocpbrandw_mobile']; ?>"><label>In Mobile</label>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Navigation','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <label class="radio_label" for="Arrows">Arrows</label>
                                    <input type="radio" id="Arrows" name="ocpbrandw_comman[ocpbrandw_navi]" value="arrows" <?php if ($ocpbrandw_comman['ocpbrandw_navi'] == "arrows" ) { echo 'checked'; } ?>>
                                    <label class="radio_label" for="Dots">Dots</label>
                                    <input type="radio" id="Dots" name="ocpbrandw_comman[ocpbrandw_navi]" value="dots" <?php if ($ocpbrandw_comman['ocpbrandw_navi'] == "dots" ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Autoscroll stop on focus','product-brands-for-woocommerce');?></label></th>
                                <td>
                                   <input type="checkbox" name="ocpbrandw_comman[ocpbrandw_autoscrollfocus]" value="yes" <?php if ($ocpbrandw_comman['ocpbrandw_autoscrollfocus'] == "yes" ) { echo 'checked="checked"'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show Brand Title In Slider','product-brands-for-woocommerce');?></label></th>
                                <td>
                                   <input type="checkbox" name="ocpbrandw_comman[ocpbrandw_show_brand_title]" value="yes" <?php if ($ocpbrandw_comman['ocpbrandw_show_brand_title'] == "yes" ) { echo 'checked="checked"'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show Slider or Loop in Brand','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <label class="radio_label" for="slider">Slider</label>
                                    <input type="radio" id="slider" name="ocpbrandw_comman[ocpbrandw_slider_or_loop]" value="slider" <?php if ($ocpbrandw_comman['ocpbrandw_slider_or_loop'] == "slider" ) { echo 'checked'; } ?>>
                                    <label class="radio_label" for="Loop">Loop</label>
                                    <input type="radio" id="Loop" name="ocpbrandw_comman[ocpbrandw_slider_or_loop]" value="loop" <?php if ($ocpbrandw_comman['ocpbrandw_slider_or_loop'] == "loop" ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Add to cart Background color ','product-brands-for-woocommerce');?></label></th>

                                <td>

                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocpbrandw_comman['ocpbrandw_add_to_back_color']; ?>" name="ocpbrandw_comman[ocpbrandw_add_to_back_color]" value="<?php echo $ocpbrandw_comman['ocpbrandw_add_to_back_color']; ?>"/>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Add to cart text color ','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocpbrandw_comman['ocpbrandw_add_to_text_color']; ?>" name="ocpbrandw_comman[ocpbrandw_add_to_text_color]" value="<?php echo $ocpbrandw_comman['ocpbrandw_add_to_text_color']; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show Brand Item In Single Page','product-brands-for-woocommerce');?></label></th>
                                <td>
                                   <input type="checkbox" name="ocpbrandw_comman[ocpbrandw_show_brand_single_page]" value="yes" <?php if ($ocpbrandw_comman['ocpbrandw_show_brand_single_page'] == "yes" ) { echo 'checked="checked"'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show Brand Item In Shop Page','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="checkbox" name="ocpbrandw_comman[shop_page_brand_show]" value="yes" <?php if($ocpbrandw_comman['shop_page_brand_show'] == 'yes'){echo "checked";}?>>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Single Product Page Brand Position','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <select name="ocpbrandw_comman[Single_brand_position]" class="regular-text">
                                        <option value="before_title" <?php if($ocpbrandw_comman['Single_brand_position'] == 'before_title'){echo "selected";}; ?>>Before Title</option>
                                        <option value="after_title" <?php if($ocpbrandw_comman['Single_brand_position'] == 'after_title'){echo "selected";}; ?>>After Title</option>
                                        <option value="after_price" <?php if($ocpbrandw_comman['Single_brand_position'] == 'after_price'){echo "selected";}; ?>>After Price</option>
                                        <option value="before_add_to_cart_form" <?php if($ocpbrandw_comman['Single_brand_position'] == 'before_add_to_cart_form'){echo "selected";}; ?>>Before Add To Cart Form</option>
                                        <option value="after_add_to_cart_form" <?php if($ocpbrandw_comman['Single_brand_position'] == 'after_add_to_cart_form'){echo "selected";}; ?>>After Add To Cart Form</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Brand image size','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="number" class="regular-text" name="ocpbrandw_comman[brand_image_size]" value="<?php echo $ocpbrandw_comman['brand_image_size']?>">
                                    <p class="oc_desc">Brand image size in px.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Brand title text','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <input type="text" class="regular-text" name="ocpbrandw_comman[brand_title_text]" value="<?php echo $ocpbrandw_comman['brand_title_text'];?>">
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show brands view in shop loop','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <select name="ocpbrandw_comman[show_brand_view_shop]" class="regular-text">
                                        <option value="only_image" <?php if($ocpbrandw_comman['show_brand_view_shop'] == 'only_image'){echo "selected";}?>>Only Image</option>
                                        <option value="only_title" <?php if($ocpbrandw_comman['show_brand_view_shop'] == 'only_title'){echo "selected";}?>>Only Title</option>
                                        <option value="both" <?php if($ocpbrandw_comman['show_brand_view_shop'] == 'both'){echo "selected";}?>>Both</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label><?php echo __('Show brands view in single product','product-brands-for-woocommerce');?></label></th>
                                <td>
                                    <select name="ocpbrandw_comman[show_brand_view_single_product]" class="regular-text">
                                        <option value="only_image" <?php if($ocpbrandw_comman['show_brand_view_single_product'] == 'only_image'){echo "selected";}?>>Only Image</option>
                                        <option value="only_title" <?php if($ocpbrandw_comman['show_brand_view_single_product'] == 'only_title'){echo "selected";}?>>Only Title</option>
                                        <option value="both" <?php if($ocpbrandw_comman['show_brand_view_single_product'] == 'both'){echo "selected";}?>>Both</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="ocpbrandw_notes">
                            <ul class="ocpbrandw_notes_ul">
                                <li><?php echo __('1) get all brand then shorcode use <strong> [product-brands] </strong>','product-brands-for-woocommerce');?></li>
                                <li><?php echo __('2) brand wise product get then shorcode use 
                                            <strong> [product-brands brands="your term slug"] </strong> ','product-brands-for-woocommerce');?></li>
                                <li><?php echo __('<strong>ex.[product-brands brands="tesing-1"] </strong>','product-brands-for-woocommerce');?></li>
                                <li><?php echo __('3) how many number of post then add post per page in shorcode like','product-brands-for-woocommerce');?></li>
                                <li><?php echo __('<strong> ex.[product-brands brands="tesing-1" post_per_page=4]  </strong>','product-brands-for-woocommerce');?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ocpbrandw_save_options">
                        <input type="hidden" name="action" value="ocpbrandw_save_option">
                        <input type="submit" value="Save changes" name="submit" class="button-primary" id="ocpbrandw-btn-space">
                    </div>
                </form>
            </div>

            <?php 
           
        }

        function OCWG_save_options(){

            if( current_user_can('administrator') ) {

                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ocpbrandw_save_option') {

                    if(!isset( $_POST['ocpbrandw_nonce_field'] ) || !wp_verify_nonce( $_POST['ocpbrandw_nonce_field'], 'ocpbrandw_nonce_action' ) ){
                        print 'Sorry, your nonce did not verify.';
                        exit;
                    } else {

                        $isecheckbox = array(
                            'enable_disable_plugin',
                            'ocpbrandw_autoplay_slider',
                            'ocpbrandw_autoscrollfocus',
                            'ocpbrandw_show_brand_title',
                            'ocpbrandw_show_brand_single_page',
                            'shop_page_brand_show',
                            'show_brand_image_shop',
                            'show_brand_image_single_product'
                        );

                        foreach ($isecheckbox as $key_isecheckbox => $value_isecheckbox) {
                            if(!isset($_REQUEST['ocpbrandw_comman'][$value_isecheckbox])){
                                $_REQUEST['ocpbrandw_comman'][$value_isecheckbox] ='no';
                            }
                        }
                        
                        foreach ($_REQUEST['ocpbrandw_comman'] as $key_ocpbrandw_comman => $value_ocpbrandw_comman) {
                            update_option($key_ocpbrandw_comman, sanitize_text_field($value_ocpbrandw_comman), 'yes');
                        }

                        wp_redirect( admin_url( '/admin.php?page=ocwpb-brand-general-setting' ) );
                        exit;
                    }
                }
            }
        }

           

        function ocpbw_create_brands() {

            $labels = array(
                'name'              => _x( 'Brands', 'taxonomy general name', 'textdomain' ),
                'singular_name'     => _x( 'Brand', 'taxonomy singular name', 'textdomain' ),
                'search_items'      => __( 'Search Brands', 'textdomain' ),
                'all_items'         => __( 'All Brands', 'textdomain' ),
                'parent_item'       => __( 'Parent Brand', 'textdomain' ),
                'parent_item_colon' => __( 'Parent Brand:', 'textdomain' ),
                'edit_item'         => __( 'Edit Brand', 'textdomain' ),
                'update_item'       => __( 'Update Brand', 'textdomain' ),
                'add_new_item'      => __( 'Add New Brand', 'textdomain' ),
                'new_item_name'     => __( 'New Brand Name', 'textdomain' ),
                'menu_name'         => __( 'Brand', 'textdomain' ),
            );
         
            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'brand' ),
            );


            register_taxonomy('brands','product',$args);


        }


        function ocpbw_add_category_image ($taxonomy) { ?>

            <div class="form-field">
                <label for="brands-logo-id"><?php echo __('Brands Logo','product-brands-for-woocommerce'); ?></label>
                <input type="hidden" id="brands-logo-id" name="brands-logo-id" class="custom_media_url" value="">
                <div id="brands-logo-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php echo __('Add Brands Logo','product-brands-for-woocommerce'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php echo __('Remove Brands Logo','product-brands-for-woocommerce'); ?>" />
                </p>
            </div>

           <?php
        }


        function ocpbw_save_category_image ( $term_id) {

            if( isset( $_POST['brands-logo-id'] ) && '' !== $_POST['brands-logo-id'] ){
                $image = sanitize_text_field($_POST['brands-logo-id']);
                add_term_meta( $term_id, 'brands-logo-id', $image, true );
            }
        }

        function ocpbw_update_category_image ( $term) { ?>

            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="brands-logo-id"><?php echo __( 'Brands Logo','product-brands-for-woocommerce' ); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta ( $term->term_id, 'brands-logo-id', true ); ?>
                    <input type="hidden" id="brands-logo-id" name="brands-logo-id" value="<?php echo $image_id; ?>">
                    <div id="brands-logo-wrapper">
                        <?php if ( $image_id ) { ?>
                            <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
                        <?php }elseif ( empty($image_id) ) {
                        echo "<img src='".wc_placeholder_img_src()."'>";
                        } ?>
                    </div>
                    <p>
                       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php echo __( 'Add Brands Logo','product-brands-for-woocommerce'); ?>" />
                       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php echo __( 'Remove Brands Logo','product-brands-for-woocommerce' ); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        function ocpbw_updated_category_image ( $term_id) {

            if( isset( $_POST['brands-logo-id'] ) && '' !== $_POST['brands-logo-id'] ){
                $image = sanitize_text_field($_POST['brands-logo-id']);
                update_term_meta ( $term_id, 'brands-logo-id', $image );
            } else {
                update_term_meta ( $term_id, 'brands-logo-id', '' );
            }

        }

        function ocpbw_manage_my_category_columns($columns){
            // add 'My Column'
            $columns['brands_logo'] = 'Logo';
            return $columns;
        }


        function ocpbw_manage_category_custom_fields($deprecated,$column_name,$term_id){

            if ($column_name == 'brands_logo') {?>
                <?php $image_id = get_term_meta( $term_id, 'brands-logo-id', true ); ?>
                    <input type="hidden" id="brands-logo-id" name="brands-logo-id" value="<?php echo $image_id; ?>">
                    <div id="brands-logo-wrapper">
                        <?php if ( $image_id ) {?>
                            <?php echo wp_get_attachment_image ( $image_id, 'thumbnail'); ?>
                        <?php } ?>
                    </div>
                <?php
            }
        }
    }

    PRODUCTBRANDS_ADMIN::PRODUCTBRANDS_ADMIN_instance();  
}

/*============ End form Woocommerce Product Brands code ================= */
?>