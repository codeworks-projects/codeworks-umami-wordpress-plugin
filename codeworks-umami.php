<?php
/**
 * Plugin Name: Codeworks Umami
 * Plugin URI: https://codeworks.build
 * Description: Integrate Umami Analytics into WordPress.
 * Version: 0.1.0
 * Author: Codeworks - Luca Visciola
 * Author URI: https://github.com/melasistema
 * Text Domain: codeworks-umami
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CODEWORKS_UMAMI_VERSION', '0.0.1' );
define( 'CODEWORKS_UMAMI_FILE', __FILE__ );
define( 'CODEWORKS_UMAMI_DIR', plugin_dir_path( __FILE__ ) );
define( 'CODEWORKS_UMAMI_URL', plugin_dir_url( __FILE__ ) );

require_once __DIR__ . '/includes/Constants.php';
require_once __DIR__ . '/includes/Helpers.php';
require_once __DIR__ . '/includes/Analytics.php';
require_once __DIR__ . '/includes/Plugins.php';

Codeworks\Umami\Plugin::init();

register_uninstall_hook( CODEWORKS_UMAMI_FILE, '\Codeworks\Umami\Plugin::uninstall' );
