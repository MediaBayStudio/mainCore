<?php get_header(); ?>

    <div class="main-wrapper">
      <aside class="left-sidebar">
          <?php if(!dynamic_sidebar('social_share')): ?>
              <p>Настроить можно в Панеле Администратора - Внешний вид - Виджеты - Поделиться в соцсетях</p>
          <?php endif; ?>
      </aside>
      <main class="content page-main" role="main">
          <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
          <article class="articles-wrapper">
              <div class="image-wrapper">
                <picture>
                  <?php
                    if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' )))) {
                  ?>
                     <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/no-image.svg" alt="Избражение не найдено" width="680" height="390">
                  <?php }  else { ?>
                      <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_600.svg"
                      data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' ); ?> 1x,
                      <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_1600' ); ?> 2x" alt="<?php the_title(); ?>"
                      alt="<?php the_title(); ?>" class="responsive-image lazyload" width="680" height="390" />
                  <?php  }?>
                </picture>
                <div class="title-wrapper">
                  <?php
                      if ( in_category(17) || post_is_in_descendant_category(17) ) {
                          echo '<p class="post_meta"><span class="calendar_date">';
                          printf('%1$s', get_the_date());
                          echo '</span></p>';
                      }
                  ?>
                  <h1 class="article-title"><?php the_title(); ?></h1>
                  <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' && get_post_meta($post->ID, 'extratitle', true) != NULL ) { ?>
                    <h2 class="article-extra"><?php echo get_post_meta($post->ID, 'extratitle', true); ?></h2>
                  <?php }; ?>
                </div>
              </div>

              <section class="article-content">
                <?php the_content(); ?>
              </section>
            <?php endwhile; endif; ?>
          </article>
          <?php
            $category = get_the_category();
            $cat_list = $category[0]->cat_ID;  // категория, к которой относится запись
            while (get_category($cat_list)->parent != 0) { // повторять, пока не дойдем до корневой категории
              if ( get_category($cat_list)->category_count < 3 ) // если в ней меньше 3 записей
                $cat_list = get_category($cat_list)->parent; // получаем родительскую категорию
              else {
                break;
              }
            }
            if ( get_category($cat_list)->category_count < 3 ) {
              print_r(wp_list_categories());
            }
            if ( get_category($cat_list)->category_count > 3 ) {
          ?>
          <section class="related">
            <div class="related-title">
              <h1>Вам будет интересно</h1>
            </div>
            <div class="related-posts">
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
                      <?php
                        if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' )))) {
                      ?>
                         <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/no-image.svg" alt="Избражение не найдено" width="200" height="120">
                      <?php }  else { ?>
                          <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
                          data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' ); ?> 1x,
                          <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_600' ); ?> 2x" alt="<?php the_title(); ?>"
                          alt="<?php the_title(); ?>" class="responsive-image lazyload" width="200" height="120" />
                      <?php  }?>
                    </picture>
                  </a>
                </div>
                <div class="related-content">
                  <div class="related-header ">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </div>
                  <p class="related-text">
                    <?php
                      if ( get_post_meta($post->ID, 'checkextratitle', true) == '' )
                        echo get_post_meta($post->ID, 'extratitle', true);
                    ?>
                  </p>
                </div>
              </div>
            <?php endforeach; wp_reset_query(); ?>
          </section>
        <?php }; comments_template(); ?>

          <a id="toTop" class="footer-up"><i class="fa fa-chevron-up" aria-hidden="true"></i> Наверх</a>
      </main>
        <?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>
