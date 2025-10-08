<?php
/**
 * Template Name: About Me
 * Description: Custom template for About Me page with enhanced styling
 */

get_header(); ?>

<div class="ast-container">
    <div id="primary" class="content-area primary">
        <main id="main" class="site-main">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('about-page'); ?>>
                    
                    <header class="entry-header about-header">
                        <div class="about-header-content">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="about-featured-image">
                                    <?php the_post_thumbnail('large', array('class' => 'about-profile-image')); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="entry-content about-content">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'עמודים:', 'or-travel-child' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <?php if ( get_edit_post_link() ) : ?>
                        <footer class="entry-footer">
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        __( 'עריכה <span class="screen-reader-text">%s</span>', 'or-travel-child' ),
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
                        </footer>
                    <?php endif; ?>
                    
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
