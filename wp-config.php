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
define('DB_NAME', 'dieuhoa');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'A4`BMiP4|+oqYS0O#[/@9mP4S6b;v/:KA`x9qsN%7qkb/`9 KA~lQOUKiAnz4]}3');
define('SECURE_AUTH_KEY',  ';Z|kK!IWwQq7WH]w^9;/>Vo%pCIc,y$1e/-Sy|nm:zt}p=#DN=M{.nOiuPhjXEC0');
define('LOGGED_IN_KEY',    'B2fWAQ-kRqk U&7e,q4X)]49vGw S4.gKx@]I{%a=U&>/_rkt3 kha0Iq( cEwpv');
define('NONCE_KEY',        '^!xt0ed$cPMZwcn{Fp(+8nsf1@BtD0mp1TI@NN*x*%9;&8UKo=?<{~!@``okt1i*');
define('AUTH_SALT',        'EBw}2 ZR)@G!KWf|#NI-EJ$uz/WI.jSnOMQ^hNr#O/xdro(_qY<0kcATmpk}{KPL');
define('SECURE_AUTH_SALT', 'i^KkDm(W4y]Q]~@OHO5*85{FN~hT^-6Cn+:CP>IJ_;H)eO/}cr5h8xtHi8wM[,@M');
define('LOGGED_IN_SALT',   '7-syNRj(F$VMi&~h<ts[QR*!iSdu5HQf#9}<-SwNfM@p*KiDEP@~97TL4X yMR&@');
define('NONCE_SALT',       '7hAYi#)=K_wIihVy5A`FQ*v(uwo:k$ogRAc*>9y*`XT_}y%;$x$>}1 W]Dl,se[a');

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
