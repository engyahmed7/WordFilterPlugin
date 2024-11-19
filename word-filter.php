<?php
/*
Plugin Name: Word Filter
Description: Filter and replace specific words across all posts and pages
Version: 1.0
Author: engy
*/

if (!defined('ABSPATH')) {
    exit;
}

define('WORD_FILTER_VERSION', '1.0');
define('WORD_FILTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WORD_FILTER_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once WORD_FILTER_PLUGIN_DIR . 'includes/class-word-filter.php';
require_once WORD_FILTER_PLUGIN_DIR . 'admin/class-word-filter-admin.php';

function word_filter_init() {
    $plugin = new Word_Filter();
    $plugin->init();

    if (is_admin()) {
        $admin = new Word_Filter_Admin();
        $admin->init();
    }
}
add_action('plugins_loaded', 'word_filter_init');