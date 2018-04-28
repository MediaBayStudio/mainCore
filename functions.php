<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */

add_theme_support('title-tag'); // теперь тайтл управляется самим вп

add_image_size( 'responsive_800', 840, 480, true);
add_image_size( 'responsive_1600',1680, 960, true);

/* Поддержка миниатюр */
add_theme_support('post-thumbnails');

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
	    wp_enqueue_script('main', get_template_directory_uri().'/js/owl.carousel.js','','',true); //
	    wp_enqueue_script('owl-script', get_template_directory_uri().'/js/main.min.js','','',true); // и скрипты шаблона
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
				wp_enqueue_style( 'owl', get_template_directory_uri().'/style.min.css' ); // основные стили шаблона
	}
}

?>
