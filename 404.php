<?php
/**
 * Страница 404 ошибки (404.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
 get_header(); ?>

 <div class="main-wrapper">
   <main class="page-main">
     <section class="slider-section">
        <img data-src="<?php bloginfo('template_url'); ?>/images/404.jpg" alt='Ошибка 404' class="lazyload" width="840" height="480"/>
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
