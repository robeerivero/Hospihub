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
define( 'DB_NAME', 'hospihub' );

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
define( 'AUTH_KEY',         '02nL$X3|0#oSvq2rWJ%@6X(s6t#lnqC]_L.R1;+|!ZWa~&0OwHb/B`[gnuldzBx>' );
define( 'SECURE_AUTH_KEY',  'U[f9(Jr-IZfYtC{MNfBrJMDCHTiBT$2tC1d0L}BD^p){RXw>R<Lb#X&iOB?i`!7.' );
define( 'LOGGED_IN_KEY',    'Z+jLF:&T3}Z/ZVIxAvIR,&lhfnA5/@i(TT![1&be}~=-Z[A9U9f;sxBXN$1/KXgS' );
define( 'NONCE_KEY',        'xIaWLWxl__sbV5_0}Vu-XsP-cEjV> ffFn=,o)Uu_d|.]B2U=suI!B}bV@5k[6]?' );
define( 'AUTH_SALT',        'l[fO Sojy]PY^M?;f>6$7DhWm`:G0lviBE44LtdL}UE9 UVVxf49|PNX ERT5}P~' );
define( 'SECURE_AUTH_SALT', '/BL^Jn5Mjzz@ugQTx`oLBM T?x`GML}!}_(KT/&b~RbV?{>W`i]w$_vn@5{^_E*R' );
define( 'LOGGED_IN_SALT',   'V&v{%s*T{ZJrJ#bBqeD>p291+B&Kn$7$O+WeZ*6iVz@PqEzddv:db&Pf{G9-rT>k' );
define( 'NONCE_SALT',       'M<w}R dD22@!*k74kO-tXL4uHv>**!2b-TF,nU|##~F-F}$3f=)c4I,&^y^a9M;O' );

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
