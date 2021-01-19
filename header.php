<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title('|', 'true', 'right'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php $favicon = get_field('favicon', 'option'); ?>

	<link rel="shortcut icon" href="<?php echo $favicon['url']; ?>" type="image/x-icon">
	<?php include('style.php'); ?>
	<?php wp_head(); ?>
</head>


<body <?php body_class('drawer drawer--left'); ?>>
	<!--Mobil Menü Başlangıç-->
	<header role="banner" class="sadece-mobil">
		<nav class="drawer-nav" role="navigation">

			<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'mobil-menu', 'menu_id' => 'mobil-menu')); ?>

		</nav>
	</header>
	<!--Mobil Menü Bitiş-->

	<!--Header Üst Başlangıç-->
	<div class="container ust-bar" id="sayfabasi">
		<div class="row">
			<div class="col-md-6 ust-bar-sol">
				<?php the_field('slogan_alani', 'option'); ?>
			</div>
			<div class="col-md-6 ust-bar-sag">

				<?php if (is_user_logged_in()) : $kullanici = wp_get_current_user(); ?>
					<span class="ust-bar-karsilama">

						Merhaba <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"><?php echo $kullanici->display_name; ?></a>
					</span>

				<?php else : ?>
					<span class="ust-bar-karsilama">
						<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">Üye Ol / Giriş Yap</a>
					</span>
				<?php endif; ?>
				<?php wp_nav_menu(array('theme_location' => 'ustmenu', 'menu_class' => 'ust-bar-menu', 'menu_id' => 'ust-bar-menu')); ?>
			</div>
		</div>
	</div>
	<!--Header Üst Bitiş-->

	<!--Header Orta Başlangıç-->
	<div class="container ust-orta-bolum">
		<div class="row">
			<div class="col-md-3 col-lg-3 logo-alani">
				<?php $site_logosu = get_field('site_logosu', 'option'); ?>
				<a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo $site_logosu['url']; ?>" alt="" class="site-logosu" /></a>
			</div>

			<div class="col-md-6 col-lg-7 arama-alani">
				<form name="header-arama" method="GET" class="header-arama" action="<?php echo esc_url(home_url('/')); ?>">

					<?php

					$secili_kategori = $_REQUEST['product-cat'];

					$args = array(

						'show_option_all' => esc_html__('Tüm Kategoriler'),
						'value_field' => 'slug',
						'depth' => 1,
						'hierarchical' => 1,
						'hide_empty' => 0,
						'taxonomy' => 'product_cat',
						'class' => 'urun_kategorisi hidden-xs',
						'name' => 'product_cat',
						'selected' => $secili_kategori,
					);

					wp_dropdown_categories($args);

					?>

					<input type="hidden" value="product" name="post_type">

					<input type="text" name="s" class="arama-input" required="" maxlength="128" value="<?php echo get_search_query(); ?>" placeholder="<?php the_field('arama_gecici_metin', 'option'); ?>">
					<button type="submit" title="Ara" class="arama-buton"><span><i class="fas fa-search"></i></span></button>
				</form>
			</div>

			<div class="col-md-3 col-lg-2 sepet-alani">
				<a href="<?php echo wc_get_cart_url(); ?>">
					<span class="sepet-baslik"><?php get_field('sepetinizde_yazisi', 'option'); ?></span>
					<span class="sepet-guncel">
						<span class="sepet-urun"><span class="sepet-urun-sayi"><?php echo WC()->cart->cart_contents_count; ?></span> Ürün Var</span>
						<span class="sepet-fiyat"><?php echo WC()->cart->get_cart_total(); ?></span>
					</span>
				</a>
			</div>

		</div>
	</div>
	<!--Header Orta Bitiş-->


	<!--Header Menü Alanı Başlangıç-->
	<div class="container menu-alani">
		<button type="button" class="drawer-toggle drawer-hamburger">
			<span class="sr-only">Menü</span>
			<span class="drawer-hamburger-icon">
				<span style="display: block;    margin-left: 20px;    line-height: 0px;    width: 87px;"></span>
			</span>
		</button>
		<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'ana-menu', 'menu_id' => 'ana-menu')); ?>

	</div>

	<!--Header Menü Alanı Bitiş-->