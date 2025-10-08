<?php
/**
 * Or Travel Child Theme Functions
 */

// Enqueue parent and child theme styles
add_action('wp_enqueue_scripts', function() {
    // Enqueue parent theme style
    wp_enqueue_style('astra-parent-theme', get_template_directory_uri() . '/style.css');
    
    // Enqueue child theme style
    wp_enqueue_style('or-travel-child-theme', get_stylesheet_uri(), array('astra-parent-theme'), '1.0.0');
    
    // Enqueue additional child theme CSS
    wp_enqueue_style('or-travel-child-custom', get_stylesheet_directory_uri() . '/assets/css/child.css', array('or-travel-child-theme'), '1.0.0');
});

// Add RTL support for Hebrew
add_action('after_setup_theme', function() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Add support for wide blocks
    add_theme_support('align-wide');
});

// Set default Astra settings for better appearance
add_filter('astra_theme_defaults', function($defaults) {
    $defaults['site-content-width'] = 1200;
    $defaults['header-main-sep'] = 0;
    $defaults['header-main-menu-align'] = 'flex-end';
    $defaults['header-main-layout-width'] = 'content';
    
    return $defaults;
});

// Register Custom Post Type for US Travel Articles
add_action('init', function() {
    $labels = array(
        'name'                  => _x('כתבות בארצות הברית', 'Post Type General Name', 'or-travel-child'),
        'singular_name'         => _x('כתבה בארצות הברית', 'Post Type Singular Name', 'or-travel-child'),
        'menu_name'             => __('כתבות בארצות הברית', 'or-travel-child'),
        'name_admin_bar'        => __('כתבה בארצות הברית', 'or-travel-child'),
        'archives'              => __('ארכיון כתבות', 'or-travel-child'),
        'attributes'            => __('מאפייני כתבה', 'or-travel-child'),
        'parent_item_colon'     => __('כתבת אב:', 'or-travel-child'),
        'all_items'             => __('כל הכתבות', 'or-travel-child'),
        'add_new_item'          => __('הוספת כתבה חדשה', 'or-travel-child'),
        'add_new'               => __('הוסף חדשה', 'or-travel-child'),
        'new_item'              => __('כתבה חדשה', 'or-travel-child'),
        'edit_item'             => __('ערוך כתבה', 'or-travel-child'),
        'update_item'           => __('עדכן כתבה', 'or-travel-child'),
        'view_item'             => __('צפה בכתבה', 'or-travel-child'),
        'view_items'            => __('צפה בכתבות', 'or-travel-child'),
        'search_items'          => __('חפש כתבה', 'or-travel-child'),
        'not_found'             => __('לא נמצאו כתבות', 'or-travel-child'),
        'not_found_in_trash'    => __('לא נמצאו כתבות באשפה', 'or-travel-child'),
        'featured_image'        => __('תמונה ראשית', 'or-travel-child'),
        'set_featured_image'    => __('הגדר תמונה ראשית', 'or-travel-child'),
        'remove_featured_image' => __('הסר תמונה ראשית', 'or-travel-child'),
        'use_featured_image'    => __('השתמש כתמונה ראשית', 'or-travel-child'),
        'insert_into_item'      => __('הכנס לכתבה', 'or-travel-child'),
        'uploaded_to_this_item' => __('הועלה לכתבה זו', 'or-travel-child'),
        'items_list'            => __('רשימת כתבות', 'or-travel-child'),
        'items_list_navigation' => __('ניווט רשימת כתבות', 'or-travel-child'),
        'filter_items_list'     => __('סינון רשימת כתבות', 'or-travel-child'),
    );
    
    $args = array(
        'label'                 => __('כתבה בארצות הברית', 'or-travel-child'),
        'description'           => __('כתבות על יעדים בארצות הברית', 'or-travel-child'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'),
        'taxonomies'            => array('article_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-location-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'us-articles',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'us-article'),
    );
    
    register_post_type('us_article', $args);
});

// Register Custom Taxonomy for Article Categories
add_action('init', function() {
    $labels = array(
        'name'                       => _x('קטגוריות כתבות', 'Taxonomy General Name', 'or-travel-child'),
        'singular_name'              => _x('קטגוריית כתבות', 'Taxonomy Singular Name', 'or-travel-child'),
        'menu_name'                  => __('קטגוריות', 'or-travel-child'),
        'all_items'                  => __('כל הקטגוריות', 'or-travel-child'),
        'parent_item'                => __('קטגוריית אב', 'or-travel-child'),
        'parent_item_colon'          => __('קטגוריית אב:', 'or-travel-child'),
        'new_item_name'              => __('שם קטגוריה חדשה', 'or-travel-child'),
        'add_new_item'               => __('הוסף קטגוריה חדשה', 'or-travel-child'),
        'edit_item'                  => __('ערוך קטגוריה', 'or-travel-child'),
        'update_item'                => __('עדכן קטגוריה', 'or-travel-child'),
        'view_item'                  => __('צפה בקטגוריה', 'or-travel-child'),
        'separate_items_with_commas' => __('הפרד קטגוריות בפסיקים', 'or-travel-child'),
        'add_or_remove_items'        => __('הוסף או הסר קטגוריות', 'or-travel-child'),
        'choose_from_most_used'      => __('בחר מהקטגוריות הנפוצות', 'or-travel-child'),
        'popular_items'              => __('קטגוריות פופולריות', 'or-travel-child'),
        'search_items'               => __('חפש קטגוריות', 'or-travel-child'),
        'not_found'                  => __('לא נמצאו קטגוריות', 'or-travel-child'),
        'no_terms'                   => __('אין קטגוריות', 'or-travel-child'),
        'items_list'                 => __('רשימת קטגוריות', 'or-travel-child'),
        'items_list_navigation'      => __('ניווט רשימת קטגוריות', 'or-travel-child'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'article-category'),
    );
    
    register_taxonomy('article_category', array('us_article'), $args);
});

// Add Markdown support for articles
require_once get_stylesheet_directory() . '/includes/markdown-parser.php';

// Convert Markdown to HTML for article content
add_filter('the_content', function($content) {
    if (is_singular('us_article')) {
        // Check if content looks like markdown (has markdown syntax)
        if (preg_match('/[#*\[\]`]/', $content)) {
            $content = or_travel_parse_markdown($content);
        }
    }
    return $content;
}, 10);

// Add custom meta box for markdown file upload
add_action('add_meta_boxes', function() {
    add_meta_box(
        'us_article_markdown',
        __('קובץ Markdown', 'or-travel-child'),
        'or_travel_markdown_meta_box_callback',
        'us_article',
        'side',
        'default'
    );
});

function or_travel_markdown_meta_box_callback($post) {
    wp_nonce_field('us_article_markdown_nonce', 'us_article_markdown_nonce_field');
    ?>
    <p>
        <label for="us_article_markdown_file">
            <?php _e('העלאת קובץ Markdown (.md):', 'or-travel-child'); ?>
        </label>
        <input type="file" id="us_article_markdown_file" name="us_article_markdown_file" accept=".md" />
    </p>
    <p class="description">
        <?php _e('העלו קובץ ‎.md כדי למלא אוטומטית את תוכן הכתבה.', 'or-travel-child'); ?>
    </p>
    <?php
}

// Save markdown file content to post content
add_action('save_post_us_article', function($post_id) {
    // Check nonce
    if (!isset($_POST['us_article_markdown_nonce_field']) || 
        !wp_verify_nonce($_POST['us_article_markdown_nonce_field'], 'us_article_markdown_nonce')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Handle file upload
    if (isset($_FILES['us_article_markdown_file']) && $_FILES['us_article_markdown_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['us_article_markdown_file'];
        
        // Verify it's a markdown file
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($file_ext === 'md') {
            $markdown_content = file_get_contents($file['tmp_name']);
            
            // Update post content with markdown
            remove_action('save_post_us_article', 'or_travel_save_markdown_content');
            wp_update_post(array(
                'ID' => $post_id,
                'post_content' => $markdown_content
            ));
            add_action('save_post_us_article', 'or_travel_save_markdown_content');
        }
    }
}, 10, 1);

add_action('init', 'or_travel_seed_initial_content', 20);
add_action('after_switch_theme', 'or_travel_seed_initial_content');

function or_travel_seed_initial_content() {
    if (wp_installing()) {
        return;
    }

    or_travel_ensure_about_page();
    or_travel_ensure_article_categories();
    or_travel_ensure_initial_us_article();
    or_travel_ensure_us_articles_menu_item();
}

function or_travel_ensure_about_page() {
    $about_page = get_page_by_path('about');

    if (!$about_page) {
        $page_content = implode(
            "\n\n",
            array(
                '<p>ברוכים הבאים לאתר המסע האמריקאי שלנו. כאן תמצאו טיפים, מסלולים ותובנות לכל יעד שאנחנו אוהבים.</p>',
                '<p>אני חוקרת יעדים בארצות הברית מזה שנים, ומאמינה שסיפורים טובים מתחילים בתכנון נכון ובסקרנות אין-סופית.</p>',
                '<p>צרו איתי קשר עם שאלות, רעיונות או הצעות למסלולים חדשים שתרצו לקרוא עליהם.</p>',
            )
        );

        $about_page_id = wp_insert_post(
            array(
                'post_title'   => 'אודות',
                'post_name'    => 'about',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => $page_content,
                'post_author'  => get_current_user_id() ?: 1,
                'meta_input'   => array(
                    '_wp_page_template' => 'page-about.php',
                ),
            )
        );

        if (is_wp_error($about_page_id)) {
            return;
        }

        $about_page = get_post($about_page_id);
    } else {
        $current_template = get_page_template_slug($about_page->ID);
        if ('page-about.php' !== $current_template) {
            update_post_meta($about_page->ID, '_wp_page_template', 'page-about.php');
        }
    }
}

function or_travel_ensure_article_categories() {
    $categories = array(
        'east-coast' => __('החוף המזרחי', 'or-travel-child'),
        'west-coast' => __('החוף המערבי', 'or-travel-child'),
        'midwest'    => __('המערב התיכון', 'or-travel-child'),
        'south'      => __('הדרום', 'or-travel-child'),
    );

    foreach ($categories as $slug => $label) {
        if (!term_exists($slug, 'article_category')) {
            wp_insert_term(
                $label,
                'article_category',
                array(
                    'slug' => $slug,
                )
            );
        }
    }
}

function or_travel_ensure_initial_us_article() {
    $markdown_path = get_stylesheet_directory() . '/articles/east-coast-roadtrip.md';

    if (!file_exists($markdown_path)) {
        return;
    }

    $markdown_content = file_get_contents($markdown_path);

    if (false === $markdown_content) {
        return;
    }

    $slug          = 'east-coast-roadtrip';
    $post_title    = __('הנקודות הבולטות במסע כביש בחוף המזרחי', 'or-travel-child');
    $post_excerpt  = __('גלו מסע בן חמישה ימים מניו יורק ועד וושינגטון די.סי. המשלב אוכל, היסטוריה ונופי חוף.', 'or-travel-child');
    $existing_post = get_page_by_path($slug, OBJECT, 'us_article');

    $post_data = array(
        'post_title'   => $post_title,
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_type'    => 'us_article',
        'post_content' => $markdown_content,
        'post_excerpt' => $post_excerpt,
    );

    if ($existing_post instanceof WP_Post) {
        $post_data['ID'] = $existing_post->ID;
        $post_id         = wp_update_post($post_data, true);
    } else {
        $post_data['post_author'] = get_current_user_id() ?: 1;
        $post_id                  = wp_insert_post($post_data, true);
    }

    if (is_wp_error($post_id)) {
        return;
    }

    $east_coast_term = get_term_by('slug', 'east-coast', 'article_category');
    if ($east_coast_term && !is_wp_error($east_coast_term)) {
        wp_set_post_terms(
            $post_id,
            array($east_coast_term->term_id),
            'article_category',
            false
        );
    }
}

function or_travel_ensure_us_articles_menu_item() {
    $locations = get_nav_menu_locations();
    $menu_id   = isset($locations['primary']) ? (int) $locations['primary'] : 0;

    if (!$menu_id) {
        $menu_id = wp_create_nav_menu(__('תפריט ראשי', 'or-travel-child'));

        if (is_wp_error($menu_id)) {
            return;
        }

        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    $menu = wp_get_nav_menu_object($menu_id);

    if (!$menu) {
        return;
    }

    $target_url = trailingslashit(home_url('/us-articles/'));
    $menu_items = wp_get_nav_menu_items($menu->term_id);

    if ($menu_items) {
        foreach ($menu_items as $item) {
            if (trailingslashit($item->url) === $target_url) {
                return;
            }
        }
    }

    wp_update_nav_menu_item(
        $menu->term_id,
        0,
        array(
            'menu-item-title'  => __('כתבות בארצות הברית', 'or-travel-child'),
            'menu-item-url'    => $target_url,
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        )
    );
}
