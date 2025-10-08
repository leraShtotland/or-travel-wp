<?php
/**
 * Template for displaying single US Article
 */

get_header(); ?>

<div class="ast-container">
    <div id="primary" class="content-area primary">
        <main id="main" class="site-main">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">
                        <?php
                        // Display categories
                        $categories = get_the_terms(get_the_ID(), 'article_category');
                        if ($categories && !is_wp_error($categories)) : ?>
                            <div class="article-categories">
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo get_term_link($category); ?>" class="article-category">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        
                        <div class="entry-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="article-featured-image">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('עמודים:', 'or-travel-child'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        // Display tags if available
                        $tags = get_the_tags();
                        if ($tags) : ?>
                            <div class="article-tags">
                                <span class="tags-label"><?php _e('תגיות:', 'or-travel-child'); ?></span>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo get_tag_link($tag); ?>" class="tag">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (get_edit_post_link()) : ?>
                            <div class="edit-link">
                                <?php
                                edit_post_link(
                                    sprintf(
                                        wp_kses(
                                            __('עריכה <span class="screen-reader-text">%s</span>', 'or-travel-child'),
                                            array(
                                                'span' => array(
                                                    'class' => array(),
                                                ),
                                            )
                                        ),
                                        get_the_title()
                                    ),
                                    '<span class="edit-link">',
                                    '</span>'
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                    </footer>
                    
                    <?php
                    // Navigation to next/previous article
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . __('הכתבה הקודמת:', 'or-travel-child') . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . __('הכתבה הבאה:', 'or-travel-child') . '</span> <span class="nav-title">%title</span>',
                    ));
                    ?>
                    
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
