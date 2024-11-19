<?php
class Word_Filter_Admin {
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_filter('plugin_action_links_' . plugin_basename(WORD_FILTER_PLUGIN_DIR . 'word-filter.php'), 
                  array($this, 'add_settings_link'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'Word Filter',
            'Word Filter',
            'manage_options',
            'word-filter',
            array($this, 'render_options_page'),
            'dashicons-edit',
            100
        );
    }

    public function register_settings() {
        register_setting('word_filter_options', 'word_filter_words');
        register_setting('word_filter_options', 'word_filter_replacement');
    }

    public function add_settings_link($links) {
        $settings_link = '<a href="admin.php?page=word-filter">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function render_options_page() {
        require_once WORD_FILTER_PLUGIN_DIR . 'admin/views/options-page.php';
    }
}