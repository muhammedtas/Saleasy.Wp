<?php get_header();?>

<div class="container kurumsal-sayfa">

	<div class="row">
		
		<div class="container breadcrumb beyaz-kutu">
		
		<?php if(function_exists('bcn_display'))
        {
           bcn_display();
        }?>			
		</div>
		<div class="container beyaz-kutu sayfa-kutu">
            <h1><?php the_title(); ?></h1>
            <?php while(have_posts()): the_post(); ?>
            <?php the_content();?>
            <?php endwhile; ?>
		</div>
		
	</div>
	
</div>	

<?php get_footer(); ?>
