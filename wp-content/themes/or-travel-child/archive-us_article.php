<?php
/**
 * Template for displaying US Articles archive
 */

get_header(); ?>

<div class="ast-container">
    <div id="primary" class="content-area primary">
        <main id="main" class="site-main">
            
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    if (is_tax('article_category')) {
                        single_term_title();
                    } else {
                        _e('כתבות מסע בארצות הברית', 'or-travel-child');
                    }
                    ?>
                </h1>
                <?php
                if (is_tax('article_category')) {
                    $term_description = term_description();
                    if (!empty($term_description)) {
                        echo '<div class="taxonomy-description">' . $term_description . '</div>';
                    }
                }
                ?>
            </header>

            <?php
            // Display category filter
            $categories = get_terms(array(
                'taxonomy' => 'article_category',
                'hide_empty' => true,
            ));
            
            if (!empty($categories) && !is_wp_error($categories)) : ?>
                <nav class="article-categories-nav">
                    <h3><?php _e('סינון לפי קטגוריה', 'or-travel-child'); ?></h3>
                    <ul>
                        <li class="<?php echo !is_tax() ? 'current-cat' : ''; ?>">
                            <a href="<?php echo get_post_type_archive_link('us_article'); ?>">
                                <?php _e('כל הכתבות', 'or-travel-child'); ?>
                            </a>
                        </li>
                        <?php foreach ($categories as $category) : ?>
                            <li class="<?php echo is_tax('article_category', $category->slug) ? 'current-cat' : ''; ?>">
                                <a href="<?php echo get_term_link($category); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <div class="us-articles-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('article-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('class' => 'article-card-image')); ?>
                                </a>
                            <?php endif; ?>
                            
                            <div class="article-card-content">
                                <h2 class="article-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="article-card-excerpt">
                                    <?php 
                                    if (has_excerpt()) {
                                        the_excerpt();
                                    } else {
                                        echo wp_trim_words(get_the_content(), 30);
                                    }
                                    ?>
                                </div>
                                
                                <div class="article-card-meta">
                                    <?php
                                    $categories = get_the_terms(get_the_ID(), 'article_category');
                                    if ($categories && !is_wp_error($categories)) :
                                        $category = array_shift($categories);
                                        ?>
                                        <span class="article-category">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('&laquo; הכתבה הקודמת', 'or-travel-child'),
                    'next_text' => __('הכתבה הבאה &raquo;', 'or-travel-child'),
                ));
                ?>

            <?php else : ?>
                <div class="no-results">
                    <h2><?php _e('לא נמצאו כתבות', 'or-travel-child'); ?></h2>
                    <p><?php _e('לא פורסמו כתבות עדיין. חזרו בקרוב!', 'or-travel-child'); ?></p>
                </div>
            <?php endif; ?>
            
        </main>
    </div>
</div>

<?php get_footer(); ?>
