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
define('DB_NAME', 'larulata_WPYQU');

/** MySQL database username */
define('DB_USER', 'larulata_WPYQU');

/** MySQL database password */
define('DB_PASSWORD', '7D6pQJlW6tDEGPUO1');

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
define('AUTH_KEY', '055b50bf6a72c6469837775f2d8e59c75640efde8042e1208fff5ded21176590');
define('SECURE_AUTH_KEY', '8ee661d4328e433ad956761598887e5cc0a9a63514253c40ed5f335c240350dc');
define('LOGGED_IN_KEY', 'f6b3bfe2b8216673dbfc767ea7311c7f0221dff727bc66ac359962184b7401fe');
define('NONCE_KEY', 'e16da57f70ade12ee22a7b6c9aee5e33d1dac30f5da57285a11157c3b7980303');
define('AUTH_SALT', '1afcc4095f1492b0149036e8189c81cc341f58cd896ae59dc129706a508abecf');
define('SECURE_AUTH_SALT', '03677f87647a9957ea02a61470f6d4d352f281970f25153b6670eefcb033bf78');
define('LOGGED_IN_SALT', '3e40c23652d652ddaf841525e442d8a9a6f3e7f6ccc389e2261ff182948e1317');
define('NONCE_SALT', '3d7a9640afb7e325cd54ca4286fad684e24f0654124b2402b2ba1c0f1771888f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '_YQU_';

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
// define('WP_DEBUG', false);
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false);
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_CRON_LOCK_TIMEOUT', 120   ); 
define( 'AUTOSAVE_INTERVAL',    300   );
define( 'WP_POST_REVISIONS',    5     );
define( 'EMPTY_TRASH_DAYS',     7     );
define( 'WP_AUTO_UPDATE_CORE',  true  );


