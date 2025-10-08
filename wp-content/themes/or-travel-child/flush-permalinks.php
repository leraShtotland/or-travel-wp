<?php
/**
 * Helper script to flush permalinks
 * Access this file once in your browser to flush permalinks: yoursite.com/wp-content/themes/or-travel-child/flush-permalinks.php
 * Then delete this file for security
 */

// Load WordPress
require_once('../../../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('הגישה נדחתה. עליך להיות מחובר כמנהל מערכת.');
}

// Flush rewrite rules
flush_rewrite_rules();

echo '<h1>✅ מבנה הקישורים עודכן בהצלחה!</h1>';
echo '<p>סוג התוכן המותאם "כתבות בארצות הברית" נרשם כעת.</p>';
echo '<p><strong>חשוב:</strong> יש למחוק את הקובץ (flush-permalinks.php) מטעמי אבטחה.</p>';
echo '<p><a href="' . admin_url() . '">מעבר ללוח הבקרה של וורדפרס</a></p>';
echo '<p><a href="' . admin_url('post-new.php?post_type=us_article') . '">הוספת הכתבה הראשונה שלך</a></p>';
?>
