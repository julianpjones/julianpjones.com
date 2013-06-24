<?php
/** Manage plugin options
  *
  */

$otw_options = get_option( 'otw_plugin_options' );

$db_values = array();

if( isset( $_POST['otw_sbm_items_limit'] ) ){
	$db_values['otw_sbm_items_limit'] = $_POST['otw_sbm_items_limit'];
}elseif( isset( $otw_options['otw_sbm_items_limit'] ) ){
	$db_values['otw_sbm_items_limit'] = $otw_options['otw_sbm_items_limit'];
}else{
	$db_values['otw_sbm_items_limit'] = 20;
}

$message = '';
$massages = array();
$messages[1] = __( 'Options saved', 'otw_sbm' );

if( isset( $_GET['message'] ) && isset( $messages[ $_GET['message'] ] ) ){
	$message .= $messages[ $_GET['message'] ];
}
?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php _e('Plugin Options', 'otw_sbm') ?>
	</h2>
	<div class="form-wrap" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_action" value="manage_otw_options" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-sbm-options'); ?>

			<div id="post-body">
				<div id="post-body-content">
					<div class="form-field">
						
						<label for="sbm_activate_appearence" class="selectit"><?php _e( 'Enable widgets management', 'otw_sbm' )?>
						<input type="checkbox" id="sbm_activate_appearence" name="sbm_activate_appearence" value="1" style="width: 15px;" <?php if( isset( $otw_options['activate_appearence'] ) && $otw_options['activate_appearence'] ){ echo ' checked="checked" ';}?> /></label>
						<p><?php _e( 'Control every single widgets visibility on different pages, post, categories, tags, custom post types and taxonomies. When widget control is enabled it will add a button called Set Visibility at the bottom of each widgets panel (Appearance -> Widgets).  You can choose where is the widget displayed on or hidden from.', 'otw_sbm' );?></p>
					</div>
					<div class="form-field">
						<label for="otw_sbm_items_limit"><?php _e( 'Number of items to show in lists', 'otw_sbm' )?></label>
						<input type="text" id="otw_sbm_items_limit" name="otw_sbm_items_limit" style="width: 100px;" value="<?php echo $db_values['otw_sbm_items_limit'] ?>" />
						<p><?php _e( ' This is the number of items to show in the lists when you add/eddit sidebars and set widget visibility.', 'otw_sbm' );?></p>
					</div>
					<p class="submit">
						<input type="submit" value="<?php _e( 'Save Options', 'otw_sbm') ?>" name="submit" class="button"/>
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
