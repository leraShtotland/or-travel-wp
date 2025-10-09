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

                    <?php
                    // Use a specific Colorado image for the hero background
                    $post_slug = get_post_field('post_name', get_the_ID());
                    if ($post_slug === 'colorado') {
                        // Use Maroon Bells image for Colorado article
                        $hero_image = home_url('/wp-content/uploads/2025/01/colorado/maroon-bells-2.jpg');
                    } else {
                        $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        if (!$hero_image) {
                            $hero_image = 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?auto=format&fit=crop&w=1600&q=80';
                        }
                    }

                    $raw_content = get_post_field('post_content', get_the_ID());
                    $word_count = str_word_count(wp_strip_all_tags($raw_content));
                    $reading_time = max(1, (int) ceil($word_count / 220));

                    $categories = get_the_terms(get_the_ID(), 'article_category');
                    $category_names = array();
                    if ($categories && !is_wp_error($categories)) {
                        $category_names = wp_list_pluck($categories, 'name');
                    }

                    $hero_excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags($raw_content), 34, '...');
                    ?>

                    <header class="article-hero" style="--hero-image: url('<?php echo esc_url($hero_image); ?>');">
                        <div class="article-hero__background"></div>
                        <div class="article-hero__inner">
                            <div class="article-meta-top">
                                <?php if (!empty($categories)) : ?>
                                    <div class="article-categories">
                                        <?php foreach ($categories as $category) : ?>
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="article-category">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="article-hero__details">
                                    <span class="article-hero__author"><?php printf(esc_html__('נכתב על ידי %s', 'or-travel-child'), esc_html(get_the_author())); ?></span>
                                    <div class="article-date">
                                        <span class="article-date-label"><?php esc_html_e('פורסם בתאריך', 'or-travel-child'); ?></span>
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                    </div>
                                </div>
                            </div>

                            <?php the_title('<h1 class="article-title">', '</h1>'); ?>

                            <?php if (!empty($hero_excerpt)) : ?>
                                <p class="article-excerpt"><?php echo esc_html($hero_excerpt); ?></p>
                            <?php endif; ?>

                            <div class="article-hero__stats">
                                <div class="article-hero__stat">
                                    <span class="article-hero__stat-label"><?php esc_html_e('משך קריאה', 'or-travel-child'); ?></span>
                                    <span class="article-hero__stat-value"><?php echo esc_html(sprintf(_n('%d דקה', '%d דקות', $reading_time, 'or-travel-child'), $reading_time)); ?></span>
                                </div>
                                <div class="article-hero__stat">
                                    <span class="article-hero__stat-label"><?php esc_html_e('אורך הכתבה', 'or-travel-child'); ?></span>
                                    <span class="article-hero__stat-value"><?php echo esc_html(number_format_i18n($word_count)); ?> <?php esc_html_e('מילים', 'or-travel-child'); ?></span>
                                </div>
                                <div class="article-hero__stat">
                                    <span class="article-hero__stat-label"><?php esc_html_e('קטגוריות מובילות', 'or-travel-child'); ?></span>
                                    <span class="article-hero__stat-value"><?php echo esc_html(!empty($category_names) ? implode(' · ', array_slice($category_names, 0, 2)) : __('השראה לטיולים', 'or-travel-child')); ?></span>
                                </div>
                            </div>

                            <a class="article-hero__scroll" href="#article-content"><?php esc_html_e('גללו לחוויה', 'or-travel-child'); ?></a>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <figure class="article-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                            <?php if ($caption = get_the_post_thumbnail_caption()) : ?>
                                <figcaption><?php echo esc_html($caption); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <div id="article-content" class="article-content-shell">
                        <div class="article-layout">
                            <div class="article-main markdown-body">
                                <?php
                                the_content();

                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('עמודים:', 'or-travel-child'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div>
                            <aside class="article-sidebar" aria-label="<?php esc_attr_e('מידע משלים לכתבה', 'or-travel-child'); ?>">
                                <div class="article-sidebar__card article-sidebar__card--info">
                                    <h3><?php esc_html_e('פרטי המסע', 'or-travel-child'); ?></h3>
                                    <ul class="article-sidebar__list">
                                        <li>
                                            <span><?php esc_html_e('כותב/ת:', 'or-travel-child'); ?></span>
                                            <strong><?php echo esc_html(get_the_author()); ?></strong>
                                        </li>
                                        <li>
                                            <span><?php esc_html_e('משך קריאה משוער:', 'or-travel-child'); ?></span>
                                            <strong><?php echo esc_html(sprintf(_n('%d דקה', '%d דקות', $reading_time, 'or-travel-child'), $reading_time)); ?></strong>
                                        </li>
                                        <?php if (!empty($category_names)) : ?>
                                            <li>
                                                <span><?php esc_html_e('סוג הטיול:', 'or-travel-child'); ?></span>
                                                <strong><?php echo esc_html(implode(' • ', $category_names)); ?></strong>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="article-sidebar__card article-sidebar__card--quote">
                                    <p><?php echo esc_html(wp_trim_words($hero_excerpt, 24, '...')); ?></p>
                                    <span class="article-sidebar__quote-label"><?php esc_html_e('רגע אחד שממש אהבנו', 'or-travel-child'); ?></span>
                                </div>

                                <div class="article-sidebar__card article-sidebar__card--cta">
                                    <h3><?php esc_html_e('רוצים מסלול מותאם אישית?', 'or-travel-child'); ?></h3>
                                    <p><?php esc_html_e('נדאג לתכנן עבורכם טיול מדויק לקצב ולחלומות שלכם בארה"ב.', 'or-travel-child'); ?></p>
                                    <a class="article-sidebar__button" href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('בואו נדבר', 'or-travel-child'); ?></a>
                                </div>
                            </aside>
                        </div>
                    </div>

                    <?php
                    $gallery_items = array();
                    $attachments = get_attached_media('image', get_the_ID());
                    $featured_id = get_post_thumbnail_id();

                    if (!empty($attachments)) {
                        foreach ($attachments as $attachment) {
                            if ($attachment->ID === $featured_id) {
                                continue;
                            }

                            $image = wp_get_attachment_image_src($attachment->ID, 'large');
                            if (!$image) {
                                continue;
                            }

                            $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                            if (empty($alt)) {
                                $alt = $attachment->post_title;
                            }

                            $gallery_items[] = array(
                                'src' => $image[0],
                                'alt' => $alt,
                            );

                            if (count($gallery_items) >= 6) {
                                break;
                            }
                        }
                    }

                    if (empty($gallery_items)) {
                        $gallery_items = array(
                            array(
                                'src' => 'https://images.unsplash.com/photo-1526481280695-3c46917d1d87?auto=format&fit=crop&w=1100&q=80',
                                'alt' => __('נופי פסגות בארצות הברית', 'or-travel-child'),
                            ),
                            array(
                                'src' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1100&q=80',
                                'alt' => __('אגם אלפיני קסום', 'or-travel-child'),
                            ),
                            array(
                                'src' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1100&q=80',
                                'alt' => __('חוויות טבע משפחתיות', 'or-travel-child'),
                            ),
                        );
                    }

                    if (!empty($gallery_items)) : ?>
                        <section class="article-gallery" aria-label="<?php esc_attr_e('גלריית השראה מהיעד', 'or-travel-child'); ?>">
                            <div class="article-gallery__inner">
                                <div class="article-gallery__header">
                                    <h2><?php esc_html_e('תמונות מהדרך', 'or-travel-child'); ?></h2>
                                    <p><?php esc_html_e('טועמים מהנופים שמחכים לכם בטיול', 'or-travel-child'); ?></p>
                                </div>
                                <div class="article-gallery__grid">
                                    <?php foreach ($gallery_items as $gallery_item) : ?>
                                        <figure class="article-gallery__item">
                                            <img src="<?php echo esc_url($gallery_item['src']); ?>" alt="<?php echo esc_attr($gallery_item['alt']); ?>" loading="lazy" />
                                            <figcaption><?php echo esc_html($gallery_item['alt']); ?></figcaption>
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <section class="article-cta">
                        <div class="article-cta__inner">
                            <h2><?php esc_html_e('מוכנים לצאת להרפתקה האמריקאית הבאה?', 'or-travel-child'); ?></h2>
                            <p><?php esc_html_e('יחד נתכנן טיול שעושה כבוד לחלומות שלכם – מהשלב הראשון ועד רגע הנחיתה בבית.', 'or-travel-child'); ?></p>
                            <a class="article-cta__button" href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('לתיאום שיחת ייעוץ', 'or-travel-child'); ?></a>
                        </div>
                    </section>

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
