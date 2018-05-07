<?php
/**
 * Шаблон сайдбара (sidebar.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<?php if (is_active_sidebar( 'sidebar' )) { // если в сайдбаре есть что выводить ?>
	<aside class="page-sidebar" role="complementary">
	    <?php if(!dynamic_sidebar('sidebar')): ?>
	        <p>Виджеты сайдбара</p>
	    <?php endif; ?>
	</aside>
<?php } ?>
