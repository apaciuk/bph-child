<?php
// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );
/*
 * Remove this action and callback function if you do not whish to use LESS to style your site or overwrite UIkit variables.
 * If you are using LESS, make sure to enable development mode via the Admin->Appearance->Settings option. LESS will then be processed on the fly.
 */
// Enqueue uikit assets
beans_add_smart_action( 'beans_uikit_enqueue_scripts', 'applifting_child_enqueue_uikit_assets', 5 );
function applifting_child_enqueue_uikit_assets() {
// Enqueue uikit overwrite theme folder
	beans_uikit_enqueue_theme( 'applift', get_stylesheet_directory_uri() . '/assets/less/uikit' );

	// Add the theme style as a uikit fragment to have access to all the variables
	beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/assets/less/style.less', 'less' );

	// Add the theme js as a uikit fragment
	beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/assets/js/custom.js', 'js' );

	// Include the uikit components needed
	beans_uikit_enqueue_components( array( 'contrast' ) );

}
// Remove the secondary sidebar.
add_action( 'widgets_init', 'remove_widget_area' );
function remove_widget_area() {
beans_deregister_widget_area( 'sidebar_secondary' );
}
// Remove offcanvas menu.
remove_theme_support( 'offcanvas-menu' );
// Set Feat Img size
add_filter( 'beans_edit_post_image_args', 'example_post_image_edit_args' );
function example_post_image_edit_args( $args ) {
  return array_merge( $args, array(
   'resize' => array( 1460, 700, true ),
 ) );
}
// Remove the breadcrumb.
add_filter( 'beans_pre_load_fragment_breadcrumb', '__return_true' );
//Remove site title
 beans_remove_action( 'beans_site_branding' );
/* register footer nav */
function applift_register_nav_menu(){
        register_nav_menus( array(
            'footer_menu'  => __( 'Footer Menu', 'applift' ),
   ) );
}
add_action( 'after_setup_theme', 'applift_register_nav_menu', 0 );
/*------- Footer & Social icons -------*/
add_action( 'widgets_init', 'beans_child_logo_footer_loop' );
function beans_child_logo_footer_loop() {    
     beans_register_widget_area( array(        
                'name' => 'Logo Footer',
                'id' => 'logo-footer',     
                 'description' => 'Widgets for logo will be shown above the footer.'     
     ) );
}
add_action( 'widgets_init', 'beans_child_widgets_footer_loop' );
function beans_child_widgets_footer_loop() {    
     beans_register_widget_area( array(
		       'name' => 'Footer',        
               'id' => 'footer',        
               'description' => 'Widgets in this area will be shown in the footer section as a grid.', 
               'beans_type' => 'grid'    
     ) );
}
// Display the footer & social widget area in the front end.
add_action( 'beans_footer_before_markup', 'footer_widget_area' );
function footer_widget_area() {
      // Stop here if no widget
 if( !beans_is_active_widget_area( 'footer' ) )
 return;
        ?> 
            <div class="tm-bottom">
			    <div class="widget-footer uk-block" id="logo-footer"> 
			 <div class="uk-container uk-container-center"> 
			   <?php echo beans_widget_area( 'logo-footer' ); ?>
				</div>
             </div>
            <div class="widget-footer uk-block" id="widget-footer"> 
            <div class="uk-container uk-container-center"> 
                  <?php echo beans_widget_area( 'footer' ); ?> 
          </div> 
    </div> 
      <div class="widget-footer uk-block" id="menu-footer"> 
        <div class="uk-container uk-container-center"> 
				 <?php echo wp_nav_menu( array(
                 'menu' => 'Footer Menu',
			    )); ?>
        </div> 
</div>
</div>
      
    <?php
}
// Setup document fragements, markups and attributes
add_action( 'wp', 'applift_setup_document' );
function applift_setup_document() {
   // Post meta
	beans_add_attribute( 'beans_post_meta_date', 'class', 'uk-text-muted' );
}
// Display posts in a responsive grid.
add_action( 'wp', 'applift_posts_grid' );

function applift_posts_grid() {
// Only apply to non singular view.
 if ( !is_singular() ) {

   // Add grid.
    beans_wrap_inner_markup( 'beans_content', 'beans_child_posts_grid', 'div', array(
     'class' => 'uk-grid uk-grid-match',
     'data-uk-grid-margin' => ''
   ) );
    beans_wrap_markup( 'beans_post', 'beans_child_post_grid_column', 'div', array(
      'class' => 'uk-width-large-1-3 uk-width-medium-1-2'
   ) );

    // Move the posts pagination after the new grid markup.
   beans_modify_action_hook( 'beans_posts_pagination', 'beans_child_posts_grid_after_markup' );
    
  }

}
/*----- COPYRIGHT INFO BOTTOM ----*/
// Overwrite the footer content.
beans_modify_action_callback( 'beans_footer_content', 'beans_child_footer_content' );

// COPYRIGHT area
function beans_child_footer_content() {
?>
<div class="tm-sub-footer uk-text-center uk-text-muted">
    <p>© <?php echo date('Y'); ?>
		<a href="<?php echo site_url();?>" target="_blank" title="BPH Plumbing">BPH<span>Plumbing</span></a> - an <a href="http://www.applifting.com/" title="Applifting" target="_blank">Applifting</a> Group Company </p>
    </div>
    <?php
}












