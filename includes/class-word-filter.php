<?php
class Word_Filter {
    public function init() {
        add_filter('the_content', array($this, 'filter_content'));
        add_filter('the_excerpt', array($this, 'filter_content'));
    }

    public function filter_content($content) {
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
}