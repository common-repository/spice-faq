<?php 
if ( ! function_exists( 'spice_faq_shortcode' ) ) {
 
    function spice_faq_shortcode( $atts ) {
		
		wp_enqueue_script("spice-faq-js", SPICE__PLUGIN_URL  . '/include/assets/faq-custom-js.js');
		wp_enqueue_style("spice-faq-css", SPICE__PLUGIN_URL  . '/include/assets/faq-css.css');
			
        $output = '';
         
        // set the query arguments
        $query_args = apply_filters( 'spice_faq_defaults',array(
           
            'posts_per_page'    =>   100,
          
            'post_type'         =>   'spice_faq',
           
            'no_found_rows'     =>   true,
        ));
         
        
        // get the posts with our query arguments
        $faq_posts = get_posts( $query_args );
		
         
        // handle our custom loop
       foreach ( $faq_posts as $post ) {
		   setup_postdata( $post );
		   //print_r($post );
		   $faq_item_title = get_the_title( $post->ID );
           $faq_item_permalink = get_permalink( $post->ID );
		   $faq_item_content = get_the_content();
		  
		   $output .= '<div id="'. $post->ID.'" class="spice-faq-wrap">';
		   $output .= '<div id="'.$faq_item_title.'" class="spice-faq-title faq-closed"> <h4>'.$faq_item_title.'</h4></div>';
		   $output .= '<div class="spice-faq-content faq-closed" style="display: none;">';
		   $output .= '<p>'.$faq_item_content.'</p>';
		   $output .= '</div></div>';
         
       }
         
       wp_reset_postdata();
      
        return $output;
    }
 
    add_shortcode( 'spice-faq', 'spice_faq_shortcode' );
 
}
?>
