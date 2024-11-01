<?php

if ( ! function_exists( 'spice_faq_cpt' ) ) {
 
// register custom post type
    function spice_faq_cpt() {
		
        // these are the labels in the admin interface, edit them as you like
        $labels = array(
            'name'                => __( 'FAQs', 'Post Type General Name', 'spice_faq' ),
            'singular_name'       => __( 'FAQ', 'Post Type Singular Name', 'spice_faq' ),
            'menu_name'           => __( 'FAQ', 'spice_faq' ),
            'parent_item_colon'   => __( 'Parent Item:', 'spice_faq' ),
            'all_items'           => __( 'All Items', 'spice_faq' ),
            'view_item'           => __( 'View Item', 'spice_faq' ),
            'add_new_item'        => __( 'Add New FAQ Item', 'spice_faq' ),
            'add_new'             => __( 'Add New', 'spice_faq' ),
            'edit_item'           => __( 'Edit Item', 'spice_faq' ),
            'update_item'         => __( 'Update Item', 'spice_faq' ),
            'search_items'        => __( 'Search Item', 'spice_faq' ),
            'not_found'           => __( 'Not found', 'spice_faq' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'spice_faq' ),
        );
        $args = array(
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor' ),
            'taxonomies'          => array( 'spice_faq_tax' ),
            'public'              => true,
            'menu_position'       => 20,
            'has_archive'         => true,
        );
        register_post_type( 'spice_faq', $args );
		
		
 
    }
 
    // hook into the 'init' action
    add_action( 'init', 'spice_faq_cpt', 0 );
 
}
 
if ( ! function_exists( 'spice_faq_tax' ) ) {
 
    // register custom taxonomy
    function spice_faq_tax() {
 
        // again, labels for the admin panel
        $labels = array(
            'name'                       => __( 'FAQ Categories', 'Taxonomy General Name', 'spice_faq' ),
            'singular_name'              => __( 'FAQ Category', 'Taxonomy Singular Name', 'spice_faq' ),
            'menu_name'                  => __( 'FAQ Categories', 'spice_faq' ),
            'all_items'                  => __( 'All FAQ Cats', 'spice_faq' ),
            'parent_item'                => __( 'Parent FAQ Cat', 'spice_faq' ),
            'parent_item_colon'          => __( 'Parent FAQ Cat:', 'spice_faq' ),
            'new_item_name'              => __( 'New FAQ Cat', 'spice_faq' ),
            'add_new_item'               => __( 'Add New FAQ Cat', 'spice_faq' ),
            'edit_item'                  => __( 'Edit FAQ Cat', 'spice_faq' ),
            'update_item'                => __( 'Update FAQ Cat', 'spice_faq' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'spice_faq' ),
            'search_items'               => __( 'Search Items', 'spice_faq' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'spice_faq' ),
            'choose_from_most_used'      => __( 'Choose from the most used items', 'spice_faq' ),
            'not_found'                  => __( 'Not Found', 'spice_faq' ),
        );
        $args = array(
            // use the labels above
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
        );
      
        register_taxonomy( 'spice_faq_tax', array( 'spice_faq' ), $args );
		
		$myterms = get_terms( 'spice_faq_tax',array('hide_empty'=>false) );
		//die($myterms);
		if(empty($myterms)){
			
			$defaultterm=wp_insert_term('Default','spice_faq_tax', array('description'=> 'Default Category','slug' => 'default'));
			update_option('spice_faq_tax_default_term_id', $defaultterm['term_id']);
			
		}
 
    }
	
    // hook into the 'init' action
    add_action( 'init', 'spice_faq_tax', 0 );
 
}


//this will by default select the all category
	function spice_faq_set_default_category( $post_id, $post ) {
		
    if ( 'publish' == $post->post_status && $post->post_type == 'spice_faq' ) {
        $taxonomies = get_object_taxonomies( $post->post_type,'object' );
        foreach ( $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy->name );

			$myid = get_option('spice_faq_tax_default_term_id');
			$a=get_term_by('id',$myid,'spice_faq_tax');
            if ( empty( $terms )) {
                wp_set_object_terms( $post_id,$a->slug , $taxonomy->name );
            }
        }
    }
}
add_action( 'save_post', 'spice_faq_set_default_category', 100, 2 );

?>
