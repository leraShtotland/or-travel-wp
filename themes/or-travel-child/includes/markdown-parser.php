<?php
/**
 * Markdown parsing helpers for the Or Travel child theme.
 *
 * The parser intentionally keeps the implementation lightweight while supporting
 * the Markdown features used across the imported travel articles. Block level
 * features (headings, lists, blockquotes, tables and code blocks) are detected
 * in a single pass, while inline formatting is handled separately in order to
 * avoid conflicting replacements.
 */

if (!function_exists('or_travel_parse_markdown')) {
    /**
     * Convert a Markdown string into HTML that can be safely rendered inside an
     * article page.
     */
    function or_travel_parse_markdown($markdown)
    {
        if (!is_string($markdown) || trim($markdown) === '') {
            return '';
        }

        $markdown = str_replace(["\r\n", "\r"], "\n", trim($markdown));

        $lines = explode("\n", $markdown);
        $blocks = or_travel_parse_markdown_blocks($lines);

        $html = implode("\n", $blocks);
        $html = or_travel_normalize_article_media_paths($html);

        return $html;
    }
}

if (!function_exists('or_travel_parse_markdown_blocks')) {
    /**
     * Parse Markdown blocks from a list of lines.
     *
     * @param string[] $lines
     * @return string[]
     */
    function or_travel_parse_markdown_blocks(array $lines)
    {
        $blocks = [];
        $total = count($lines);

        for ($index = 0; $index < $total; $index++) {
            $line = $lines[$index];

            if (trim($line) === '') {
                continue;
            }

            // Fenced code block
            if (preg_match('/^```([^`]*)$/', $line, $matches)) {
                $language = trim($matches[1]);
                $codeLines = [];
                $index++;
                while ($index < $total && !preg_match('/^```\s*$/', $lines[$index])) {
                    $codeLines[] = $lines[$index];
                    $index++;
                }

                $code = implode("\n", $codeLines);
                $code = rtrim($code, "\n");
                $blocks[] = sprintf(
                    '<pre class="markdown-code"><code%s>%s</code></pre>',
                    $language !== '' ? ' class="language-' . esc_attr($language) . '"' : '',
                    esc_html($code)
                );
                continue;
            }

            // Setext heading (look ahead)
            if (
                $index + 1 < $total
                && preg_match('/^=+$/', trim($lines[$index + 1]))
            ) {
                $blocks[] = sprintf('<h1>%s</h1>', or_travel_parse_markdown_inline(trim($line)));
                $index++;
                continue;
            }

            if (
                $index + 1 < $total
                && preg_match('/^-+$/', trim($lines[$index + 1]))
            ) {
                $blocks[] = sprintf('<h2>%s</h2>', or_travel_parse_markdown_inline(trim($line)));
                $index++;
                continue;
            }

            // ATX heading (#, ## ...)
            if (preg_match('/^(#{1,6})\s+(.+)$/', $line, $matches)) {
                $level = strlen($matches[1]);
                $text = trim($matches[2]);
                $blocks[] = sprintf('<h%d>%s</h%d>', $level, or_travel_parse_markdown_inline($text), $level);
                continue;
            }

            // Blockquote
            if (preg_match('/^\s*>/', $line)) {
                $quoteLines = [ltrim(preg_replace('/^>\s?/', '', ltrim($line)))];
                $index++;
                while ($index < $total && preg_match('/^\s*>/', $lines[$index])) {
                    $quoteLines[] = ltrim(preg_replace('/^>\s?/', '', ltrim($lines[$index])));
                    $index++;
                }
                $index--;
                $quoteHtml = or_travel_parse_markdown(implode("\n", $quoteLines));
                $blocks[] = sprintf('<blockquote>%s</blockquote>', $quoteHtml);
                continue;
            }

            // Table support: header line must contain pipes and followed by separator
            if (
                strpos($line, '|') !== false
                && $index + 1 < $total
                && preg_match('/^\s*\|?\s*:?[-=]+:?\s*(\|\s*:?[-=]+:?\s*)+$/', trim($lines[$index + 1]))
            ) {
                $headerCells = or_travel_split_table_row($line);
                $alignments = or_travel_parse_table_alignment($lines[$index + 1]);
                $index += 2;

                $bodyRows = [];
                while ($index < $total && trim($lines[$index]) !== '') {
                    $bodyRows[] = or_travel_split_table_row($lines[$index]);
                    $index++;
                }
                $index--;

                $blocks[] = or_travel_render_markdown_table($headerCells, $alignments, $bodyRows);
                continue;
            }

            // Lists (ordered/unordered + task lists)
            if (preg_match('/^\s*([*+-]|\d+\.)\s+/', $line)) {
                [$listHtml, $index] = or_travel_parse_markdown_list($lines, $index, $total);
                $blocks[] = $listHtml;
                continue;
            }

            // Horizontal rule
            if (preg_match('/^(\*\s*){3,}$|^(\-\s*){3,}$|^(\_\s*){3,}$/', trim($line))) {
                $blocks[] = '<hr />';
                continue;
            }

            // Paragraph fallback
            $paragraphLines = [$line];
            $index++;
            while ($index < $total && trim($lines[$index]) !== '') {
                $paragraphLines[] = $lines[$index];
                $index++;
            }
            $index--;

            $paragraph = trim(implode(' ', $paragraphLines));
            $blocks[] = sprintf('<p>%s</p>', or_travel_parse_markdown_inline($paragraph));
        }

        return $blocks;
    }
}

if (!function_exists('or_travel_parse_markdown_inline')) {
    /**
     * Apply inline Markdown replacements.
     */
    function or_travel_parse_markdown_inline($text)
    {
        if ($text === '') {
            return '';
        }

        // Escape HTML first so we can safely re-introduce limited tags later.
        $text = esc_html($text);

        // Inline code first to avoid interfering with emphasis replacements.
        $text = preg_replace_callback('/`([^`]+)`/', function ($matches) {
            return '<code>' . esc_html($matches[1]) . '</code>';
        }, $text);

        // Images: ![alt](url "title")
        $text = preg_replace_callback('/!\[(.*?)\]\(([^\s\)]+)(?:\s+"(.*?)")?\)/', function ($matches) {
            $src = esc_url($matches[2]);
            $alt = esc_attr($matches[1]);
            $title = isset($matches[3]) ? esc_attr($matches[3]) : '';

            $attributes = sprintf(' src="%s" alt="%s" class="markdown-image"', $src, $alt);
            if ($title !== '') {
                $attributes .= sprintf(' title="%s"', $title);
            }

            return sprintf('<img%s />', $attributes);
        }, $text);

        // Links: [text](url "title")
        $text = preg_replace_callback('/\[(.*?)\]\(([^\s\)]+)(?:\s+"(.*?)")?\)/', function ($matches) {
            $href = esc_url($matches[2]);
            $title = isset($matches[3]) ? esc_attr($matches[3]) : '';
            $attributes = ' href="' . $href . '"';
            if ($title !== '') {
                $attributes .= ' title="' . $title . '"';
            }
            return sprintf('<a%s>%s</a>', $attributes, $matches[1]);
        }, $text);

        // Bold, italic, strikethrough
        $text = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__([^_]+)__/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(?!\s)([^*]+?)(?!\s)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(?!\s)([^_]+?)(?!\s)_/', '<em>$1</em>', $text);
        $text = preg_replace('/~~([^~]+)~~/', '<del>$1</del>', $text);

        // Automatic links
        $text = preg_replace_callback('/(?<![\"\'>])(https?:\/\/[^\s<]+)/', function ($matches) {
            $url = esc_url($matches[1]);
            return sprintf('<a href="%1$s" rel="noopener" target="_blank">%1$s</a>', $url);
        }, $text);

        return $text;
    }
}

if (!function_exists('or_travel_parse_markdown_list')) {
    /**
     * Parse list blocks (ordered/unordered and task lists).
     */
    function or_travel_parse_markdown_list(array $lines, $startIndex, $total)
    {
        $items = [];
        $isOrdered = null;
        $index = $startIndex;

        while ($index < $total) {
            $line = $lines[$index];
            if (trim($line) === '') {
                break;
            }

            if (!preg_match('/^\s*([*+-]|\d+\.)\s+(.*)$/', $line, $matches)) {
                break;
            }

            $marker = $matches[1];
            $content = $matches[2];

            if ($isOrdered === null) {
                $isOrdered = is_numeric($marker[0]);
            }

            $task = null;
            if (preg_match('/^\[( |x|X)\]\s+(.*)$/', $content, $taskMatches)) {
                $task = strtolower($taskMatches[1]) === 'x';
                $content = $taskMatches[2];
            }

            $subLines = [];
            $index++;
            while ($index < $total && preg_match('/^\s{2,}.+$/', $lines[$index])) {
                $subLines[] = preg_replace('/^\s{2}/', '', $lines[$index]);
                $index++;
            }
            $index--;

            $innerHtml = or_travel_parse_markdown_inline($content);
            if (!empty($subLines)) {
                $innerHtml .= or_travel_parse_markdown(implode("\n", $subLines));
            }

            if ($task !== null) {
                $innerHtml = sprintf(
                    '<label class="markdown-task"><input type="checkbox" disabled %s /> <span>%s</span></label>',
                    $task ? 'checked' : '',
                    $innerHtml
                );
            }

            $items[] = sprintf('<li>%s</li>', $innerHtml);

            $index++;
        }

        $tag = $isOrdered ? 'ol' : 'ul';
        $listHtml = sprintf('<%1$s>%2$s</%1$s>', $tag, implode('', $items));

        return [$listHtml, $index - 1];
    }
}

if (!function_exists('or_travel_split_table_row')) {
    function or_travel_split_table_row($line)
    {
        $line = trim($line);
        $line = trim($line, '|');
        $cells = array_map('trim', explode('|', $line));

        return $cells;
    }
}

if (!function_exists('or_travel_parse_table_alignment')) {
    function or_travel_parse_table_alignment($line)
    {
        $segments = or_travel_split_table_row($line);
        $alignments = [];

        foreach ($segments as $segment) {
            $hasLeft = strpos($segment, ':') === 0;
            $hasRight = substr($segment, -1) === ':';

            if ($hasLeft && $hasRight) {
                $alignments[] = 'center';
            } elseif ($hasRight) {
                $alignments[] = 'right';
            } elseif ($hasLeft) {
                $alignments[] = 'left';
            } else {
                $alignments[] = null;
            }
        }

        return $alignments;
    }
}

if (!function_exists('or_travel_render_markdown_table')) {
    function or_travel_render_markdown_table(array $headerCells, array $alignments, array $bodyRows)
    {
        $theadCells = [];
        foreach ($headerCells as $index => $text) {
            $style = isset($alignments[$index]) && $alignments[$index]
                ? ' style="text-align:' . esc_attr($alignments[$index]) . '"'
                : '';
            $theadCells[] = sprintf('<th%s>%s</th>', $style, or_travel_parse_markdown_inline($text));
        }

        $tbodyRows = [];
        foreach ($bodyRows as $row) {
            $cells = [];
            foreach ($row as $index => $text) {
                $style = isset($alignments[$index]) && $alignments[$index]
                    ? ' style="text-align:' . esc_attr($alignments[$index]) . '"'
                    : '';
                $cells[] = sprintf('<td%s>%s</td>', $style, or_travel_parse_markdown_inline($text));
            }
            $tbodyRows[] = '<tr>' . implode('', $cells) . '</tr>';
        }

        return '<table class="markdown-table"><thead><tr>'
            . implode('', $theadCells)
            . '</tr></thead><tbody>'
            . implode('', $tbodyRows)
            . '</tbody></table>';
    }
}

if (!function_exists('or_travel_normalize_article_media_paths')) {
    /**
     * Ensure images that use relative paths point to the dedicated article media directory.
     */
    function or_travel_normalize_article_media_paths($html)
    {
        if (false === strpos($html, '<img')) {
            return $html;
        }

        $baseUri = trailingslashit(get_stylesheet_directory_uri()) . 'assets/images/articles/';

        return preg_replace_callback('/<img([^>]+)src="([^"\\>]+)"([^>]*)>/i', function ($matches) use ($baseUri) {
            $src = $matches[2];

            if (
                preg_match('#^(?:https?:)?//#', $src)
                || strpos($src, 'data:') === 0
                || strpos($src, '/') === 0
            ) {
                return $matches[0];
            }

            $normalized = esc_url($baseUri . ltrim($src, '/'));

            return sprintf('<img%1$ssrc="%2$s"%3$s>', $matches[1], $normalized, $matches[3]);
        }, $html);
    }
}

