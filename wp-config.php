<?php
define('DB_NAME', 'wordpress');
define('DB_USER', 'root');
define('DB_PASSWORD', 'password1');
define('DB_HOST', 'db');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

define('WP_DEBUG', false);

define('AUTH_KEY',         'authentication unique phrase');
define('SECURE_AUTH_KEY',  'secure authentication unique phrase');
define('LOGGED_IN_KEY',    'logged in unique phrase');
define('NONCE_KEY',        'nonce unique phrase');
define('AUTH_SALT',        'authentication salt');
define('SECURE_AUTH_SALT', 'secure authentication salt');
define('LOGGED_IN_SALT',   'logged in salt');
define('NONCE_SALT',       'nonce salt');

if ( !defined('ABSPATH') )
    define('ABSPATH', __DIR__ . '/');

require_once(ABSPATH . 'wp-settings.php');