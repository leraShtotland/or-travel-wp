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

// Disable wpautop for articles to prevent redundant <p> tags
add_filter('the_content', function($content) {
    if (is_singular('us_article')) {
        // Remove wpautop filter for articles
        remove_filter('the_content', 'wpautop');
        
        // Check if content looks like markdown (has markdown syntax)
        if (preg_match('/[#*\[\]`]/', $content)) {
            $content = or_travel_parse_markdown($content);
        }
    }
    return $content;
}, 9); // Priority 9 to run before wpautop (which runs at 10)

// Ensure wpautop is completely disabled for us_article post type
add_filter('wpautop_tags', function($tags) {
    global $post;
    if ($post && $post->post_type === 'us_article') {
        return array(); // Return empty array to disable wpautop
    }
    return $tags;
});

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
    or_travel_import_markdown_articles();

    $consultation_page_id = or_travel_ensure_page(
        'consultation',
        __('פגישת ייעוץ', 'or-travel-child'),
        implode(
            "\n\n",
            array(
                '<p>בחרו יום ושעה שמתאימים לכם ופגישה אישית תעזור לנו להכיר את החלום האמריקאי שלכם מקרוב.</p>',
                '<ul><li>היכרות עם סגנון הטיול והקצב שלכם</li><li>בחירת יעדים וחוויות שמדברות אליכם</li><li>התאמת מסלול ראשונית ולוחות זמנים</li></ul>',
                '<p>השאירו פרטים ונחזור אליכם עם הצעה מותאמת אישית.</p>',
            )
        )
    );

    $services_page_id = or_travel_ensure_page(
        'services-packages',
        __('שירותים וחבילות', 'or-travel-child'),
        implode(
            "\n\n",
            array(
                '<p>הצוות שלנו מלווה אתכם מהרעיון הראשון ועד החזרה לארץ עם מגוון חבילות תכנון.</p>',
                '<h3>מה כולל כל תכנון?</h3>',
                '<ul><li>שיחת אפיון מעמיקה</li><li>בניית מסלול מפורט עם זמני נסיעה ומפת תחנות</li><li>המלצות עדכניות ללינה, אטרקציות ומסעדות</li><li>ליווי וזמינות בזמן אמת לאורך כל הטיול</li></ul>',
                '<p>נשמח להתאים עבורכם את החבילה המדויקת לצרכים שלכם.</p>',
            )
        )
    );

    $contact_page_id = or_travel_ensure_page(
        'contact',
        __('צור קשר', 'or-travel-child'),
        implode(
            "\n\n",
            array(
                '<p>יש לכם שאלות, רעיון למסלול או רוצים שנתחיל לתכנן יחד?</p>',
                '<p>כתבו לנו ל- <a href="mailto:hello@or-travel.co.il">hello@or-travel.co.il</a> או התקשרו ל- 03-5551234.</p>',
                '<p>מלאו את הטופס ונשוב אליכם בהקדם עם כל המידע.</p>',
            )
        )
    );

    $consultation_menu_item = $consultation_page_id
        ? array(
            'title'     => __('פגישת ייעוץ', 'or-travel-child'),
            'type'      => 'post_type',
            'object'    => 'page',
            'object_id' => $consultation_page_id,
        )
        : array(
            'title' => __('פגישת ייעוץ', 'or-travel-child'),
            'type'  => 'custom',
            'url'   => home_url('/consultation/'),
        );

    $services_menu_item = $services_page_id
        ? array(
            'title'     => __('שירותים וחבילות', 'or-travel-child'),
            'type'      => 'post_type',
            'object'    => 'page',
            'object_id' => $services_page_id,
        )
        : array(
            'title' => __('שירותים וחבילות', 'or-travel-child'),
            'type'  => 'custom',
            'url'   => home_url('/services-packages/'),
        );

    $contact_menu_item = $contact_page_id
        ? array(
            'title'     => __('צור קשר', 'or-travel-child'),
            'type'      => 'post_type',
            'object'    => 'page',
            'object_id' => $contact_page_id,
        )
        : array(
            'title' => __('צור קשר', 'or-travel-child'),
            'type'  => 'custom',
            'url'   => home_url('/contact/'),
        );

    or_travel_ensure_primary_menu(
        array(
            array(
                'title' => __('ראשי', 'or-travel-child'),
                'type'  => 'custom',
                'url'   => home_url('/'),
            ),
            array(
                'title' => __('כתבות', 'or-travel-child'),
                'type'  => 'post_type_archive',
                'object' => 'us_article',
            ),
            $consultation_menu_item,
            $services_menu_item,
            $contact_menu_item,
        )
    );
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

function or_travel_get_default_article_categories() {
    return array(
        'america' => __('אמריקה', 'or-travel-child'),
        'europe'  => __('אירופה', 'or-travel-child'),
        'asia'    => __('אסיה', 'or-travel-child'),
        'africa'  => __('אפריקה', 'or-travel-child'),
        'israel'  => __('ישראל', 'or-travel-child'),
    );
}

function or_travel_get_markdown_article_category_map() {
    return array(
        'boston'                  => 'america',
        'colorado'                => 'america',
        'colorado-roadtrip'       => 'america',
        'charleston-savannah'     => 'america',
        'yellowstone-grand-teton' => 'america',
        'north-india'             => 'asia',
        'kyrgyzstan'              => 'asia',
        'paphos'                  => 'europe',
        'romania'                 => 'europe',
        'amalfi-abruzzo-umbria'   => 'europe',
        'altavia1-venezia'        => 'europe',
        'southafricapart1'        => 'africa',
        'southafricapart2'        => 'africa',
        'tamplemount'             => 'israel',
        'oldcityofjerusalem'      => 'israel',
        'hodakeveinakev'          => 'israel',
    );
}

function or_travel_ensure_article_categories() {
    $categories = or_travel_get_default_article_categories();

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

function or_travel_extract_markdown_title($markdown, $fallback_slug) {
    if (preg_match('/^#\s+(.+)$/m', $markdown, $matches)) {
        return trim($matches[1]);
    }

    if (preg_match('/^##\s+(.+)$/m', $markdown, $matches)) {
        return trim($matches[1]);
    }

    return ucwords(str_replace('-', ' ', $fallback_slug));
}

function or_travel_generate_markdown_excerpt($markdown) {
    $paragraphs = preg_split('/\R{2,}/u', trim($markdown));

    if (empty($paragraphs)) {
        return '';
    }

    foreach ($paragraphs as $paragraph) {
        $paragraph = trim($paragraph);

        if ($paragraph === '' || strpos($paragraph, '#') === 0 || strpos($paragraph, '![', 0) === 0) {
            continue;
        }

        $excerpt_text = wp_strip_all_tags(or_travel_parse_markdown($paragraph));
        $excerpt_text = trim($excerpt_text);

        if ($excerpt_text !== '') {
            return wp_trim_words($excerpt_text, 40, '…');
        }
    }

    return '';
}

function or_travel_import_markdown_articles() {
    $articles_dir = get_stylesheet_directory() . '/articles/wix';

    if (!is_dir($articles_dir)) {
        return;
    }

    $files = glob($articles_dir . '/post_*.md');

    if (empty($files)) {
        return;
    }

    $category_map = or_travel_get_markdown_article_category_map();

    foreach ($files as $file_path) {
        $markdown_content = file_get_contents($file_path);

        if (false === $markdown_content) {
            continue;
        }

        $filename   = basename($file_path, '.md');
        $slug_base  = preg_replace('/^post[-_]/', '', $filename);
        $slug       = sanitize_title($slug_base);
        $post_title = or_travel_extract_markdown_title($markdown_content, $slug);
        $excerpt    = or_travel_generate_markdown_excerpt($markdown_content);

        $post_data = array(
            'post_title'   => $post_title,
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'us_article',
            'post_content' => $markdown_content,
        );

        if ($excerpt !== '') {
            $post_data['post_excerpt'] = $excerpt;
        }

        $existing_post = get_page_by_path($slug, OBJECT, 'us_article');

        if ($existing_post instanceof WP_Post) {
            $post_data['ID'] = $existing_post->ID;
            $post_id         = wp_update_post($post_data, true);
        } else {
            $post_data['post_author'] = get_current_user_id() ?: 1;
            $post_id                  = wp_insert_post($post_data, true);
        }

        if (is_wp_error($post_id)) {
            continue;
        }

        if (isset($category_map[$slug])) {
            $category_slug = $category_map[$slug];
            $term          = get_term_by('slug', $category_slug, 'article_category');

            if ($term && !is_wp_error($term)) {
                wp_set_post_terms($post_id, array($term->term_id), 'article_category', false);
            }
        }
    }
}

function or_travel_ensure_page($slug, $title, $content, $template = '') {
    $page = get_page_by_path($slug);

    if ($page instanceof WP_Post) {
        $page_id = $page->ID;
    } else {
        $page_data = array(
            'post_title'   => $title,
            'post_name'    => sanitize_title($slug),
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $content,
            'post_author'  => get_current_user_id() ?: 1,
        );

        $page_id = wp_insert_post($page_data, true);

        if (is_wp_error($page_id)) {
            return 0;
        }
    }

    if ($template) {
        $current_template = get_page_template_slug($page_id);
        if ($current_template !== $template) {
            update_post_meta($page_id, '_wp_page_template', $template);
        }
    }

    return (int) $page_id;
}

function or_travel_normalize_url($url) {
    if (empty($url)) {
        return '';
    }

    $parts = wp_parse_url($url);

    if (false === $parts) {
        return trim($url);
    }

    $scheme   = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
    $host     = isset($parts['host']) ? $parts['host'] : '';
    $port     = isset($parts['port']) ? ':' . $parts['port'] : '';
    $path     = isset($parts['path']) ? $parts['path'] : '';
    $query    = isset($parts['query']) ? '?' . $parts['query'] : '';
    $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

    if ($path !== '') {
        $path = trailingslashit($path);
    }

    if ($scheme && $host) {
        return $scheme . $host . $port . $path . $query . $fragment;
    }

    return $path . $query . $fragment;
}

function or_travel_menu_item_signature($item) {
    if (!empty($item['type'])) {
        if ('post_type' === $item['type'] && !empty($item['object']) && !empty($item['object_id'])) {
            return 'post_type:' . $item['object'] . ':' . (int) $item['object_id'];
        }

        if ('post_type_archive' === $item['type'] && !empty($item['object'])) {
            return 'archive:' . $item['object'];
        }

        if ('custom' === $item['type'] && !empty($item['url'])) {
            return 'custom:' . or_travel_normalize_url($item['url']);
        }
    }

    return '';
}

function or_travel_existing_menu_signature($item) {
    if (isset($item->type)) {
        if ('post_type' === $item->type && !empty($item->object) && !empty($item->object_id)) {
            return 'post_type:' . $item->object . ':' . (int) $item->object_id;
        }

        if ('post_type_archive' === $item->type && !empty($item->object)) {
            return 'archive:' . $item->object;
        }

        if ('custom' === $item->type && !empty($item->url)) {
            return 'custom:' . or_travel_normalize_url($item->url);
        }
    }

    return '';
}

function or_travel_ensure_primary_menu(array $desired_items) {
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

    $existing_items = wp_get_nav_menu_items($menu->term_id, array('order' => 'ASC'));

    $desired_signatures = array();
    foreach ($desired_items as $item) {
        $desired_signatures[] = or_travel_menu_item_signature($item);
    }

    $current_signatures = array();
    if ($existing_items) {
        foreach ($existing_items as $existing) {
            $current_signatures[] = or_travel_existing_menu_signature($existing);
        }
    }

    if ($desired_signatures === $current_signatures) {
        return;
    }

    if ($existing_items) {
        foreach ($existing_items as $existing) {
            wp_delete_post($existing->ID, true);
        }
    }

    foreach ($desired_items as $position => $item) {
        $args = array(
            'menu-item-title'     => $item['title'],
            'menu-item-status'    => 'publish',
            'menu-item-position'  => $position + 1,
            'menu-item-parent-id' => 0,
        );

        if ('custom' === $item['type']) {
            $args['menu-item-type'] = 'custom';
            $args['menu-item-url']  = isset($item['url']) ? $item['url'] : home_url('/');
        } elseif ('post_type_archive' === $item['type']) {
            $args['menu-item-type']   = 'post_type_archive';
            $args['menu-item-object'] = $item['object'];

            $archive_url = get_post_type_archive_link($item['object']);
            if ($archive_url) {
                $args['menu-item-url'] = $archive_url;
            }
        } elseif ('post_type' === $item['type']) {
            if (!empty($item['object']) && !empty($item['object_id'])) {
                $args['menu-item-type']      = 'post_type';
                $args['menu-item-object']    = $item['object'];
                $args['menu-item-object-id'] = (int) $item['object_id'];
            } else {
                continue;
            }
        }

        wp_update_nav_menu_item($menu->term_id, 0, $args);
    }
}
