<?php
/*
Plugin Name: wp-webp
Plugin URI: http://www.wordpress.org/extend/plugins/wp-webp
Description: Adds WebP image format support to your wordpress site using the webjs script.
Author: Hans Matzen
Author URI: http://www.tuxlog.de
Version: 0.6
Tags: webp, plugin, wordpress, image format, image,format
License: GPL2
*/
/*
 Copyright 2012, 2013

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


class C_WebP {

	function C_WebP() { $this->__construct(); } 

	function __construct()
	{
		new C_WebP_Options();
		add_action('init', array( &$this, 'init' ));
		add_action('admin_init', array( &$this, 'admin_init' ));
	} 

	function init() 
	{
		$allways = get_option("wp_webp_allways");
		$in_footer = get_option("wp_webp_infooter");
		$experimental = get_option("wp_webp_experimental");
		
			
		if (isset($in_footer['cb']) && $in_footer['cb'])
			$in_footer=1;
		else 
			$in_footer=0;
		
		if (isset($experimental['cb']) && $experimental['cb']) {
			wp_enqueue_script('wp-webp', '/' . PLUGINDIR . '/wp-webp/webpjs/libwebp-0.2.0.min.js', array("jquery"),"0.2.0",$in_footer['cb']);
			wp_enqueue_script('wp-webp2', '/' . PLUGINDIR . '/wp-webp/webpjs/libwebpwrapper.js', array("jquery", "wp-webp"),"0.1",$in_footer['cb']);
		} else {
		
			if (! $allways) {
				wp_enqueue_script('wp-webp', '/' . PLUGINDIR . '/wp-webp/webpjs/webpjs-0.0.2.min.js', array(),"0.0.2",$in_footer['cb']);
			} else {
				if ($in_footer['cb']) 
					add_action('wp_footer',array(&$this, 'testbrowser'));
				else
					add_action('wp_head',array(&$this, 'testbrowser'));
			}	
		}
	}
	
	function admin_init()
	{
		$allways = get_option("wp_webp_allways");
	
		if (! $allways) {
			wp_enqueue_script('wp-webp', '/' . PLUGINDIR . '/wp-webp/webpjs/webpjs-0.0.2.min.js', array(),"0.0.2");
		} else {
			add_action('admin_head',array(&$this, 'testbrowser'));
		}
	}
	
	function testbrowser() {
		$url = plugins_url();
		$out =<<<EOT
		<script>(function(){
			var WebP=new Image();
			WebP.onload=WebP.onerror=function(){
				if(WebP.height!=2){
					var sc=document.createElement('script');
					sc.type='text/javascript';
					sc.async=true;
					var s=document.getElementsByTagName('script')[0];
					sc.src='$url/wp-webp/webpjs/webpjs-0.0.2.min.js';
					s.parentNode.insertBefore(sc,s);
				}
			};
			WebP.src='data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
		})();</script>
EOT;
		echo $out;
	}
	
	
} 

class C_WebP_Options {

	function C_WebP_Options(){ $this->__construct(); } 

	function __construct()
	{
		// get translation
		load_plugin_textdomain('td_webp',false,dirname( plugin_basename( __FILE__ ) ) . "/lang/");
				
		
		
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
	} 
	
	function admin_init($args)
	{	

		// erweitere zugelassene Mimetypen
		add_filter( 'upload_mimes', array( &$this, 'wp_webp_upload_mimes') );
		
		// fuege Einstellungen hinzu
		if( !empty( $_POST['wp_webp_allways'] ))
				update_option("wp_webp_allways",$_POST['wp_webp_allways']);
		
		add_settings_field(
				$id = 'wp_webp_allways',
				$title = "WebP Support",
				$callback = array( &$this, 'wp_webp_allways' ),
				$page = 'general'
		);
		register_setting( $option_group = 'general', $option_name = 'wp_webp_allways' );
		
		add_settings_field(
				$id = 'wp_webp_infooter',
				$title = "",
				$callback = array( &$this, 'wp_webp_infooter' ),
				$page = 'general'
		);
		register_setting( $option_group = 'general', $option_name = 'wp_webp_infooter' );
		
		add_settings_field(
				$id = 'wp_webp_experimental',
				$title = "",
				$callback = array( &$this, 'wp_webp_experimental' ),
				$page = 'general'
		);
		register_setting( $option_group = 'general', $option_name = 'wp_webp_experimental' );
	}
	
	function wp_webp_allways($args)
	{
		$value = get_option('wp_webp_allways');
		$checked="";
		if (isset($value['cb']) && $value['cb']=='1') $checked="checked='checked'";
		echo '<label for="wp_webp_allways"><input name="wp_webp_allways[cb]" type="checkbox" id="wp_webp_allways" value="1"  '.$checked.' />';
		echo __("Allways add javascript support for WebP (even when the browser has native support).","td_webp");
		echo '</label>';
	}
	
	function wp_webp_infooter($args)
	{
		$value = get_option('wp_webp_infooter');
		$checked="";
		if (isset($value['cb']) && $value['cb']=='1') $checked="checked='checked'";
		echo '<label for="wp_webp_infooter"><input name="wp_webp_infooter[cb]" type="checkbox" id="wp_webp_infooter" value="1"  '.$checked.' />';
		echo __("Place javascript in the footer of the page (default is in the header).","td_webp");
		echo '</label>';
	}
	
	function wp_webp_experimental($args)
	{
		$value = get_option('wp_webp_experimental');
		$checked="";
		if (isset($value['cb']) && $value['cb']=='1') $checked="checked='checked'";
		echo '<label for="wp_webp_experimental"><input name="wp_webp_experimental[cb]" type="checkbox" id="wp_webp_experimental" value="1"  '.$checked.' />';
		echo __("Enable use of experimental libwebp support for decoder with alpha and lossless support.","td_webp");
		echo '</label>';
	}
	
	
	// Upload filter für Mediathek einbauen, so dass der Dateityp .webp zugelassen ist
	function wp_webp_upload_mimes($mimes) {
		$mime_types = array_merge( $mimes, 
			array('webp'   => 'image/webp')	);
	
		return $mime_types;
	}

} 
// KLasse instanziieren
new C_WebP;
?>