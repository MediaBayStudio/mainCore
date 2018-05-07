<?php
/**
 * Header темы
 * @package MediaTheme
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); // вывод атрибутов языка ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="application-name" content="<?php bloginfo( 'name' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- meta name="msapplication-config" content="/browserconfig.xml" / -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<title> <?php is_home() ? bloginfo('description') : wp_title(''); ?> </title>
	<?php wp_head(); // необходимо для работы плагинов и функционала ?>
</head>

<body <?php body_class(); // все классы для body ?>>
	<header class="page-header">
		<div class="page-header__info">
			<div class="wp-widget wp-widget--header-icons">
				<?php if( !dynamic_sidebar('header_social') ): ?>
					<!--  <p>Установить иконки можно в Панеле Администратора - Внешний вид - Виджеты - Иконки в шапке</p> -->
				<?php endif; ?>
			</div>
			<div class="wp-widget wp-widget--header-contacts">
				<?php if( !dynamic_sidebar('header_contact')): ?>
					<!--  <p>Установить контакты можно в Панеле Администратора - Внешний вид - Виджеты - Контакты в шапке</p> -->
				<?php endif; ?>
			</div>
		</div>
		<div class="page-header__logo-wrapper">
			<div class="page-header__logo">
				<a href="/" id="home">
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg"
							 alt="<?php bloginfo( 'name' ); ?>"
							 class="lazyload" width="190" height="70">
				</a>
			</div>
			<?php if(!dynamic_sidebar('header_banner')): ?>
				<!--  <p>Установить баннер можно в Панеле Администратора - Внешний вид - Виджеты - Баннер в шапке</p> -->
			<?php endif; ?>
		</div>
		<nav class="main-nav">
			<div class="main-nav__wrapper">
				<?php
					if ( function_exists( 'menuzord' ) ): menuzord(formMenu());
					else :
						wp_nav_menu(
						array (
							'theme_location'  => 'header_menu',
							'menu'            => 'Основная навигация',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'main-menu main-menu--no-menuzoid',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul class="%2$s"><span class="fa-stack fa-lg"><a href="/"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-home fa-stack-1x fa-inverse"></i></a></span>%3$s</ul>',
										'depth'           => 0  ));
					endif;
				?>
			</div>
		</nav>
		<div class="breadcrumbs-wrapper">
			<div class="breadcrumbs">
				<?php if (function_exists('snb_breadcrumbs')) { snb_breadcrumbs(); } ?>
			</div>
		</div>
	</header>
