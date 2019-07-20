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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'DFx9qk7HC2LODZ8qrOJ6RxdgJQyt4LqKT/PURHN/NYgD+hrrZLYZZqd/IeQu/V6pnPeefqcewFi2ieDRWDDmbA==');
define('SECURE_AUTH_KEY',  'bdJGW87uXM6C9dsn6FV3g8hIYikjY2mn7BFtN7FQP9bwxZeaB0J4c54X/zGzLW0QxZCdYrxJYMZnBgqvsFm7Tg==');
define('LOGGED_IN_KEY',    'jvDfSbDXLRaTRIR761J85/0OiB/xQPN57K2H5rNCoBW2lzXMx228o1SNqyOyrQ2bz+kVsPGqdMn099rMSxxTmg==');
define('NONCE_KEY',        'wZzOky47MG2HlECvKtJ4gIPT6NlyUBVsDmJxp1cHJbtcRFtyfQWSjny8KTaxOaqiA8Q/kBmoxLKuRqOHtmylog==');
define('AUTH_SALT',        'qeFlHH8C4ANB5+Dak1LSg5f737Hk5a2PK5ZMLnrePYkeMT+Xs2Anwg1GQHYEpEN7SOMvKZss90K+/76UHqLmJQ==');
define('SECURE_AUTH_SALT', 'HBSjzQV7sgKJSNjqGlbrYMOPLGTfc3t2E6YUleI56yAQwL2W8WgEZayEtaNjJnPXsj6bOmQGc44IX/vM8cjEQA==');
define('LOGGED_IN_SALT',   '/viJK/1YJeVkzNHkDvG2ZHWOTZaeA5f6An1JpR8gKcVLmZgPi6FY81xb9i2KhcWgS2gi6ZNUe8edk5QU2vt/GQ==');
define('NONCE_SALT',       'SaI3tcgtDs6/xgfYZvLM/t7qjYFil0l0FiKTmhkEcs6zHDJWFKKZHGunE2QQdc9Tmu+DAdH90j2wagv4QppRTw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
