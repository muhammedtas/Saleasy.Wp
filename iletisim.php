<?php /*Template Name: İletişim */ get_header(); ?>

<div class="container kurumsal-sayfa">

    <div class="row">

        <div class="container breadcrumb beyaz-kutu">

            <?php if (function_exists('bcn_display')) {
                bcn_display();
            } ?>
        </div>
        <div class="container beyaz-kutu sayfa-kutu">

            <div class="row">
                <div class="col-md-6">
                    <h2><?php the_title(); ?></h2>

                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                    <span>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6020.170483054357!2d28.867967!3d41.023391!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2207a1f30f1de72b!2zxZ5lbmfDvGwgTW9iaWx5YQ!5e0!3m2!1str!2sus!4v1604577341101!5m2!1str!2sus" width="500" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </span>
                </div>
                <div class="col-md-6">

                    <h2> İletişim Formu </h2>

                    <?php echo do_shortcode('[contact-form-7 id="137" title="İletişim formu 1"]'); ?>
                </div>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>