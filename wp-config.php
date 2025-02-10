<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'company_site' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3BHY1/F0^63%$_h51Qj9*Ss]5?.HDh6cUw;tiBiWadd7%n!(bXRo$~7OY}3/S<ht' );
define( 'SECURE_AUTH_KEY',  'ET}hqOctgJqOTYH*)/jj7S(z ~]V3~I<le^UR!^rUJ~s%e5(E8v.F}/uTHRpf/A:' );
define( 'LOGGED_IN_KEY',    'uRueuurlwk.{N:a<RgiccdgZkR9@{Pqv~ovejg2oenUgVXUJ_>/8syjhWb|}ZSVf' );
define( 'NONCE_KEY',        '8_<O*j.BcsW1ts6ey%|<%{.YjZ%X-dPP3oE&l@kCIog,_TPf+!u~uFkA]kIe(e>{' );
define( 'AUTH_SALT',        '4X%jTUAxf96WzsH:X|~qONj ,2;:eFDiu_jkDhBK]YXSJSzI1!C$qHGIo~q=B8vd' );
define( 'SECURE_AUTH_SALT', 'g[@*U~>w8n)%+jJ@!{RbH^vx:{yXVtN|<*7uLhM]Xo{%)eQ^JJFSX4^Y~Afr8SH]' );
define( 'LOGGED_IN_SALT',   'Sqgl#(S||`!#9450}w.M@~S2_cwojJ]1545HzDH5Y-de2Hz8X#k[>{pyx|m/rIpv' );
define( 'NONCE_SALT',       '*<pH~c%~4OA$7{MrMz[[},D.@lX3Jd> )06e5<E.v(,^iQ.c8gZKzmeZbhVbAe9?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
