<?php
/**
 * Simple Markdown Parser for Or Travel Child Theme
 * Converts markdown syntax to HTML
 */

if (!function_exists('or_travel_parse_markdown')) {
    function or_travel_parse_markdown($text) {
        // Escape HTML first
        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
        
        // Headers (must be at start of line)
        $text = preg_replace('/^######\s+(.+)$/m', '<h6>$1</h6>', $text);
        $text = preg_replace('/^#####\s+(.+)$/m', '<h5>$1</h5>', $text);
        $text = preg_replace('/^####\s+(.+)$/m', '<h4>$1</h4>', $text);
        $text = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $text);
        
        // Bold and Italic
        $text = preg_replace('/\*\*\*(.+?)\*\*\*/s', '<strong><em>$1</em></strong>', $text);
        $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $text);
        $text = preg_replace('/___(.+?)___/s', '<strong><em>$1</em></strong>', $text);
        $text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
        $text = preg_replace('/_(.+?)_/s', '<em>$1</em>', $text);
        
        // Code blocks
        $text = preg_replace('/```(.+?)```/s', '<pre><code>$1</code></pre>', $text);
        $text = preg_replace('/`(.+?)`/', '<code>$1</code>', $text);
        
        // Links [text](url)
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);
        
        // Images ![alt](url)
        $text = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1" class="markdown-image" />', $text);
        
        // Unordered lists
        $text = preg_replace_callback('/^(\*|\-|\+)\s+(.+)$/m', function($matches) {
            static $in_list = false;
            $item = '<li>' . $matches[2] . '</li>';
            if (!$in_list) {
                $in_list = true;
                return '<ul>' . $item;
            }
            return $item;
        }, $text);
        
        // Close any open list
        if (preg_match('/<li>/', $text)) {
            $text = preg_replace('/<\/li>(?![\s\S]*<\/li>)/', '</li></ul>', $text);
        }
        
        // Ordered lists
        $text = preg_replace_callback('/^\d+\.\s+(.+)$/m', function($matches) {
            static $in_list = false;
            $item = '<li>' . $matches[1] . '</li>';
            if (!$in_list) {
                $in_list = true;
                return '<ol>' . $item;
            }
            return $item;
        }, $text);
        
        // Close any open ordered list
        if (preg_match('/<ol>/', $text)) {
            $text = preg_replace('/(<ol>.*<\/li>)(?![\s\S]*<\/li>)/s', '$1</ol>', $text);
        }
        
        // Blockquotes
        $text = preg_replace('/^>\s+(.+)$/m', '<blockquote>$1</blockquote>', $text);
        
        // Horizontal rules
        $text = preg_replace('/^(\*\*\*|---|___)$/m', '<hr />', $text);
        
        // Line breaks - convert double line breaks to paragraphs
        $text = preg_replace('/\n\n+/', '</p><p>', $text);
        
        // Wrap in paragraph tags if not already in a block element
        if (!preg_match('/^<[h|p|ul|ol|blockquote|pre]/', $text)) {
            $text = '<p>' . $text . '</p>';
        } else {
            $text = '<p>' . $text;
            if (!preg_match('/<\/[h|p|ul|ol|blockquote|pre]>$/', $text)) {
                $text .= '</p>';
            }
        }
        
        // Clean up empty paragraphs and fix formatting
        $text = preg_replace('/<p><\/p>/', '', $text);
        $text = preg_replace('/<p>(<[h|ul|ol|blockquote|pre])/i', '$1', $text);
        $text = preg_replace('/(<\/[h|ul|ol|blockquote|pre]>)<\/p>/i', '$1', $text);
        
        // Single line breaks
        $text = preg_replace('/\n/', '<br />', $text);
        
        return $text;
    }
}
