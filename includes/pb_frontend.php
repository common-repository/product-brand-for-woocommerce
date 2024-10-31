<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('PRODUCTBRANDS_FRONTEND')) {

    class PRODUCTBRANDS_FRONTEND {

      protected static $PRODUCTBRANDS_FRONTEND_instance;

        public static function PRODUCTBRANDS_FRONTEND_instance() {
            if (!isset(self::$PRODUCTBRANDS_FRONTEND_instance)) {
                self::$PRODUCTBRANDS_FRONTEND_instance = new self();
                self::$PRODUCTBRANDS_FRONTEND_instance->init();
            }
            return self::$PRODUCTBRANDS_FRONTEND_instance;
        }

      	function init() {
      		global $ocpbrandw_comman;
      		if ($ocpbrandw_comman['Single_brand_position'] == 'before_title') {
      			$position = 1;
      		}elseif($ocpbrandw_comman['Single_brand_position'] == 'after_title') {
      			$position = 10;
      		}elseif($ocpbrandw_comman['Single_brand_position'] == 'after_price') {
      			$position = 20;
      		}elseif($ocpbrandw_comman['Single_brand_position'] == 'before_add_to_cart_form') {
      			$position = 30;
      		}elseif($ocpbrandw_comman['Single_brand_position'] == 'after_add_to_cart_form') {
      			$position = 40;
      		}else{
      			$position = 50;
      		}
      		if ($ocpbrandw_comman['enable_disable_plugin'] == 'yes') {
	        	add_action( 'woocommerce_single_product_summary', array($this,'ocpbw_production_time'), $position );
	        	if ($ocpbrandw_comman['shop_page_brand_show'] == 'yes') {
	        		add_action( 'woocommerce_after_shop_loop_item_title', array($this, 'ocpbw_production_loop_brand') );
	        	}
	            add_shortcode('product-brands',array($this,'ocpbw_pb_brands_slider'));
	            add_action('wp_footer' , array($this,'ocpbw_custom_style'));
	        }
  		}

        function ocpbw_production_loop_brand() {
			global $post, $ocpbrandw_comman;
			if ($ocpbrandw_comman['brand_title_text'] == "") {
				$brand_title = 'Brand';
			}else{
				$brand_title = $ocpbrandw_comman['brand_title_text'];
			}
			$brand_view = $ocpbrandw_comman['show_brand_view_shop'];
			if ($ocpbrandw_comman['ocpbrandw_show_brand_single_page'] == "yes" ){
				$term_obj_list = get_the_terms( $post->ID, 'brands');
				if (!empty($term_obj_list)) {?>
					<div class="Brands_main_div_shop">
						<label class="Brands_title"><h4 style="margin: 0px;"><?php echo $brand_title;?> : </h4></label>
						<?php
						foreach ($term_obj_list as $value) {
							$term_id = $value->term_id; // for get term id 
							$thumbnail_id = get_term_meta( $term_id, 'brands-logo-id', true );
							$image = wp_get_attachment_url( $thumbnail_id );
							$image_id = get_term_meta ( $term_id, 'brands-logo-id', true );
							if ( empty($image_id) ) {
								$img_src = wc_placeholder_img_src();
							}else{
								$img_src = $image;
							}
							$image_brand = '<img src="'.$img_src.'" alt="" width="50" height="50" />';
							if ($brand_view == 'only_title') {
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'"><span>'.$value->name.'</span></a>';
							}elseif($brand_view == 'only_image'){
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'">'.$image_brand.'</a>';
							}else{
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'">'.$image_brand.'<span>'.$value->name.'</span></a>';
							}
						}
						?>
					</div>
					<?php
				}
			}
		}

		function ocpbw_production_time() {
			global $post, $ocpbrandw_comman;
			if ($ocpbrandw_comman['brand_title_text'] == "") {
				$brand_title = 'Brand';
			}else{
				$brand_title = $ocpbrandw_comman['brand_title_text'];
			}
			$brand_view = $ocpbrandw_comman['show_brand_view_single_product'];
			if ($ocpbrandw_comman['ocpbrandw_show_brand_single_page'] == "yes" ){
				$term_obj_list = get_the_terms( $post->ID, 'brands');
				if (!empty($term_obj_list)) {?>
					<div class="Brands_main_div">
						<label class="Brands_title"><h4 style="margin: 0px;"><?php echo $brand_title;?> : </h4></label>
						<?php
						foreach ($term_obj_list as $value) {
							$term_id = $value->term_id; // for get term id 
							$thumbnail_id = get_term_meta( $term_id, 'brands-logo-id', true );
							$image = wp_get_attachment_url( $thumbnail_id );
							$image_id = get_term_meta ( $term_id, 'brands-logo-id', true );
							if ( empty($image_id) ) {
								$img_src = wc_placeholder_img_src();
							}else{
								$img_src = $image;
							}
							$image_brand = '<img src="'.$img_src.'" alt="" width="50" height="50" />';
							if ($brand_view == 'only_title') {
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'"><span>'.$value->name.'</span></a>';
							}elseif($brand_view == 'only_image'){
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'">'.$image_brand.'</a>';
							}else{
								echo '<a href="'.get_term_link($value).'" title="'.$value->name.'">'.$image_brand.'<span>'.$value->name.'</span></a>';
							}
						}
						?>
					</div>
					<?php
				}
			}
		}		

		function ocpbw_pb_brands_slider($Product_various_brand) {
			global $ocpbrandw_comman;
			ob_start();
			if(!empty($Product_various_brand)){
				if(!empty($Product_various_brand['post_per_page'])){
					$post_per_page = $Product_various_brand['post_per_page'];
				}else{
					$post_per_page = -1;
				}

				$ocpbrandterm_name = $Product_various_brand['brands'];
				if(!empty($ocpbrandterm_name )){
					$argddds = array(
		                'post_type'=> 'product',
		                'posts_per_page' => $post_per_page,
		                'tax_query' => array(
		                    array(
		                        'taxonomy'      =>'brands',
		                        'field'         => 'slug',
		                        'terms' => $ocpbrandterm_name ,
		                    )
		                )
		            );
		            $loop = new WP_Query($argddds);  
		            if($ocpbrandw_comman['ocpbrandw_slider_or_loop'] == "slider") {  ?>
			            <div class="ocpbw_product_brand">
							<div class="ocwbrandproduct_slider">
								<div class="wpb_slider owl-carousel owl-theme">
									<?php								
					              	while ($loop->have_posts()): $loop->the_post();
				              			$product_object = wc_get_product( get_the_ID());?>
				              			<div class="item wfc_gift_product">
						              		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );?>
				    						<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $loop->post->ID; ?>">
				    						<p class="suncategory_title"><?php  echo get_the_title(); ?></p>
				    						<p><?php echo $product_object->get_price_html(); ?></p>
						              		<?php echo '<a style="background-color:'.$ocpbrandw_comman['ocpbrandw_add_to_back_color'].';color:'.$ocpbrandw_comman['ocpbrandw_add_to_text_color'].';" href="'.esc_url( $product_object->add_to_cart_url() ) .'" class="buy-now_oc button  add_to_cart_button ">'.esc_html__( 'Add To Cart', 'text-domain' ).'</a>'; ?>
					              		</div>
					              		<?php
					              	endwhile; ?>
			          			</div>
			          		</div>
			          	</div>
		            <?php }else{  ?>
	            		<div class="loop_in_brand">
		            		<?php
		            		woocommerce_product_loop_start(); 
						       	while ($loop->have_posts()): $loop->the_post();
						       		wc_get_template_part( 'content', 'product' );
						       	endwhile;
					       	woocommerce_product_loop_end();
					       	?>
					    </div>
				       	<?php
		            }
	            }
			}else{
				$taxonomy     = 'brands';
				$orderby      = 'name';  
				$show_count   = 0;      // 1 for yes, 0 for no
				$pad_counts   = 0;      // 1 for yes, 0 for no
				$hierarchical = 0;      // 1 for yes, 0 for no  
				$title        = '';  
				$empty        = 0;
				$args = array(
			     	'taxonomy'     => $taxonomy,
			     	'orderby'      => $orderby,
			     	'show_count'   => $show_count,
			     	'pad_counts'   => $pad_counts,
			     	'hierarchical' => $hierarchical,
			     	'title_li'     => $title,
			     	'hide_empty'   => $empty
				);
				$all_categories = get_categories($args);
				if (!empty($all_categories)) {?>
					<div class="ocwbrandproduct_slider">
						<div class="wpb_slider owl-carousel owl-theme">
							<?php 
							foreach ($all_categories as $value) {
								$term_id = $value->term_id; 
								$thumbnail_id = get_term_meta( $term_id, 'brands-logo-id', true );
								$image = wp_get_attachment_image_src($thumbnail_id ,'thumbnail');
								$image_id = get_term_meta($term_id, 'brands-logo-id', true );
								if(!empty($image_id)){
									if ($ocpbrandw_comman['ocpbrandw_show_brand_title'] == "yes") {
										$title_brand = '<strong>'.$value->name.'</strong>';
									}else {
										$title_brand = "";
									}
									?>
									<div class="item wfc_gift_product">
										<span>
											<?php echo '<a href="'.get_term_link($value).'" title="'.$value->name.'"><img src="'.$image[0].'" alt="" />'.$title_brand.'</a>';?>
										</span>
									</div>
								<?php }elseif(empty($image_id)){ 
									if ($ocpbrandw_comman['ocpbrandw_show_brand_title'] == "yes") {
										$title_brand_2 = '<strong>'.$value->name.'</strong>';
									}else {
										$title_brand_2 = "";
									}
									?>
									<div class="item wfc_gift_product">
										<span>
											<?php echo '<a href="'.get_term_link($value).'" title="'.$value->name.'"><img src="'.wc_placeholder_img_src().'" alt=""  />'.$title_brand_2.'</a>';?>
										</span>
									</div>
									<?php
								}
							}?>	
						</div>
					</div>
					<?php 
				} 
			}
			$output = ob_get_contents();
		    ob_end_clean(); 
		    return  $output; 
		}

		function ocpbw_custom_style(){ 
			global $ocpbrandw_comman; 
			if($ocpbrandw_comman['brand_image_size'] == ''){
				$brand_image_size = 50;
			}else{
				$brand_image_size = $ocpbrandw_comman['brand_image_size'];
			}
			?>
			<style type="text/css">
				.loop_in_brand a.add_to_cart_button {
					background-color: <?php echo $ocpbrandw_comman['ocpbrandw_add_to_back_color']; ?>;
					color: <?php echo $ocpbrandw_comman['ocpbrandw_add_to_text_color']; ?>!important;;
				}
				.Brands_main_div img,.Brands_main_div_shop img {
				    width: <?php echo $brand_image_size;?>px !important;
				}
			</style>
			<?php 
		}
  	}
    PRODUCTBRANDS_FRONTEND::PRODUCTBRANDS_FRONTEND_instance();  
}