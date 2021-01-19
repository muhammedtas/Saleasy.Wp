<!--Footer Başlangıç -->
<div class="container-fluid footer-alani">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-5">
				<?php
				$footer_logosu = get_field('footer_logosu', 'option');

				?>
				<img src="<?php echo $footer_logosu['url']; ?>" alt="" class="footer-logo" />
				<div class="clearfix"></div>
				<span class="footer-hakkinda">
					<?php the_field('footer_kisa_yazi_alani', 'option'); ?>

				</span>
				<div class="clearfix"></div>
				<span class="footer-adres"><i class="fas fa-map-marker-alt"></i> <?php the_field('footer_adres', 'option'); ?> </span>
				<div class="clearfix"></div>
				<span class="footer-telefon"><i class="fas fa-phone-volume"></i> <a href="tel:<?php the_field('footer_telefon', 'option'); ?>"> <?php the_field('footer_telefon', 'option'); ?> </a></span>
				<div class="clearfix"></div>
				<span class="footer-eposta"><i class="fas fa-envelope"></i> <a href="mailto:<?php the_field('footer_e-posta', 'option'); ?>"><?php the_field('footer_e-posta', 'option'); ?></a></span>

			</div>
			<div class="col-md-4 col-lg-2">

				<h3><?php the_field('footer_menu_1_basligi', 'option'); ?></h3>

				<?php wp_nav_menu(array('theme_location' => 'footermenu1', 'menu_class' => 'footer-menu', 'menu_id' => 'footer-menu'));  ?>


			</div>

			<div class="col-md-4 col-lg-2">

				<h3><?php the_field('footer_menu_2_basligi', 'option'); ?></h3>

				<?php wp_nav_menu(array('theme_location' => 'footermenu2', 'menu_class' => 'footer-menu', 'menu_id' => 'footer-menu'));  ?>

			</div>

			<div class="col-md-4 col-lg-3">

				<h3><?php the_field('footer_menu_3_basligi', 'option'); ?></h3>

				<?php wp_nav_menu(array('theme_location' => 'footermenu3', 'menu_class' => 'footer-menu', 'menu_id' => 'footer-menu'));  ?>


			</div>

		</div>

	</div>

</div>



<div class="container footer-alani-2">
	<div class="row">
		<div class="col-md-6 col-6 footer-alani-2-sol"><?php the_field('footer_copyright_yazisi', 'option'); ?></div>
		<div class="col-md-6 col-6 footer-alani-2-sag"><a href="#" target="_blank"><?php the_field('footer_yapan_kisi', 'option'); ?></a></div>
	</div>
</div>

<a href="#sayfabasi" target="_blank" class="sayfa-basina-git"><i class="fas fa-angle-up"></i></a>

<?php wp_footer(); ?>

</body>

</html>
<!--Footer Bitiş -->