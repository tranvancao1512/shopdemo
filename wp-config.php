<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'n`q]2FKUMxc#LfbJE6%S((6Qbdx2HvR!RcN_t?e1D*ua,ubBtU@7,Q@=p=|`3R11' );
define( 'SECURE_AUTH_KEY',  'ORI6{= I@* =4yp7m{uIN>w5|D<f591X*h5wz 9HsB#ow_AWaN96UDV9*|zB//$f' );
define( 'LOGGED_IN_KEY',    'wrea.(cp9oS:n]:uqj/<8&iEXPg.aa{7o[WD4L*2m6S-?/.DC,/*A?ZzQq4BO]xc' );
define( 'NONCE_KEY',        '0^i1-mlc+R5)}hh)u=WSXoeb5#Zf Vxs(DW]ijMR?:0>2rR:c+jt6$WS/2dOy(Mk' );
define( 'AUTH_SALT',        '[2!z@~uACP3#XB:lS:dcBBqM/6yI!da.^&c3f9UgzB2f(7<4U>+Z=T~E&jmM!.I6' );
define( 'SECURE_AUTH_SALT', 'aT9L=,-nMe@/;H !^fOW+Q.,bL5*WLw6^n-8{#]Xut]K;0zbygn;PW&0sx?2ir|-' );
define( 'LOGGED_IN_SALT',   'ehb ]m6zt^+Qp?xboX+rn$>!J$uaPkAkGf}W(RA#C$pgg|EY_gl7+`E$?F;X5LP7' );
define( 'NONCE_SALT',       'I~|n]`f9k&>issV09+|Y$P#(DG~B$58}vl}=CIHfJaUE1#ZRjNFYvq/ Q&!J 8EG' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wezzyp_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
