<?php /* Template Name: Ana Sayfa */ get_header(); ?>

<!--Slider Başlangıç-->
<div class="container-fluid slider-arkasi">
	<div class="container slider-alani">
		<div class="swiper-container">
			<div class="swiper-wrapper">

				<?php

				if (have_rows('slidelar', 'option')) :
					while (have_rows('slidelar', 'option')) : the_row();

						$slide_gorseli = get_sub_field('slide_gorseli');
				?>

						<div class="swiper-slide" style="background-image: url('<?php echo $slide_gorseli['url'] ?>')">
							<span class="slide-baslik"><?php the_sub_field('slide_basligi'); ?></span>
							<div class="clearfix"></div>
							<a href="<?php the_sub_field('slide_linki'); ?>" class="blue-button"><?php the_sub_field('slide_buton_yazisi'); ?></a>
						</div>

				<?php endwhile;
				else :
				endif;
				?>

			</div>

			<div class="swiper-pagination"></div>

			<div class="swiper-button-prev">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44">
					<path d="M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z"></path>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44">
					<path d="M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z"></path>
				</svg>
			</div>
		</div>
	</div>
</div>
<!--Slider Bitiş -->

<div class="clearfix"></div>



<!--Ana Sayfa Ürünler Başlangıç-->
<div class="container anasayfa-urunler">
	<span class="tab-baslik renkli-baslik"><?php the_field('tab_alani_baslik', 'option'); ?></span>
	<ul class="nav nav-tabs anasayfa-urunler-tab" role="tablist">

		<?php
		$sayac1 = 0;
		if (have_rows('tab_icerikleri', 'option')) :
			while (have_rows('tab_icerikleri', 'option')) : the_row();
		?>

				<?php $tab_kategorisi = get_sub_field('tab_kategorisi'); ?>
				<li class="nav-item">
					<a class="nav-link  <?php if ($sayac1 == 0) echo "active"; ?>" id="<?php echo $tab_kategorisi->term_id; ?>" data-toggle="tab" href="#<?php echo $tab_kategorisi->slug; ?>" role="tab" aria-controls="" aria-selected="true"><?php the_sub_field('tab_basligi'); ?></a>
				</li>

		<?php $sayac1++;
			endwhile;
		else :
		endif;
		?>
	</ul>
	<div class="tab-content" id="anasayfa_urunler_icerik">

		<?php
		$sayac2 = 0;
		if (have_rows('tab_icerikleri', 'option')) :
			while (have_rows('tab_icerikleri', 'option')) : the_row();
		?>
				<?php $tab_kategorisi = get_sub_field('tab_kategorisi'); ?>

				<div class="tab-pane fade <?php if ($sayac2 == 0) echo "active show"; ?>" id="<?php echo $tab_kategorisi->slug; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_kategorisi->slug; ?>">
					<div class="row">

						<?php
						$siralama = get_sub_field('siralama_yontemi');
						$gosterilecek_urun_sayisi = get_sub_field('gosterilecek_urun_sayisi');
						if ($siralama == "tarihe") {
							$siralama = "date";
						} elseif ($siralama == "satisagore") {
							$siralama = "meta_value_num";
							$satisagoresiralama = "total_sales";
						}

						if ($siralama == "indirimegore") {
							$args = array(
								'post_type' => 'product',
								'posts_per_page' => $gosterilecek_urun_sayisi,
								'meta_query' => array(
									'relation' => 'OR',
									array(
										'key' => '_sale_price',
										'value' => 0,
										'compare' => '>',
										'type' => 'numeric'
									),
									array(
										'key' => '_min_variation_sale_price',
										'value' => 0,
										'compare' => '>',
										'type' => 'numeric'
									)
								)
							);
						} else {
							$args = array(
								'post_type' => 'product',
								'meta_key' => $satisagoresiralama,
								'orderby' => $siralama,
								'posts_per_page' => $gosterilecek_urun_sayisi,
								'product_cat' => $tab_kategorisi->slug,
							);
						}



						$dongu1 = new WP_Query($args);

						while ($dongu1->have_posts()) : $dongu1->the_post(); ?>

							<div class="col-md-4 col-lg-3">

								<div class="urun-kutu">
									<a href="<?php the_permalink(); ?>">
										<?php

										if (has_post_thumbnail($dongu1->post->ID)) :
											echo get_the_post_thumbnail($dongu1->post->ID, 'shop-catalog', array('class' => 'img-fluid anasayfa-urun-liste-foto')); ?>
										<?php else : ?>
											Ürün Görseli Yok
										<?php endif; ?>


									</a>
									<span class="urun-kutu-baslik"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
									<div class="clearfix"></div>
									<div class="urun-kutu-fiyat">
										<?php if ($product->is_type('simple')) : ?>
											<?php $normal_fiyat = (float) $product->get_regular_price();
											$indirimli_fiyat = (float) $product->get_price();
											$indirim_orani = round(100 - ($indirimli_fiyat / $normal_fiyat * 100), 1) . '% <br> indirim';
											$indirim_miktari = $normal_fiyat - $indirimli_fiyat;
											?>
											<?php if ($product->is_on_sale()) : ?>

												<span class="urun-liste-indirim-orani">
													<?php
													echo $indirim_orani;
													?>
												</span>
											<?php endif; ?>

										<?php elseif ($product->is_type('variable')) : ?>

											<?php if ($product->is_on_sale()) : ?>
												<?php

												$varyasyon_normal_fiyat = (float) $product->get_variation_regular_price('max', true);
												$varyasyon_indirimli_fiyat = (float) $product->get_variation_sale_price('max', true);
												$varyasyon_indirim_orani = round(100 - ($varyasyon_indirimli_fiyat / $varyasyon_normal_fiyat * 100), 1) . '% <br> indirim';
												$varyasyon_indirim_miktari = $varyasyon_normal_fiyat - $varyasyon_indirimli_fiyat;
												?>
												<span class="urun-liste-indirim-orani">
													<?php
													echo $varyasyon_indirim_orani;
													?>
												</span>
											<?php endif; ?>
										<?php endif; ?>
										<?php echo $product->get_price_html(); ?>

									</div>
									<?php
									$stok_miktari = $product->get_stock_quantity();
									$stok_durumu = $product->stock_status;
									?>

									<?php if ($stok_durumu > 0 || $stok_durumu == "instock") :  ?>
										<div class="urun-kutu-sepete-ekle">
											<form class="cart" action="" method="post" entitytype="multipart/form-data">
												<?php do_action('woocommerce_before_add_to_cart_button'); ?>
												<!-- <button type="submit" name="add-to-cart" value="<?php //echo esc_attr($product->get_id()); 
																										?>" class="blue-button">
													<?php //echo esc_html($product->single_add_to_cart_text()); 
													?>
												</button> -->
												<span>
													<a href="<?php the_permalink(); ?>" class="blue-button" rel="nofollow">Seçenekleri Gör</a>
												</span>
											</form>
										</div>
									<?php else : ?>

										<span class="stok-durumu-cerceve">
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#stokFormu">Stoğa Gelince Haber Ver</button>
										</span>
										<span class="clearfix"></span>


										<!-- Modal -->
										<div class="modal fade" id="stokFormu" tabindex="-1" role="dialog" aria-labelledby="stokFormu" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="stokFormu">Ürün Haberdar Etme Formu</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<?php echo do_shortcode('[contact-form-7 id="138" title="Haberdar etme formu"]'); ?>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
													</div>
												</div>
											</div>
										</div>

									<?php endif; ?>
									<div class="clearfix"></div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>

		<?php $sayac2++;
			endwhile;
		else :
		endif;
		?>

	</div>
	<?php $site_logosu = get_field('site_logosu', 'option'); ?>
	<a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo $site_logosu['url']; ?>" alt="Saleasy" class="anasayfa-urunler-alt-logo" /></a>

</div>
<!--Ana Sayfa Ürünler Bitiş-->


<?php get_footer(); ?>