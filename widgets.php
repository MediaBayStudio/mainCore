<?php

function true_remove_default_widget() {
	unregister_widget('WP_Widget_Archives'); // Архивы
	unregister_widget('WP_Widget_Calendar'); // Календарь
  unregister_widget('WP_Widget_Media_Image');      // Изображение
  unregister_widget('WP_Widget_Media_Video');      // Видео
  unregister_widget('WP_Widget_Media_Audio');      // Аудио
	unregister_widget('WP_Widget_Meta'); // Мета
	unregister_widget('WP_Widget_Pages'); // Страницы
	unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии
	unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи
	unregister_widget('WP_Widget_RSS'); // RSS
	unregister_widget('WP_Widget_Search'); // Поиск
	unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток
}

add_action( 'widgets_init', 'true_remove_default_widget', 20 );

class showTwoPosts extends WP_Widget {
  function __construct() {
    parent::__construct(
      'showTwoPosts',
      'Два последних поста', // заголовок виджета
      array( 'description' => 'Показывает два последних поста выбранных категорий в виде картинка-заголовок-описание' ) // описание
    );
  }

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Что-то интересное' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Что-то интересное';
		return $instance;
	}


	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		?>
		<div class="category--header ">
			<h1><?php echo $title; ?></h1>
		</div>
		<div class="category--posts">
			<ul>
			<?php
				array_pop($instance);
				foreach($instance as $key=>$value)
					if ($value) {
						$cat = get_category_by_slug($key);
						$sub_cats = get_categories( array(
							'child_of' => $cat->cat_ID,
							'hide_empty' => 0
						) );
						if( $sub_cats ){
							foreach( $sub_cats as $cat ){
								$categories_array[] = $cat->cat_ID;
							}
						}
					}
				global $post;
				$mypost = get_posts(
					array (
								'category' => $categories_array,
								'posts_per_page' => 2));
				foreach( $mypost as $post ) : setup_postdata($post); ?>
					<li class="post">
						<div class="content-item">
							<div class="view third-effect">
								<a href="<?php the_permalink(); ?>">
									<picture>
									<?php
										if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' )))) {
									?>
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="300" height="170">
									<?php }  else { ?>
											<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_300.svg"
											data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' ); ?> 1x,
											<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'medium' ); ?> 2x" alt="<?php the_title(); ?>"
											alt="<?php the_title(); ?>" class="responsive-image lazyload" width="300" height="170" />
									<?php  }?>
									</picture>
									<div class="mask">
										<p class="info"><i class="fa fa-link"></i></p>
									</div>
								</a>
							</div>
							<div class="post--info">
								<span class="post--link">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</span>
								<?php
								if ( has_excerpt() ){
									the_excerpt();
								}
								else {
									echo "<p>";
									kama_excerpt("maxchar=125");
									echo "</p>";
								}
								?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

class showFourPosts extends WP_Widget {
  function __construct() {
    parent::__construct(
      'showFourPosts',
      'Четыре последних поста', // заголовок виджета
      array( 'description' => 'Показывает четыре последних поста выбранных категорий' ) // описание
    );
  }

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Что-то интересное' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Что-то интересное';
		return $instance;
	}


	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		?>
		<div class="category--header ">
			<h1><?php echo $title; ?></h1>
		</div>
		<div class="category--posts">
			<ul class="category--grid">
			<?php
				array_pop($instance);
				foreach($instance as $key=>$value)
					if ($value) {
						$cat = get_category_by_slug($key);
						$sub_cats = get_categories( array(
							'child_of' => $cat->cat_ID,
							'hide_empty' => 0
						) );
						if( $sub_cats ){
							foreach( $sub_cats as $cat ){
								$categories_array[] = $cat->cat_ID;
							}
						}
					}
				global $post;
				$mypost = get_posts(
					array (
								'category' => $categories_array,
								'posts_per_page' => 4));
				foreach( $mypost as $post ) : setup_postdata($post); ?>
					<li class="post">
						<figure class="effect-chico">
							<picture>
							<?php
								if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' )))) {
							?>
								<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="300" height="170">
							<?php }  else { ?>
									<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_300.svg"
									data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' ); ?> 1x,
									<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'medium' ); ?> 2x" alt="<?php the_title(); ?>"
									alt="<?php the_title(); ?>" class="responsive-image lazyload" width="300" height="170" />
							<?php  }?>
							</picture>
							<figcaption>
								<div class="effect-title"><?php the_title(); ?></div>
								<p> <?php if ( get_post_meta($post->ID, 'checkextratitle', true) == '' ) echo get_post_meta($post->ID, 'extratitle', true); ?></p>
								<a href="<?php the_permalink(); ?>"></a>
							</figcaption>
						</figure>
					</li>
	<?php endforeach; ?>
	</ul>
</div>
	<?php
	}
}

class showLinePosts extends WP_Widget {
  function __construct() {
    parent::__construct(
      'showLinePosts',
      'Лента новостей', // заголовок виджета
      array( 'description' => 'Показывает ленту постов из выбранных категорий с пагинацией внизу' ) // описание
    );
  }

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Последние новости' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Последние новости';
		return $instance;
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		?>
		<div class="category--header ">
			<h1><?php echo $title; ?></h1>
		</div>
		<div class="line--posts">
			<ul class="last-post-container">
				<?php
				array_pop($instance);
				foreach($instance as $key=>$value)
					if ($value) {
						$cat = get_category_by_slug($key);
						$sub_cats = get_categories( array(
							'child_of' => $cat->cat_ID,
							'hide_empty' => 0
						) );
						if( $sub_cats ){
							foreach( $sub_cats as $cat ){
								$categories_array[] = $cat->cat_ID;
							}
						}
					}
					$custom_query_args = array (
															'category__in' => $categories_array, // записи из категорий
															'post_type' => 'post', // тип записей
															'posts_per_page' => '6', // количество записей на странице
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
							<li class="line-post">
								<div class="img-box">
									<a href="<?php the_permalink() ?>">
										<picture>
										<?php
											if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' )))) {
										?>
											<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="200" height="130">
										<?php }  else { ?>
												<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
												data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_200' ); ?> 1x,
												<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'medium' ); ?> 2x" alt="<?php the_title(); ?>"
												alt="<?php the_title(); ?>" class="responsive-image lazyload" width="200" height="130" />
										<?php  }?>
										</picture>
									</a>
								</div>
								<div class="line-post--content">
									<div class="line-post--title">
										<a href="<?php the_permalink() ?>"><?php the_title('', '', true); ?></a>
									</div>
									<div class="line-post--excerpt">
										<?php
											if ( has_excerpt() ) {
												the_excerpt();
											}
											else {
												if ( mb_strlen(get_the_title()) < 42 ) { kama_excerpt("maxchar=130"); }
												else { kama_excerpt("maxchar=85"); }
											}
										?>
									</div>
								</div>
							</li>
						<?php
						endwhile;
					endif;
					/* Конец цикла */
					/* Возвращаем значение текущего поста переменной post */
					wp_reset_postdata();

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
			</ul>
</div>
	<?php
	}
}

class mostCommentedPosts extends WP_Widget {

	function __construct() {
		parent::__construct(
			'mostCommentedPosts',
			__('Babyke - Самые комментируемые', 'most_commented_module_widget_domain'),
			array( 'description' => __( 'Модуль для отображения самых коментируемых статей на главной', 'most_commented_module_widget_domain' ), )
		);
	}

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Самые комментируемые' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Самые комментируемые';
		return $instance;
	}


	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget']; ?>
			<div class="module--title">
				<?php echo $title; ?>
			</div>
			<ul class="most-comments--list">
			<?php
			    global $post;
					unset($instance['title']);
					foreach($instance as $key=>$value)
						if ($value) {
							$cat = get_category_by_slug($key);
							$sub_cats = get_categories( array(
								'child_of' => $cat->cat_ID,
								'hide_empty' => 0
							) );
							if( $sub_cats ){
								foreach( $sub_cats as $cat ){
									$categories_array[] = $cat->cat_ID;
								}
							}
						}
			    $mypost = get_posts(
			        array (
			            'category' => implode(',',$categories_array),
			            'posts_per_page' => 3,
			            'orderby' => 'comment_count' ));
			    foreach( $mypost as $post ) : setup_postdata($post); ?>
			    <li class="most-comments--post">
						<figure class="most-comments--image effect-apollo">
							<a href="<?php the_permalink(); ?>">
								<picture>
								<?php
									if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_200' )))) {
								?>
									<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="130" height="75">
								<?php }  else { ?>
										<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
										data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_150' ); ?> 1x,
										<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' ); ?> 2x" alt="<?php the_title(); ?>"
										alt="<?php the_title(); ?>" class="responsive-image lazyload" width="130" height="75" />
								<?php  }?>
								</picture>
							</a>
              </figure>
					<div class="most-comments--link">
						  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div>
			    </li>

			    <?php endforeach; ?>

			</ul>

	    <?php
		echo $args['after_widget'];
	}
}

class randomPosts extends WP_Widget {

	function __construct() {
		parent::__construct(
			'randomPosts',
			__('Babyke - Случайные записи', 'most_commented_module_widget_domain'),
			array( 'description' => __( 'Модуль для отображения случайных статей на главной', 'most_commented_module_widget_domain' ), )
		);
	}

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Самые популярные' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Самые популярные';
		return $instance;
	}


	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget']; ?>
			<div class="module--title">
				<?php echo $title; ?>
			</div>
			<ul class="most-comments--list">
			<?php
			    global $post;
					unset($instance['title']);
					foreach($instance as $key=>$value)
						if ($value) {
							$cat = get_category_by_slug($key);
							$sub_cats = get_categories( array(
								'child_of' => $cat->cat_ID,
								'hide_empty' => 0
							) );
							if( $sub_cats ){
								foreach( $sub_cats as $cat ){
									$categories_array[] = $cat->cat_ID;
								}
							}
						}
			    $mypost = get_posts(
			        array (
			            'category' => implode(',',$categories_array),
			            'posts_per_page' => 3,
			            'orderby' => 'rand' ));
			    foreach( $mypost as $post ) : setup_postdata($post); ?>
			    <li class="most-comments--post">
						<figure class="most-comments--image effect-apollo">
							<a href="<?php the_permalink(); ?>">
								<picture>
								<?php
									if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_200' )))) {
								?>
									<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="130" height="75">
								<?php }  else { ?>
										<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_150.svg"
										data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'responsive_150' ); ?> 1x,
										<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' ); ?> 2x" alt="<?php the_title(); ?>"
										alt="<?php the_title(); ?>" class="responsive-image lazyload" width="130" height="75" />
								<?php  }?>
								</picture>
							</a>
              </figure>
					<div class="most-comments--link">
						  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div>
			    </li>

			    <?php endforeach; ?>

			</ul>

	    <?php
		echo $args['after_widget'];
	}
}

class mostPopularPosts extends WP_Widget {

	function __construct() {
		parent::__construct(
			'mostPopularPosts',
			__('Babyke - Популярные статьи', 'popular_articles_widget_domain'),
			array( 'description' => __( 'Виджет для отображения популярных статей в сайдбаре', 'popular_articles_widget_domain' ), )
		);
	}

	function form( $instance ){
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else
			$title = __( '', 'Что-то интересное' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
     echo '<p> Выберите необходимые категории </p> ';
    $args = array(
									'parent'  => 0
    );
    $categories = get_categories($args);
    $arrlength=count($categories);
    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$this->get_field_id($categories[$x]->slug)] = '';
    $instance = wp_parse_args( (array) $instance, $tempArray );
		for( $x=0; $x<$arrlength; $x++) $tempCheckFlag[$categories[$x]->slug] = $instance[$categories[$x]->slug]  ? 'checked="checked"' : '';
    for( $x=0; $x<$arrlength; $x++) {
			echo '<p><input class ="checkbox" type="checkbox" value="1" id="'.$this->get_field_id($categories[$x]->slug).'" name="'.$this->get_field_name($categories[$x]->slug).'"'.$tempCheckFlag[$categories[$x]->slug].'>'.$categories[$x]->name.'</p>';
    }
	}

	public function update( $new_instance, $old_instance ) {
		$args = array(
        'parent'  => 0
    );
    $categories = get_categories( $args );   // returns an array of category objects
    $arrlength=count($categories);

    for( $x=0; $x<$arrlength; $x++ ) $tempArray[$categories[$x]->slug] = '';
    $instance = $old_instance;
    $new_instance = wp_parse_args( (array) $new_instance, $tempArray );
    for( $x=0; $x<$arrlength; $x++ ){
        $instance[$categories[$x]->slug] = $new_instance[$categories[$x]->slug] ? 1 : 0;
    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Что-то интересное';
		return $instance;
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title']; ?>
			<ul class="category--grid category--grid__in-sidebar">
				<?php
					array_pop($instance);
					foreach($instance as $key=>$value)
						if ($value) {
							$cat = get_category_by_slug($key);
							$sub_cats = get_categories( array(
								'child_of' => $cat->cat_ID,
								'hide_empty' => 0
							) );
							if( $sub_cats ){
								foreach( $sub_cats as $cat ){
									$categories_array[] = $cat->cat_ID;
								}
							}
						}

					global $post;
					$mypost = get_posts(
				    array (
				        'category' => implode(',',$categories_array),
				        'posts_per_page' => 4,
				        'orderby' => 'rand' ));
					foreach( $mypost as $post ) : setup_postdata($post); ?>
						<li>
							<figure class="effect-sarah">
								<picture>
								<?php
									if (!has_post_thumbnail( $post->id ) || !(@get_headers(wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' )))) {
								?>
									<img src="<?php echo get_stylesheet_directory_uri();?>/images/no-image.svg" alt="Избражение не найдено" width="300" height="170">
								<?php }  else { ?>
										<img src="<?php echo get_bloginfo( 'template_directory' )?>/images/dots_300.svg"
										data-srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'thumbnail' ); ?> 1x,
										<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->id ), 'medium' ); ?> 2x" alt="<?php the_title(); ?>"
										alt="<?php the_title(); ?>" class="responsive-image lazyload" width="300" height="170" />
								<?php  }?>
								</picture>
								<figcaption>
									<div class="effect-title"><?php the_title(); ?></div>
									<p>
										<?php
											if ( get_post_meta($post->ID, 'checkextratitle', true) == '' )
												echo get_post_meta($post->ID, 'extratitle', true);
										?>
									</p>
					        <a href="<?php the_permalink(); ?>"></a>
								</figcaption>
							</figure>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php
		echo $args['after_widget'];
	}
}



function register_widgets() {
	register_widget( 'showTwoPosts' );
	register_widget( 'showFourPosts' );
	register_widget( 'showLinePosts' );
	register_widget( 'mostCommentedPosts' );
	register_widget( 'mostPopularPosts' );
	register_widget( 'randomPosts' );
}
add_action( 'widgets_init', 'register_widgets' );

?>
