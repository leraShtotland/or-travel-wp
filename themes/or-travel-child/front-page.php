<?php
/**
 * Front page template for Or Travel Child theme
 */

get_header();

$experience_image_data_uri = '';
$experience_image_data_path = get_stylesheet_directory() . '/assets/images/experience-lake.base64';

if ( file_exists( $experience_image_data_path ) ) {
    $encoded_image = trim( file_get_contents( $experience_image_data_path ) );

    if ( ! empty( $encoded_image ) ) {
        $experience_image_data_uri = 'data:image/jpeg;base64,' . $encoded_image;
    }
}

$experience_image_style = '';

if ( $experience_image_data_uri ) {
    $experience_image_style = sprintf(
        ' style="background-image: url(\'%s\');"',
        esc_attr( $experience_image_data_uri )
    );
}
?>

<main class="or-front-page">
    <section class="or-hero" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/hero-bg.jpg' ); ?>');">
        <div class="or-hero__overlay"></div>
        <div class="or-hero__content">
            <span class="or-label">אור טראוול • מסעות בהתאמה אישית</span>
            <h1>ביחד נגשים את החלום לטיול המושלם שלכם</h1>
            <p>אחרי שנים של טיולים, כתיבה והובלת מסעות ברחבי העולם, אני כאן כדי להפוך את הרצונות שלכם למסלול חכם, רגוע ומרגש – כזה שנשאר בזיכרון לכל החיים.</p>
            <div class="or-hero__cta">
                <a class="or-button or-button--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">לתיאום שיחת היכרות</a>
                <a class="or-button or-button--ghost" href="#packages">לגלות את החבילות</a>
            </div>
        </div>
        <div class="or-hero__stats">
            <div class="or-stat">
                <span class="or-stat__number">15+</span>
                <span class="or-stat__label">שנות טיולים וניסיון שטח</span>
            </div>
            <div class="or-stat">
                <span class="or-stat__number">300+</span>
                <span class="or-stat__label">מסעות שתכננתי והובלתי</span>
            </div>
            <div class="or-stat">
                <span class="or-stat__number">24/7</span>
                <span class="or-stat__label">ליווי אישי וזמינות מלאה</span>
            </div>
        </div>
    </section>

    <section class="or-story">
        <div class="or-story__grid">
            <div class="or-story__intro">
                <span class="or-label or-label--dark">נעים מאוד</span>
                <h2>שלום לכם ואיזה כיף שבאתם!</h2>
                <p>אני אוריק, בן 35, אבא ליובלי ולנגה, בן זוג ללרה, כותב על טיולים ב"הארץ", היסטוריון חובב וסא"ל במילואים. מעבר לכל הטייטלים אני קודם כול איש של אנשים ושל מסעות.</p>
                <div class="or-story__quote">
                    <p>אם אין לכם כוח לקרוא את הכל אז תתמקדו רק בזה: השתחררתי מהצבא כדי להגשים את החלום שלי – להגשים את החלומות שלכם.</p>
                </div>
            </div>
            <div class="or-story__details">
                <p>מאז שאני זוכר את עצמי אני בדרך. הדרך הזו הובילה אותי בין יבשות, תרבויות ואנשים מרתקים. היא נשמרת בחיוכים של מטיילים שחזרו נרגשים, בשירים ששרתי לעצמי כמו "אמריקה" של סיימון וגרפונקל ובאינספור זיכרונות שמזינים את היצירתיות שלי.</p>
                <p>בין אם מדובר במטרקים לבד, בטיול יוקרתי לזוגות, בחופשה משפחתית מתוקתקת או בטיול דל תקציב – צברתי ידע וניסיון שמאפשרים לי להפוך את כל הפאזל הזה לתוכנית ברורה ומותאמת אישית.</p>
                <p>הטיול הוא נקודת המפגש שבין אדם ליעד. התפקיד שלי הוא לדייק את המפגש הזה, להוריד מכם את הלחץ של התכנון, לחסוך לכם כסף ולהוסיף ערך עם המלצות שלא תמצאו בגוגל. אני עושה זאת ברגישות, בהגינות, בתשוקה ובעיקר ביחס אישי שמתחיל מהרגע הראשון ונמשך עד אחרי שאתם חוזרים.</p>
                <div class="or-story__highlights">
                    <div class="or-story__highlight">שנתיים של חיים ועבודה בארה"ב שהפכו כל פינה באמריקה לבית שני.</div>
                    <div class="or-story__highlight">מאות רבות של טיולים שתכננתי – בארץ ובעולם – לזוגות, משפחות והרפתקנים.</div>
                    <div class="or-story__highlight">מעמיק בהיסטוריה, תרבות ואנשים כדי להעניק לכל מסלול עומק ומשמעות.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="or-intro">
        <div class="or-intro__content">
            <h2>בואו נבנה את המסע שחלמתם עליו</h2>
            <p>תכנון נכון הופך חופשה למשהו קליל ומרגש. יחד נבין את מי שאתם, מה חשוב לכם, ונרכיב מסלול מדויק – מהטיסות והמלונות ועד לפינות הסודיות שנשמרות רק למקומיים.</p>
            <div class="or-intro__features">
                <article class="or-feature">
                    <span class="or-feature__icon">🧭</span>
                    <h3>תכנון מקצה לקצה</h3>
                    <p>מסלול יומי מפורט, קצב מותאם אישית, המלצות לאוכל, לטבע ולתרבות – הכל מסודר מראש.</p>
                </article>
                <article class="or-feature">
                    <span class="or-feature__icon">🤲</span>
                    <h3>יחס אישי באמת</h3>
                    <p>אני זמין עבורכם לכל שאלה ולכל דילמה, מהפגישה הראשונה ועד שאתם נוחתים בחזרה.</p>
                </article>
                <article class="or-feature">
                    <span class="or-feature__icon">💡</span>
                    <h3>תובנות מהשטח</h3>
                    <p>היכרות עמוקה עם היעדים, היסטוריה וסיפורים שמחיים את הטיול והופכים אותו למשמעותי.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="or-destinations" id="destinations">
        <div class="or-section-header">
            <h2>יעדים מומלצים</h2>
            <p>גלו את היעדים המדהימים שאני מכיר לעומק ויכול להציע לכם חוויה בלתי נשכחת</p>
        </div>
        <div class="or-destinations__grid">
            <article class="or-destination-card" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/europe.jpg' ); ?>');">
                <div class="or-destination-card__overlay"></div>
                <div class="or-destination-card__content">
                    <h3>אירופה</h3>
                    <p>תרבות, אמנות והיסטוריה בכל פינה</p>
                </div>
            </article>
            <article class="or-destination-card" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/asia.jpg' ); ?>');">
                <div class="or-destination-card__overlay"></div>
                <div class="or-destination-card__content">
                    <h3>אסיה</h3>
                    <p>אקזוטיקה, רוחניות וחוויות ייחודיות</p>
                </div>
            </article>
            <article class="or-destination-card" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/africa.jpg' ); ?>');">
                <div class="or-destination-card__overlay"></div>
                <div class="or-destination-card__content">
                    <h3>אפריקה</h3>
                    <p>טבע פראי והרפתקאות בלתי נשכחות</p>
                </div>
            </article>
            <article class="or-destination-card" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/america.jpg' ); ?>');">
                <div class="or-destination-card__overlay"></div>
                <div class="or-destination-card__content">
                    <h3>אמריקה</h3>
                    <p>מגוון עצום של נופים וחוויות</p>
                </div>
            </article>
            <article class="or-destination-card" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/homepage/israel.jpg' ); ?>');">
                <div class="or-destination-card__overlay"></div>
                <div class="or-destination-card__content">
                    <h3>ישראל</h3>
                    <p>היסטוריה, טבע ותרבות במרחק נגיעה</p>
                </div>
            </article>
        </div>
    </section>

    <section class="or-experience">
        <div class="or-experience__content">
            <h2>למה לבחור באור טראוול?</h2>
            <ul class="or-experience__list">
                <li>
                    <strong>היכרות אמיתית עם היעד</strong>
                    <span>שנתיים של חיים בארה"ב, קשרים מקומיים וסיפורים קטנים שמכניסים אתכם מתחת לפני השטח.</span>
                </li>
                <li>
                    <strong>תכנון חכם וחסכוני</strong>
                    <span>התאמת רמת האירוח, קצב הטיול והאטרקציות לתקציב שלכם – בלי לוותר על החוויה.</span>
                </li>
                <li>
                    <strong>מענה אישי לכל אורך הדרך</strong>
                    <span>ליווי זמין וגמיש, קשר עם ספקים אמינים ותמיכה צמודה לפני, במהלך ואחרי המסע.</span>
                </li>
            </ul>
        </div>
        <div class="or-experience__image"<?php echo $experience_image_style; ?>></div>
    </section>

    <section class="or-process">
        <div class="or-section-header">
            <h2>איך זה עובד?</h2>
            <p>תהליך עבודה שקוף, אישי וזורם – כדי שתוכלו לצאת לדרך בראש שקט</p>
        </div>
        <div class="or-process__steps">
            <article class="or-process__step">
                <div class="or-process__number">1</div>
                <h3>שיחת היכרות</h3>
                <p>נבין מי אתם, מה חשוב לכם, מה התקציב ומה הופך את הטיול הבא שלכם למושלם.</p>
            </article>
            <article class="or-process__step">
                <div class="or-process__number">2</div>
                <h3>בניית מסלול חלומי</h3>
                <p>אני מרכיב עבורכם מסלול מפורט עם זמני נסיעה, המלצות, טיפים והצעות לשדרוג.</p>
            </article>
            <article class="or-process__step">
                <div class="or-process__number">3</div>
                <h3>ליווי עד הנחיתה</h3>
                <p>מקבלים חוברת דיגיטלית, תמיכה בוואטסאפ וזמינות מלאה עד שתחזרו עם חיוך ענק.</p>
            </article>
        </div>
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
            <p>ספרו לי על החלום שלכם ואחזור אליכם עם הצעה מותאמת אישית, לוחות זמנים מסודרים ואפשרויות חווייתיות שמתאימות בדיוק למשפחה שלכם.</p>
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
