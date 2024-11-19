<?php
if (!defined('ABSPATH')) {
    exit;
}

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