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
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('travel-article'); ?>>

                    <header class="article-hero">
                        <div class="article-meta-top">
                            <?php
                            // Display categories
                            $categories = get_the_terms(get_the_ID(), 'article_category');
                            if ($categories && !is_wp_error($categories)) : ?>
                                <div class="article-categories">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="article-category">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="article-date">
                                <span class="article-date-label"><?php esc_html_e('פורסם בתאריך', 'or-travel-child'); ?></span>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </div>
                        </div>

                        <?php the_title('<h1 class="article-title">', '</h1>'); ?>

                        <?php if (has_excerpt()) : ?>
                            <p class="article-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                        <?php endif; ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <figure class="article-featured-image">
                            <?php the_post_thumbnail('full'); ?>
                            <?php if ($caption = get_the_post_thumbnail_caption()) : ?>
                                <figcaption><?php echo esc_html($caption); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <div class="article-body markdown-body">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('עמודים:', 'or-travel-child'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="article-footer">
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
                        'prev_text' => '<span class="nav-subtitle">' . __('הכתבה הקודמת', 'or-travel-child') . '</span><span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . __('הכתבה הבאה', 'or-travel-child') . '</span><span class="nav-title">%title</span>',
                        'screen_reader_text' => __('ניווט בין כתבות', 'or-travel-child'),
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
