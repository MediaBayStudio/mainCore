<?php
/**
 * Главная страница (index.php)
 * @package MediaTheme
 */
get_header(); ?>

<div class="main-wrapper">
  <main class="page-main">
    <section class="slider-section">
      <div class="slider slider__carousel owl-carousel owl-theme" id="main-slider" width="840" height="480">
        <?php
        $post_var = get_posts( array(
                        'post_type' => 'slider',
                        'orderby'   => 'ID',
                        'order' => 'DESC') );
          foreach( $post_var as $post ) { setup_postdata($post);
        ?>
        <div class="slide">
          <picture class="slide--image">
            <img src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_800' ); ?>"
                 srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'responsive_1600' ); ?>"
                 alt="<?php the_title(); ?>" width="840" height="480">
          </picture>
          <div class="slide--content slide--content__<?php echo get_post_custom_values('slide_desc_align')[0]; ?>">
            <section class="slide--wrapper">
              <h2 class="slide--title"><?php the_title(); ?></h2>
              <div class="slide--description">
                <?php the_excerpt(); ?>
              </div>
              <a class="slide--button" href="<?php echo get_post_custom_values('slider_href')[0]; ?>">Читать далее</a>
            </section>
          </div>
        </div>
        <?php
          }
          wp_reset_postdata(); ?>
      </div>
    </section>
    <div class="page-main--content">
      <section class="page-main--categories">
        <?php dynamic_sidebar('main'); ?>
      </section>
      <sectioin class="page-main--modules">
        <?php dynamic_sidebar('modules'); ?>
      </section>
    </div>
  </main>
  <?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>
