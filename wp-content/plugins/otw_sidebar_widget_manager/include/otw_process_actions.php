<?php
/**
 * Process otw actions
 *
 */
if( isset( $_POST['otw_action'] ) ){
	
	require_once( ABSPATH . WPINC . '/pluggable.php' );
	
	switch( $_POST['otw_action'] ){
		
		case 'activate_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'active';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-sbm&message=3' );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'deactivate_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'inactive';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-sbm&message=4' );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'delete_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$new_sidebars = array();
						
						//remove the sidebar from otw_sidebars
						foreach( $otw_sidebars as $sidebar_key => $sidebar ){
						
							if( $sidebar_key != $otw_sidebar_id ){
							
								$new_sidebars[ $sidebar_key ] = $sidebar;
							}
						}
						update_option( 'otw_sidebars', $new_sidebars );
						
						//remove sidebar from widget
						$widgets = get_option( 'sidebars_widgets' );
						
						if( isset( $widgets[ $otw_sidebar_id ] ) ){
							
							$new_widgets = array();
							foreach( $widgets as $sidebar_key => $widget ){
								if( $sidebar_key != $otw_sidebar_id ){
								
									$new_widgets[ $sidebar_key ] = $widget;
								}
							}
							update_option( 'sidebars_widgets', $new_widgets );
						}
						
						wp_redirect( admin_url( 'admin.php?page=otw-sbm&message=2' ) );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'manage_otw_options':
				
				$options = array();
				
				if( isset( $_POST['sbm_activate_appearence'] ) && strlen( trim( $_POST['sbm_activate_appearence'] ) ) ){
					$options['activate_appearence'] = true;
				}else{
					$options['activate_appearence'] = false;
				}
				
				if( isset( $_POST['otw_sbm_items_limit'] ) && strlen( trim( $_POST['otw_sbm_items_limit'] ) ) && intval( $_POST['otw_sbm_items_limit'] ) ){
					$options['otw_sbm_items_limit'] = intval( $_POST['otw_sbm_items_limit'] );
				}else{
					$options['otw_sbm_items_limit'] = 20;
				}
				
				update_option( 'otw_plugin_options', $options );
				wp_redirect( admin_url( 'admin.php?page=otw-sbm-options&message=1' ) );
			break;
		case 'manage_otw_sidebar':
				global $validate_messages, $wp_sbm_int_items, $wpdb;
				
				$validate_messages = array();
				$valid_page = true;
				if( !isset( $_POST['sbm_title'] ) || !strlen( trim( $_POST['sbm_title'] ) ) ){
					$valid_page = false;
					$validate_messages[] = __( 'Please type valid sidebar title', 'otw_sbm' );
				}
				if( !isset( $_POST['sbm_status'] ) || !strlen( trim( $_POST['sbm_status'] ) ) ){
					$valid_page = false;
					$validate_messages[] = __( 'Please select status', 'otw_sbm' );
				}
				if( $valid_page ){
					
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( !is_array( $otw_sidebars ) ){
						$otw_sidebars = array();
					}
					$items_to_remove = array();
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						$sidebar = $otw_sidebars[ $_GET['sidebar'] ];
					}else{
						$sidebar = array();
						$otw_sidebar_id = false;
					}
					
					$sidebar['title'] = (string) $_POST['sbm_title'];
					$sidebar['description'] = (string) $_POST['sbm_description'];
					$sidebar['replace'] = (string) $_POST['sbm_replace'];
					$sidebar['status'] = (string) $_POST['sbm_status'];
					$sidebar['widget_alignment'] = (string) $_POST['sbm_widget_alignment'];
					
					//save selected items
					$otw_sbi_items = array_keys( $wp_sbm_int_items );
					
					foreach( $otw_sbi_items as $otw_sbi_item ){
						
						if( isset( $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] ) && strlen( trim( $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] ) ) ){
							
							$sidebar['validfor'][ $otw_sbi_item ] = array();
							
							$posted_items = explode( ',', $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] );
							
							foreach( $posted_items as $item_id ){
								$sidebar['validfor'][ $otw_sbi_item ][ $item_id ] = array();
								$sidebar['validfor'][ $otw_sbi_item ][ $item_id ]['id'] = $item_id;
							}
							
						}else{
							$sidebar['validfor'][ $otw_sbi_item ] = array();
						}
					}
					
					if( $otw_sidebar_id === false ){
						
						$otw_sidebar_id = 'otw-sidebar-'.( get_next_otw_sidebar_id() );
						$sidebar['id'] = $otw_sidebar_id;
					}
					
					$otw_sidebars[ $otw_sidebar_id ] = $sidebar;
					
					
					if( !update_option( 'otw_sidebars', $otw_sidebars ) && $wpdb->last_error ){
						
						$valid_page = false;
						$validate_messages[] = __( 'DB Error: ', 'otw_sbm' ).$wpdb->last_error.'. Tring to save '.strlen( maybe_serialize( $otw_sidebars ) ).' bytes.';
					}else{
						wp_redirect( 'admin.php?page=otw-sbm&message=1' );
					}
				}
			break;
	}
}
function get_next_otw_sidebar_id(){

	$next_id = 0;
	$existing_sidebars = get_option( 'otw_sidebars' );
	
	if( is_array( $existing_sidebars ) && count( $existing_sidebars ) ){
	
		foreach( $existing_sidebars as $key => $s_data ){
			
			if( preg_match( "/^otw\-sidebar\-([0-9]+)$/", $key, $matches ) ){
			
				if( $matches[1] > $next_id ){
					$next_id = $matches[1];
				}
			}
		}
	}
	return $next_id + 1;
}
?>