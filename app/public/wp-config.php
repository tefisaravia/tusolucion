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
define('AUTH_KEY',         'y/9i601VkAAHcM8dFbaz4D32GQSUCcArsE5ABISEjZLT3V2f0vmFFkYJ3rvEj+P0eBaT9sxWECPKiE1svJBxLQ==');
define('SECURE_AUTH_KEY',  'vDFDFH7IrJSefnROzjNtg4XhC28DFXAR4x+hSrRuQMHyCTFoptixdmivEqBllV+NIRfOAu9nEOa5mwmjeEB2JA==');
define('LOGGED_IN_KEY',    'chn5I+EBdqxxnO4hp7pVRg/Ug4OWNxrT8QgYFIGOuR42SkbO1LyWF0FNzFMU7XzAIUFOyIaFwDEtKrbgByM8Jg==');
define('NONCE_KEY',        'hT3HBp6ODSAeaf2fslla87UdKKfkB7C41VJDr4tXiJLwuxkP5vgW4AFYySrs1NBGSkSnjMEzMtvBi1QAGi1M9A==');
define('AUTH_SALT',        'tSrZbU4oNQB/C8aWR1oF3s3GeRnWBZqn3D5TyQR2NskJmdST1NdjNdvbfCJrkZ0FdAYO2leEuZTdvis+Rz4oPQ==');
define('SECURE_AUTH_SALT', '+j7vtVC8apZGSuZ35iXAt0vrgYJonmltH4sK606v6zK8eJetGCsxyvaFH1+sXC8SFkYC0bgiEYnOtwQnr2dzvw==');
define('LOGGED_IN_SALT',   'EpGhJQRw8ijEZvcolBHwMrSGOnextg7qDEP7+WRCq60Dm8lFQ2LqobWpqetLjtrULZa/hwbXPgb1jJAY/oTJPA==');
define('NONCE_SALT',       '12Qr3qe9jqZm9uRJvpPhxk+l12dZn2mZqzsA8H8EiOH4KZzw7zbemQdBxt22+5ungIWUa2u7XQnXw4xCBWDZJQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
