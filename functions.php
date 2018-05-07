<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */

load_template( locate_template('widgets.php'), $require_once );

add_theme_support('title-tag'); // теперь тайтл управляется самим вп

/* Поддержка миниатюр */
add_theme_support('post-thumbnails');

/* Мобильная версия fix */
  add_image_size( 'responsive_150', 150, 85, true);
  add_image_size( 'responsive_200', 200, 130, true);
  add_image_size( 'responsive_800', 800, 457, true);
  add_image_size( 'responsive_1000', 1000, 571, true);
  add_image_size( 'responsive_1600', 1600, 914, true);
  //add_image_size( 'responsive_2000', 2000, 1142, true);
  //add_image_size( 'responsive_2400', 2400, 1372, true );


register_nav_menus ( array(
	'header_menu' => 'Меню в шапке',
	'footer_menu' => 'Меню в подвале'
) );


add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_scripts() { // добавление скриптов
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_deregister_script('jquery'); // выключаем стандартный jquery
	    wp_enqueue_script('jquery','//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js','','',true); // добавляем свой
	    wp_enqueue_script('owl-script', get_template_directory_uri().'/js/owl.carousel.js','','',true); //
	    wp_enqueue_script('menuzord', get_template_directory_uri().'/js/menuzord.js','','',true); //
	    wp_enqueue_script('main', get_template_directory_uri().'/js/scripts.js','','',true); // и скрипты шаблона
	    wp_enqueue_script('sizes', get_template_directory_uri().'/js/lazysizes_2.0.7.min.js','','',true); // и скрипты шаблона
	}
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_styles() { // добавление стилей
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_enqueue_style( 'font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
			$font_args = array(
				'family' => 'Roboto:700,500italic,500,400,400italic,300,300italic|Roboto+Condensed:400,300,300italic,400italic,700,700italic',
				'subset' => 'latin,cyrillic'
			);
			wp_enqueue_style( 'google_fonts', add_query_arg( $font_args, "//fonts.googleapis.com/css" ), array(), null );
				wp_enqueue_style( 'main', get_template_directory_uri().'/style.css' ); // основные стили шаблона
	}
}

/* Виджеты */

register_sidebar (array(
				'name' => 'Главная страница',
				'id' => 'main',
				'before_widget' => '<div class="posts absolute-name %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class=""><span>',
				'after_title'   => '</span></div>'));

register_sidebar (array(
				'name' => 'Сайдбар',
				'id' => 'sidebar',
				'before_widget' => '<div class="sidebar-widget absolute-name %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="sidebar-name"><span>',
				'after_title'   => '</span></div>'));

register_sidebar (array(
				'name' => 'Футер',
				'id' => 'footer',
				'before_widget' => '<div class="footer-info %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="title">',
				'after_title'   => '</div>'));

register_sidebar (array(
				'name' => 'Копирайты',
				'id' => 'copywrite',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''));

register_sidebar (array(
				'name' => 'Модули на главной',
				'id' => 'modules',
				'before_widget' => '<div id="%1$s" class="module most-comments">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="most-comments-title">',
				'after_title'   => '</div>'));

register_sidebar (array(
				'name' => 'Баннер в шапке',
				'id' => 'header_banner',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''));

register_sidebar (array(
				'name' => 'Контакты в шапке',
				'id' => 'header_contact',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''));

register_sidebar (array(
				'name' => 'Социальные иконки в шапке',
				'id' => 'header_social',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''));

register_sidebar (array(
				'name' => 'Поделиться в соцсетях',
				'id' => 'social_share',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<span class="soc-header">',
				'after_title'   => '</span>'));

/* Краткая запись */
function new_excerpt_length($length) {
	return 17;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* Выполнение PHP в виджетах */
function widget_php ($widget_content) {
	if (strpos($widget_content, '<' . '?') !== false) {
		ob_start();
		eval('?' . '>' . $widget_content);
		$widget_content = ob_get_contents();
		ob_end_clean();	}
	return $widget_content;
}
add_filter('widget_text', 'widget_php', 99);

/* Проверяет принадлежность поста к вложенным категориям */
function post_is_in_descendant_category( $cats, $_post = null ) {
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

?>
