<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'Website');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2>VZ[y;OoBUaL,-P;++<DMNW@Yi~B;W|((@l2O$n+-LsM-B7/2_?$S1JErl9{dB0');
define('SECURE_AUTH_KEY',  'b2LWn<q@T8.,Q5Zfc^w>go:7lW~tk_mbo9wR&qJ#m[4~Ww.g%7aJA,MrE@t NsA.');
define('LOGGED_IN_KEY',    ' hh[6TBM+]URmo,kMceA4,>x|8MmS|=v|r,$UlqoZ!%2e?.9@nmVANyED#winfSu');
define('NONCE_KEY',        '~ze-[}BwW|%l$&l4+]+aE`7;{ryG{7(;G:t{2ZU&M>sNwtIJ3GeBk |Her||#(zJ');
define('AUTH_SALT',        '|l~Ox#z7GhcdkB:xhN 7XO:9&9-bF6q-G{`QU~z|-v}chzc-cyhr]q{;nwk{|}yC');
define('SECURE_AUTH_SALT', '`?~oFC#YM]/U r,diJssR$!HzU~)|~/cn9lp`%{ (38i>@+WX#@J[x{G(Rdzi{No');
define('LOGGED_IN_SALT',   'R8if+8+v3#S  z4>u_p:MM,*-}-Ip#hn?LMA9-=+]v9Xg hV^c+M>sQ=$7hgb8ly');
define('NONCE_SALT',       '_Xg-jt$l t;<%:&E/:jsLVGrb,8*!vvtZTP%QYmO~%RbCFuL:B1=7-TfO*;()ZGX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'kdw_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
