<?php
/**
 * Manually trigger article import
 * Run this file to import markdown articles into WordPress
 */

// Load WordPress
require_once('../../../wp-load.php');

// Check if user is logged in and is admin
if (!current_user_can('manage_options')) {
    die('You must be logged in as an administrator to run this script.');
}

echo "<h2>Importing Markdown Articles to WordPress</h2>";
echo "<pre>";

// Run the import function
or_travel_import_markdown_articles();

// Flush rewrite rules to ensure URLs work
flush_rewrite_rules();

echo "\nImport completed!\n\n";

// List all imported articles
$articles = get_posts(array(
    'post_type' => 'us_article',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
));

echo "Imported Articles:\n";
echo "==================\n\n";

foreach ($articles as $article) {
    $permalink = get_permalink($article->ID);
    $categories = wp_get_post_terms($article->ID, 'article_category');
    $cat_names = wp_list_pluck($categories, 'name');
    
    echo "Title: " . $article->post_title . "\n";
    echo "URL: " . $permalink . "\n";
    echo "Category: " . implode(', ', $cat_names) . "\n";
    echo "Status: " . $article->post_status . "\n";
    echo "---\n\n";
}

echo "</pre>";

echo '<p><a href="' . home_url('/us-articles/') . '">View All Articles</a></p>';
echo '<p><a href="' . home_url('/') . '">Go to Homepage</a></p>';
