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
                     <img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="680" height="390">
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
          <section class="related">
            <div class="related-title">
              <h1>Вам будет интересно</h1>
            </div>
            <div class="related-posts">
            <?php
              $category = get_the_category();
              $catID = $category[0]->cat_ID;  // категория, к которой относится запись
              // ID родительской категории
              $ancestorID = get_ancestors( $catID, 'category' );
              // Количество постов во вложенной категории
              $post_count = get_category( $catID )->category_count;
              // Если в дочерней категории 3 или больше постов
              if ($post_count >= 3) {
                $menupost = get_posts(
                    array (
                        'cat' => $catID,
                        'posts_per_page' => 3,
                        'order' => 'DESC',
                        'orderby' => 'date'
                        ));
              }

              // Если меньше 3 - выводим недостающие из родительской категории
              else {
                // Получаем все посты вложенной категории
                $child_post = get_posts(
                    array (
                        'cat' => $catID,
                        'posts_per_page' => $post_count,
                        'order' => 'DESC',
                        'orderby' => 'date'
                        ));
                $i = 0;
                foreach( $child_post as $post ) :
                  setup_postdata($post);
                  $child_posts_ID[$i] = $post->ID;
                  $i++;
                endforeach;

                // Получаем количество недостающих постов
                $parent_post_count = 3 - $i;
                // Берем рандомно недостающие посты из родительской категории
                $parent_post = get_posts(
                    array (
                        'cat' => $ancestorID[0],
                        'posts_per_page' => $parent_post_count,
                        'order' => 'DESC',
                        'orderby' => 'rand'
                        ));
                foreach( $parent_post as $post ) :
                  setup_postdata($post);
                  $child_posts_ID[$i] = $post->ID;
                  $i++;
                endforeach;

                // Передаем на вывод массив с ID полученных постов
                $menupost = get_posts(
                    array (
                        'post__in' => $child_posts_ID,
                        'orderby' => 'post__in',
                        ));
              }
              foreach( $menupost as $post ) : setup_postdata($post); ?>
              <div class="related-item">
                <div class="media-wrapper">
                  <a href="<?php the_permalink(); ?>">
                    <picture>
                      <?php
                        if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' )))) {
                      ?>
                         <img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="200" height="120">
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
        <?php comments_template(); ?>

          <a id="toTop" class="footer-up"><i class="fa fa-chevron-up" aria-hidden="true"></i> Наверх</a>
      </main>
        <?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>
