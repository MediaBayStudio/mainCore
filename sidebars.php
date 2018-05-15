<?php

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
?>
