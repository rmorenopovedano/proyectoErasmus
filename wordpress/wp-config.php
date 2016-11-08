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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1111');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'nFM$ eZc*BPokI^dckchD3[/)e9(zwFmtJ+Fr*O?cE%dDI]2{eoUm]xvnnc+?Fu`');
define('SECURE_AUTH_KEY',  'Ck%TsP0=frGHj{G&?<$S!$cym&xVrtQt8[mI6&IpL?x&Ut`wHkf1#rp&N#tn$J=p');
define('LOGGED_IN_KEY',    'Q:.7t1FSRQ>Fi#wH29&eEx[mF(]k<omt1b,RwC(W[5 #-qgy~pbZ0CMu@0=h*V,g');
define('NONCE_KEY',        '=b+I`0>/qD|@C-|0Ob31S[GGRha-v1+Kf^fL4l2}v$q:d=:CT$7W>R{S?GSAZ~C.');
define('AUTH_SALT',        '[_?T1%S@A^EH8i0zqf_K~]z{YIhTpL8H2&2.Y$ZAT>t4g(B<iADR&A2lEfy2w6?D');
define('SECURE_AUTH_SALT', 'G+|48a=hc{sr_TJVM`?YG0j{esWT3_>Qo^>,et_4%wct;7nJ4~Z!vHD)!VrL/;T>');
define('LOGGED_IN_SALT',   'Pay.]7/l8]Yu9*Ap7)8k8M]kIyDK9:>Ch-BKIVtg26hT8Jb7K>UlU-~pK-}]U5d1');
define('NONCE_SALT',       '!Bf5xG>`C>q+1%+=Kw2&=izda_)C&p2`36~|TF~R)@>CBXy7$ltb]g)6+=PO<g]R');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
