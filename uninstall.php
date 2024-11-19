<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('word_filter_words');
delete_option('word_filter_replacement');