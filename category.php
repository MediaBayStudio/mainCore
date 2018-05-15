<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
 get_header(); ?>

 <div class="main-wrapper">
   <main class="page-main">
     <section class="header__wrapper">
       <?php $thisCat = get_category(get_query_var('cat'),false); ?>
       <h1 class="description__text"><?php echo $thisCat->name;?></h1>
     </section>
      <ul class="category--grid category--grid_in-category">
       <?php
          $catpost = get_posts(
                        array (
                         'cat' => $thisCat->cat_ID,
                         'posts_per_page' => 4,
                         'order' => 'DESC',
                         'orderby' => 'date'
                       ));
         $i = 0;
         foreach( $catpost as $post ) : setup_postdata($post); ?>
         <li class="category-post">
           <a href="<?php the_permalink(); ?>">
             <picture>
               <?php
                 if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' )))) {
               ?>
                  <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/no-image.svg" alt="Избражение не найдено" width="400" height="240">
               <?php }  else { ?>
                   <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_600.svg"
                   data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_800' ); ?> 1x,
                   <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_1600' ); ?> 2x" alt="<?php the_title(); ?>"
                   alt="<?php the_title(); ?>" class="responsive-image lazyload" width="400" height="240" />
               <?php  }?>
             </picture>
             <div class="mask"></div>
             <div class="content">
               <h2 class="content-title"><?php the_title(); ?></h2>
               <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' && get_post_meta($post->ID, 'extratitle', true) != NULL ) { ?>
                 <p><?php echo get_post_meta($post->ID, 'extratitle', true); ?></p>
                 <?php }; ?>
              </div>
            </a>
          </li>
          <?php
            $excl[$i]= $post->ID;
            $i = $i + 1;
          endforeach;
          wp_reset_query();  ?>
      </ul>
      <section class="cat-last-post-wrapper">
        <ul class="line-post__container ">
          <?php
          /* Указываем параметры для фильтрации */
          $custom_query_args = array (
                             'cat' => $thisCat->cat_ID,
                             'post__not_in' => array($excl[0], $excl[1], $excl[2], $excl[3]),
                             'posts_per_page' => '10', // количество записей на странице
                             'orderby' => 'date' ); // сортировка
         /* Получаем текущую страницу нумерации и добавляем ее к массиву пользовательских параметров */
         $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
         /* Создаем пользовательские запросы */
         $custom_query = new WP_Query( $custom_query_args );

         /* Fix: cохраняем текущее значение wp_query, обнуляем его и задаем пользовательские параметры */
         $temp_query = $wp_query;
         $wp_query = NULL;
         $wp_query = $custom_query;

         /* Запускаем пользовательский цикл */
         if ( $custom_query->have_posts() ) :
          while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
            <li class="line-post__category">
             <div class="img-box">
               <a href="<?php the_permalink() ?>">
                 <picture>
                   <?php
                     if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' )))) {
                   ?>
                      <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/no-image.svg" alt="Избражение не найдено" width="200" height="130">
                   <?php }  else { ?>
                       <img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
                       data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_300' ); ?> 1x,
                       <?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_600' ); ?> 2x" alt="<?php the_title(); ?>"
                       alt="<?php the_title(); ?>" class="responsive-image lazyload" width="200" height="130" />
                   <?php  }?>
                 </picture>
               </a>
             </div>
             <div class="line-post--content">
               <div class="line-post--title">
                 <a href="<?php the_permalink() ?>"><?php the_title('', '', true); ?></a>
               </div>
               <div class="excerpt"><?php the_excerpt(); ?></div>
             </div>
           </li>
            <?php
          endwhile;
         endif;
        /* Конец цикла */

         /* Возвращаем значение текущего поста переменной post */
         wp_reset_postdata(); ?>
         <li>
             <?php
             /* Выводим пагинацию */
             $index_nav = get_the_posts_pagination (
                 array (
                     'show_all'     => false, // показаны все страницы участвующие в пагинации
                     'end_size'     => 1,     // количество страниц на концах
                     'mid_size'     => 1,     // количество страниц вокруг текущей
                     'prev_next'    => true,  // выводить ли боковые ссылки "предыдущая/следующая страница".
                     'prev_text'    => __('<i class="fa fa-long-arrow-left"></i>'),
                     'next_text'    => __('<i class="fa fa-long-arrow-right"></i>'),
                     'add_args'     => false,
                     'add_fragment' => '',     // Текст который добавиться ко всем ссылкам.
                     'screen_reader_text' => __( '' ) ));

             $index_nav = preg_replace('~<h2.*?h2>~', '', $index_nav);
             echo $index_nav;

             /* Сброс wp_query и возвращение первоначального значения */
             $wp_query = NULL;
             $wp_query = $temp_query;
             ?>
         </li>
       </ul>
      </section>

     <?php if ($thisCat->description != NULL ):?>
     <section class="full-desc">
         <?php echo $thisCat->description; ?>
     </section>
     <?php endif; ?>
   </main>
   <?php get_sidebar(); ?>
 </div>
 <?php get_footer(); ?>
