<?php get_header(); ?>

<div class="content-wrapper">
    <div class="content-main">

        <main class="content" role="main">

            <div class="share-block floating">
                <?php if(!dynamic_sidebar('social_share')): ?>
                    <p>Настроить можно в Панеле Администратора - Внешний вид - Виджеты - Поделиться в соцсетях</p>
                <?php endif; ?>
            </div>

            <div class="article-wrapper">
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
            <article class="post-article">
                <div class="pic_post">
                    <?php if (has_post_thumbnail()): ?>
                            <picture>
                                <img data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'post_img' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'post_img_2x' ); ?> 2x" alt="<?php the_title(); ?>" class="responsive-image lazyload">
                            </picture>
                           <?php else: ?>
                            <img data-src="<?php bloginfo('template_url'); ?>/images/no-image-post.png" alt="" width="680" height="390" class="responsive-image lazyload" />
                    <?php endif; ?>
                </div>
                <div class="article_title">
                    <div class="article_title_wrapper">
                        <div class="article_title_h1">
                                <?php
                                    if ( in_category(17) || post_is_in_descendant_category(17) ) {
                                        echo '<p class="post_meta"><span class="calendar_date">';
                                        printf('%1$s', get_the_date());
                                        echo '</span></p>';
                                    }
                                ?>
                                <div class="page_heading">
                                    <h1><?php the_title(); ?>
                                        <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' && get_post_meta($post->ID, 'extratitle', true) != NULL ) { ?>
                                            <span class="title_extra">
                                                <span class="title_extra_line"></span>
                                            </span>
                                            <span class="title_extra_text"><?php echo get_post_meta($post->ID, 'extratitle', true); ?></span>
                                            <span class="title_extra">
                                                <span class="title_extra_line"></span>
                                            </span>
                                        <?php }; ?>
                                    </h1>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="main-text">
                <?php the_content(); ?>
                </div>

                <div class="article-ad">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Babyke: Адаптивная реклама после контента -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-5387718498332562"
                         data-ad-slot="4821731131"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <?php endwhile; endif; ?>
            </article>

            <div class="related-posts">

                <div class="block-name-wrapper">
                    <div class="block-name">
                        <span>Вам будет интересно</span>

                    </div>
                </div>

                <?php
                $postID = get_the_ID();
                $category = get_the_category();
                $cat_list = $category[0]->cat_ID;

                $mypost = get_posts(
                    array (
                        'category' => $cat_list,
                        'posts_per_page' => 3,
                        'orderby' => 'rand',
                        'exclude' => $postID ));
                    foreach( $mypost as $post ) : setup_postdata($post); ?>

                    <div class="related-item">
                        <div class="media-wrapper">
                             <a href="<?php the_permalink(); ?>">
                                 <picture>
                                    <img data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'post_teaser' ); ?> 1x, <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'post_teaser_2x' ); ?> 2x" alt="<?php the_title(); ?>" class="responsive-image lazyload">
                                </picture>
                             </a>
                        </div>
                        <div class="detail-wrapper">
                            <p class="related-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                            <p class="related-text"><?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' ) echo get_post_meta($post->ID, 'extratitle', true); ?></p>
                        </div>
                    </div>

                <?php endforeach; wp_reset_query(); ?>

            </div>

            <?php comments_template(); ?>

            </div>
        </main>

        <?php get_sidebar(); ?>

    </div>
</div>

<?php get_footer(); ?>

</body>
</html>
