<?php get_header() ?>

    <section class="pt-4 pb-5" id="mainContent">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if ( have_posts() ) :
                        while ( have_posts() ) : the_post();
                    ?>

                    <h1><?php the_title()?></h1>
                            <div class="content"><?php the_content()?></div>

                        <?php endwhile;
	                endif;
	                ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>