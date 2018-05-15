<?php get_header(); ?>

    <div class="main-wrapper">
      <aside class="left-sidebar">
          <?php if(!dynamic_sidebar('social_share')): ?>
              <p>Настроить можно в Панеле Администратора - Внешний вид - Виджеты - Поделиться в соцсетях</p>
          <?php endif; ?>
      </aside>
      <main class="content" role="main">
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
      </main>
        <?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>
