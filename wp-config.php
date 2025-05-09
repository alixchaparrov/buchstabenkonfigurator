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
define( 'DB_NAME', 'buchstabenkonfigurator' );

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
define( 'AUTH_KEY',         'ac_Ty6Uz0*RC_zf|J?1#.gR]rWBTty;q[`gQ4M<o/(8wNX#7J>94X^[$ZB4f#dW_' );
define( 'SECURE_AUTH_KEY',  '49;Qy30t<q_aM{dX uxmr7>=M}vhG:wU5SM?OX/2Z0s!NDyZe;A4tn_eCSQrGubS' );
define( 'LOGGED_IN_KEY',    'iJR<@pNDJrG>1[7]AjWo*=.x=sV+;5$j9f>!|`ib,Sf:ov<L;<KKi7Yig.z/zPqI' );
define( 'NONCE_KEY',        'uU<IpNcv=507**z(7urN02-q8$;a`iO;V,Qu2(,>S#B[sRd~}?%NW-8skt+RH#_9' );
define( 'AUTH_SALT',        '^rHs,L3#+CS^UP_GG$C:EKN<^= r~m;;ZM-@ZLWl+J3L;*gjGH`?N3VPE+&@:$zH' );
define( 'SECURE_AUTH_SALT', '1tF[WvKa2f~$.DhCV8^)bvY#[H&`&-beFK{SI.U3nRSN1Pay>$yT]I4DXmgnWVV,' );
define( 'LOGGED_IN_SALT',   'H?,IMi[?/DTL-)4K}%h:(s|ib>1*J17pT5C;cFOhEvKTRW8s>[rK^!5Y.c[ lgZm' );
define( 'NONCE_SALT',       'o,y>1i1wI*g]g3n:l]1wi:b.tK4`k*OeF@]r#Mfj1rslnNe)4df@lFm[+NN/g2bm' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
