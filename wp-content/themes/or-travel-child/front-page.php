<?php
/**
 * Front page template for Or Travel Child theme
 */

get_header();
?>

<main class="or-front-page">
    <section class="or-hero" style="background-image: url('<?php echo esc_url( 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=1600&q=80' ); ?>');">
        <div class="or-hero__overlay"></div>
        <div class="or-hero__content">
            <span class="or-label">טיולים בהתאמה אישית</span>
            <h1>מתכננים עבורך את החופשה האמריקאית המושלמת</h1>
            <p>חלמתם על מסע משפחתי בפלורידה, טיול טבע עוצר נשימה או ירח דבש רומנטי בחוף המערבי? אנחנו כאן כדי להפוך את זה למציאות.
            </p>
            <div class="or-hero__cta">
                <a class="or-button or-button--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">לתיאום שיחת ייעוץ</a>
                <a class="or-button or-button--ghost" href="<?php echo esc_url( home_url( '/us-articles' ) ); ?>">גלו השראה לטיול שלכם</a>
            </div>
        </div>
        <div class="or-hero__stats">
            <div class="or-stat">
                <span class="or-stat__number">+180</span>
                <span class="or-stat__label">מסלולי טיול מותאמים</span>
            </div>
            <div class="or-stat">
                <span class="or-stat__number">12</span>
                <span class="or-stat__label">שנות ניסיון בשטח</span>
            </div>
            <div class="or-stat">
                <span class="or-stat__number">97%</span>
                <span class="or-stat__label">לקוחות חוזרים וממליצים</span>
            </div>
        </div>
    </section>

    <section class="or-intro">
        <div class="or-intro__content">
            <h2>החוויה האמריקאית שמדויקת לכם</h2>
            <p>אור טראוול מתמחה בבניית מסלולים וחוויות בוטיק ברחבי ארצות הברית. אנו משלבים היכרות עמוקה עם היעדים יחד עם התאמה אישית לצרכים שלכם – החל ממשפחות עם ילדים, דרך זוגות ועד להרפתקנים שמחפשים טיול שונה.</p>
            <div class="or-intro__features">
                <article class="or-feature">
                    <span class="or-feature__icon">🧭</span>
                    <h3>מסלול אישי ומדויק</h3>
                    <p>תכנון מא' ועד ת' – טיסות, לינה, אטרקציות וקצב טיול שנבנה במיוחד לפי מי שאתם.</p>
                </article>
                <article class="or-feature">
                    <span class="or-feature__icon">💎</span>
                    <h3>נגיעה של פרימיום</h3>
                    <p>גישה להמלצות הכי שוות, חוויות בוטיק ואפשרות לשדרוגים שמעניקים לטיול טוויסט ייחודי.</p>
                </article>
                <article class="or-feature">
                    <span class="or-feature__icon">🤝</span>
                    <h3>ליווי צמוד 24/7</h3>
                    <p>אנחנו זמינים עבורכם לפני, במהלך ואחרי הטיול כדי להבטיח שתרגישו בטוחים לאורך כל הדרך.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="or-showcase">
        <div class="or-section-header">
            <h2>מסלולי הדגל שלנו</h2>
            <p>השראה למסע הבא שלכם בארצות הברית</p>
        </div>
        <div class="or-showcase__grid">
            <article class="or-showcase__card" style="background-image: url('https://images.unsplash.com/photo-1474511320723-9a56873867b5?auto=format&fit=crop&w=1200&q=80');">
                <div class="or-showcase__overlay"></div>
                <div class="or-showcase__content">
                    <span class="or-label">משפחות</span>
                    <h3>משפחתי חלומי בפלורידה</h3>
                    <p>שילוב של פארקי שעשועים, חופי זהב ומפגש עם הטבע הפראי של האברגליידס.</p>
                </div>
            </article>
            <article class="or-showcase__card" style="background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1200&q=80');">
                <div class="or-showcase__overlay"></div>
                <div class="or-showcase__content">
                    <span class="or-label">זוגות</span>
                    <h3>חוף מערבי רומנטי</h3>
                    <p>כביש החוף הקסום של קליפורניה, יקבים, וסן פרנסיסקו הקסומה.</p>
                </div>
            </article>
            <article class="or-showcase__card" style="background-image: url('https://images.unsplash.com/photo-1520962918287-7448c2878f65?auto=format&fit=crop&w=1200&q=80');">
                <div class="or-showcase__overlay"></div>
                <div class="or-showcase__content">
                    <span class="or-label">הרפתקאות</span>
                    <h3>פארקים לאומיים מטורפים</h3>
                    <p>מסלול מעגלי ביוטה, אריזונה ונבדה עם נופים אדירים וחוויות שטח בלתי נשכחות.</p>
                </div>
            </article>
        </div>
    </section>

    <section class="or-experience">
        <div class="or-experience__content">
            <h2>למה לבחור באור טראוול?</h2>
            <ul class="or-experience__list">
                <li>
                    <strong>שנים של חיים ועבודה בארה"ב</strong>
                    <span>הכרות עם הסודות המקומיים, השכונות השוות והאטרקציות שהמקומיים אוהבים.</span>
                </li>
                <li>
                    <strong>תכנון מותאם תקציב</strong>
                    <span>מתאימים את רמת האירוח, הקצב והאטרקציות לתקציב המדויק שלכם.</span>
                </li>
                <li>
                    <strong>מערך ספקים אמין ומנוסה</strong>
                    <span>עובדים עם מלונות, מדריכים וספקים מהשורה הראשונה כדי להבטיח חוויה מושלמת.</span>
                </li>
            </ul>
        </div>
        <div class="or-experience__image" style="background-image: url('https://images.unsplash.com/photo-1521295121783-8a321d551ad2?auto=format&fit=crop&w=1200&q=80');"></div>
    </section>

    <section class="or-articles">
        <div class="or-section-header">
            <h2>מהבלוג שלנו</h2>
            <p>טיפים, מסלולים ועדכונים טריים מהשטח</p>
        </div>
        <div class="or-articles__grid">
            <?php
            $articles_query = new WP_Query(
                array(
                    'post_type'      => 'us_article',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                )
            );

            if ( $articles_query->have_posts() ) :
                while ( $articles_query->have_posts() ) :
                    $articles_query->the_post();
                    ?>
                    <article class="or-article-card">
                        <a href="<?php the_permalink(); ?>" class="or-article-card__thumb">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            <?php else : ?>
                                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </a>
                        <div class="or-article-card__content">
                            <span class="or-article-card__category">
                                <?php
                                $terms = get_the_terms( get_the_ID(), 'article_category' );
                                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                    echo esc_html( $terms[0]->name );
                                }
                                ?>
                            </span>
                            <h3 class="or-article-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="or-article-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 22, '...' ); ?></p>
                            <a class="or-article-card__link" href="<?php the_permalink(); ?>">להמשך קריאה</a>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p class="or-articles__empty">בקרוב יתעדכנו כתבות חדשות. הישארו איתנו!</p>
                <?php
            endif;
            ?>
        </div>
    </section>

    <section class="or-testimonials">
        <div class="or-section-header">
            <h2>לקוחות מספרים</h2>
            <p>תראו מה מטיילים שחזרו מהחופשה מספרים</p>
        </div>
        <div class="or-testimonials__slider">
            <article class="or-testimonial">
                <p class="or-testimonial__quote">״לא האמנו שטיול עם שלושה ילדים יכול להיות כל כך רגוע. כל פרט – מהמלונות ועד לפעילויות – היה מדויק.״</p>
                <span class="or-testimonial__author">משפחת כהן, טיול פלורידה</span>
            </article>
            <article class="or-testimonial">
                <p class="or-testimonial__quote">״המסלול שבניתם לנו בקליפורניה היה פשוט חלום. עצירות מושלמות, מקומות סודיים והמלצות מדויקות.״</p>
                <span class="or-testimonial__author">טל ואלון, ירח דבש</span>
            </article>
            <article class="or-testimonial">
                <p class="or-testimonial__quote">״קיבלנו ליווי צמוד וזמינות לכל שאלה, גם כשהיינו באמצע המדבר ביוטה. השירות שלכם שווה כל שקל.״</p>
                <span class="or-testimonial__author">מיכל ויואב, טיול פארקים לאומיים</span>
            </article>
        </div>
    </section>

    <section class="or-cta-large">
        <div class="or-cta-large__content">
            <h2>בואו נתחיל לתכנן את המסע הבא שלכם</h2>
            <p>ספרו לנו על החלום שלכם ואנחנו נחזור אליכם עם הצעה מותאמת אישית, לוחות זמנים מסודרים ואפשרויות חווייתיות שמתאימות בדיוק למשפחה שלכם.</p>
            <a class="or-button or-button--light" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">תיאום שיחת היכרות</a>
        </div>
    </section>

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            if ( get_the_content() ) :
                ?>
                <section class="or-page-content">
                    <?php the_content(); ?>
                </section>
                <?php
            endif;
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
