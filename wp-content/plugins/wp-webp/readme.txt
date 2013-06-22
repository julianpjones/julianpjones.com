=== wp-webp Plugin ===
Contributors: tuxlog
Donate link: http://www.tuxlog.de
Tags: webp, plugin, wordpress, image format
Requires at least: 2.8
Tested up to: 3.5.1
Stable tag: 0.6

The wp-webp Plugin gives your site the ability to show images in WebP format using webpjs

== Description ==
The wp-webp Plugin gives your site the ability to show images in WebP format using WebPJS by Dominik Homberger
It simply adds the javascript as describe at http://webpjs.appspot.com/ to your site.
You can choose between adding to the header or the footer and you can choose if it's added allways or just 
when the browser used does not support WebP itself.

Credits:
	Thanks to Dominik Homberger who developed the grep WebPJS (http://webpjs.appspot.com/)
    which is included in the subdir webpjs
    
== Installation ==

1. Unzip the package
2. Upload the wp-webp directory to your plugins folder
3. Activate the plugin on the plugin screen.
4. Optional: Go to general settings to set options
or simply install it via the WordPress Plugin dialog :-)
   
== Changelog ==

= v0.6 (2013-06-16) =
* added width and height support in experimental mode

= v0.5 (2013-04-18) =
* added support for libwebp-0.2.0 alpha for looseless compressing

= v0.4 (2013-02-23) =
* switched to load_plugin_textdomain for compatibility reasons
* switched to mime_types filter for compatibility with wp 3.5.1

= v0.3 (2012-05-18) =
* surpress php warnings due to undefined string checked
* surpress php warnings due to incomplete array check before use

= v0.2 (2012-04-29) =
* made upload of webp images to mediathek possible (allow mimetype image/webp)
* added webp support for media (but image editing not working yet due to libgd)
* added german translation

= v0.1 (2012-04-21) =
* initial release 
