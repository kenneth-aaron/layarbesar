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
define( 'DB_NAME', 'layarbesar' );

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
define( 'AUTH_KEY',         'Vn2<,EU,Aq*~n/fp9H4(xI=DW .]Y?X+^l )z&>]OAsztI~HFb+DjT76?CA)^cot' );
define( 'SECURE_AUTH_KEY',  '_{oZ7_Mwlo8]RAqQ7bm~.dt=p]{e[:)rmU037#zk)8O(;0.gT%DL4`/^pRl_>D{3' );
define( 'LOGGED_IN_KEY',    '<AgQei>3-fJe~%zc{/tm^l?otV$JBV=|@R2tu4Mg*Dx0Jb0PXu|<H5MV _MZ|t,c' );
define( 'NONCE_KEY',        '$ n)hK[G5^LtSP-`TT!?:l6s!M/J+Ka4#kb(cHe4P/%f=G9|/4]&5+cF4!I.To1k' );
define( 'AUTH_SALT',        'j U=[kiZj+IawM+M{_x1>m9&?=.S4.#`d.-)!{0ekZk[/EJJ7E5p6RWcU/!LJu^0' );
define( 'SECURE_AUTH_SALT', '{o(O)H+#B5vd<7dU{FMbqr%2V]r3Juz?1x#{)?(_dChY-}6H=am?`<Z{S?.s{k>B' );
define( 'LOGGED_IN_SALT',   '^;sxF)598gOB-S.-%xiHBL-t0Q4D=E0a~;iV%XTkLEB7@|*>b%l~.8.uUF1o1^BU' );
define( 'NONCE_SALT',       'Mt0s?P3zH*?]5LY0(v*1^dAPTS;OGZU,xux_Dmb/Y/y_09-$7fP/CMHdLa7om0mD' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
