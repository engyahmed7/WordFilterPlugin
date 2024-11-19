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

function word_filter_admin_menu() {
    add_menu_page(
        'Word Filter', 
        'Word Filter', 
        'manage_options',
        'word-filter', 
        'word_filter_options_page', 
        'dashicons-edit', 
        100 
    );

    add_submenu_page(
        'word-filter', 
        'Word Filter Options', 
        'Options', 
        'manage_options',
        'word-filter', 
        'word_filter_options_page' 
    );
}
add_action('admin_menu', 'word_filter_admin_menu');

function word_filter_options_page() {
    if (isset($_POST['word_filter_submit'])) {
        check_admin_referer('word_filter_options_update', 'word_filter_nonce');
        
        $words_to_filter = sanitize_textarea_field($_POST['words_to_filter']);
        $replacement_text = sanitize_text_field($_POST['replacement_text']);
        
        update_option('word_filter_words', $words_to_filter);
        update_option('word_filter_replacement', $replacement_text);
        
        echo '<div class="updated"><p>Settings saved!</p></div>';
    }
    
    $words_to_filter = get_option('word_filter_words', '');
    $replacement_text = get_option('word_filter_replacement', '');
    
    ?>
    <div class="wrap">
        <h1>Word Filter Options</h1>
        <form method="post" action="">
            <?php wp_nonce_field('word_filter_options_update', 'word_filter_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="words_to_filter">Words to Filter</label>
                    </th>
                    <td>
                        <textarea name="words_to_filter" id="words_to_filter" rows="5" cols="50" class="large-text"><?php echo esc_textarea($words_to_filter); ?></textarea>
                        <p class="description">Enter words to filter, one per line</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="replacement_text">Replacement Text</label>
                    </th>
                    <td>
                        <input type="text" name="replacement_text" id="replacement_text" value="<?php echo esc_attr($replacement_text); ?>" class="regular-text">
                        <p class="description">Text to replace filtered words with</p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="word_filter_submit" class="button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

function word_filter_content($content) {
    $words_to_filter = get_option('word_filter_words', '');
    $replacement_text = get_option('word_filter_replacement', '');
    
    if (empty($words_to_filter) || empty($replacement_text)) {
        return $content;
    }
    
    $words_array = array_map('trim', explode("\n", $words_to_filter));
    
    $words_array = array_filter($words_array);
    
    if (empty($words_array)) {
        return $content;
    }
    
    $pattern = '/\b(' . implode('|', array_map('preg_quote', $words_array)) . ')\b/i';
    
    return preg_replace($pattern, $replacement_text, $content);
}

add_filter('the_content', 'word_filter_content');
add_filter('the_excerpt', 'word_filter_content');

function word_filter_settings_link($links) {
    $settings_link = '<a href="admin.php?page=word-filter">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin_base_name = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin_base_name", 'word_filter_settings_link');

function word_filter_register_settings() {
    register_setting('word_filter_options', 'word_filter_words');
    register_setting('word_filter_options', 'word_filter_replacement');
}
add_action('admin_init', 'word_filter_register_settings');