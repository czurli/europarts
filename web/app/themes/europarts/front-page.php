<?php get_header() ?>

<?php
$slider_repeater = get_field('slide_repeater');
if ($slider_repeater) {
    ?>
    <section class="home-slider d-none d-lg-block" id="homeSlider">
        <div class="slides">
    <?php
    foreach ($slider_repeater as $slide) {
        ?>
        <div class="slide">
            <img src="<?php echo $slide['foto_slider']['url']?>" class="img-fluid w-100">
            <div class="slide-content">
                <span class="slide-title py-3"><?php echo $slide['titolo_slider']?></span>
                <span class="slide-subtitle py-3"><?php echo $slide['descrizione_slider']?></span>
                <div class="pt-5"><a href="<?php echo $slide['link_slider']?>" class="button1">Scopri</a></div>
            </div>
        </div>
            <?php
    }
    ?>
        </div>
    </section>
<?php
}
?>

    <section class="py-3 pt-lg-4 pb-lg-5 " id="featuredProducts">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <span class="py-3 title-featured text-center d-block"><?php echo __( 'In evidenza', 'europarts' ) ?></span>
                </div>
            </div>
            <div class="woocommerce home-featured">
                <div class="products row">
					<?php
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);

					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 12,
						'tax_query'      => $tax_query
					);
					$loop = new WP_Query( $args );
					if ($loop->have_posts() ) {
						for ($i = 0; $i < $loop->found_posts; $i++ ) : $loop->the_post();
						?>
                        <div class="col-12 product p-0">
                            <div class="shadow-int mx-1 mx-lg-2 my-2">
                            <?php woocommerce_template_loop_product_link_open()?>
                            <?php woocommerce_template_loop_product_thumbnail();?>
                            <?php woocommerce_template_loop_product_title();?>
                            <?php woocommerce_template_loop_price();?>
                            <?php woocommerce_template_loop_product_link_close();?>
                            <?php woocommerce_quantity_input()?>
                            <?php woocommerce_template_loop_add_to_cart()?>
                            </div>
                        </div>
                        <?php
							//wc_get_template_part( 'content', 'product1' );
						endfor;
					} else {
						echo __( 'No featured products' );
					}
					wp_reset_postdata();
					wp_reset_query();
					?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-3 py-lg-5" id="mainContent">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <?php
                    if(have_posts()):
                        while (have_posts()): the_post();
                    ?>
                    <h1><?php the_title()?></h1>
                    <div class="content">
                        <?php the_content()?>
                    </div>
                    <?php
                        endwhile;
                        endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php
$category_selected     = get_field('categoria_evidenza_1');
$category_children_ids = get_term_children( $category_selected, 'product_cat' );
?>
    <section class="py-3 py-lg-5" id="featuredCategory">
        <div class="container">
            <div class="row equal">
                <div class="col-lg-2 py-3 py-lg-0">
                    <h3><?php echo $main_category = get_the_category_by_ID( $category_selected ); ?></h3>
					<?php
					if ( $category_children_ids ) {
						?>
                        <ul class="category_children">
							<?php
							for ($i = 0; $i < count($category_children_ids); $i++) {
								$child_category = get_term( $category_children_ids[$i] );
								?>
                                <li <?php wc_product_cat_class() ?>>
                                    <a href="<?php echo get_category_link($child_category->term_id)?>"><?php echo $child_category->name  ?></a>
                                </li>
							<?php
							}
							?>
                        </ul>
						<?php
					}
					?>
                </div>
                <div class="col-lg-4 py-3 py-lg-0">
					<?php
					$cat_id = get_term_meta( $category_selected, 'thumbnail_id', true );
					$image  = wp_get_attachment_image_src( $cat_id, 'large' );
					?>
                    <div class="cat-img-featured h-100 bg-cover" style="background-image: url('<?php echo $image[0] ?>')">
                        <svg class="d-none d-lg-block" version="1.1" id="svg-home" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 358.41 358.41" style="enable-background:new 0 0 358.41 358.41;"
                             xml:space="preserve">
                           <g>
                               <path style="fill:#FFFFFF;" d="M0,358.41h358.41V0C358.41,197.95,197.95,358.41,0,358.41z"/>
                           </g>
                        </svg>
                        <div class="cat-text-featured p-4">
                            <p>Tutti i migliori accessori per xxxxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxx</p>
                            <div class="pt-5"><a href="<?php echo get_category_link($category_selected)?>" class="button1">Scopri</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 py-3 py-lg-0">
                    <div class="woocommerce container">
                        <div class="products row selected-products">
							<?php
							$tax_query = array(
								array(
									'taxonomy' => 'product_cat',
									'field'    => 'term_id',
									'terms'    => array( $category_selected ),
									'operator' => 'IN'
								),
								array(
									'taxonomy' => 'product_visibility',
									'field'    => 'name',
									'terms'    => 'exclude-from-catalog',
									'operator' => 'NOT IN',

								)
							);
							$args      = array(
								'post_type'      => 'product',
								'posts_per_page' => 6,
								'tax_query'      => $tax_query,
								'orderby'        => 'rand'
							);
							$loop      = new WP_Query( $args );
							if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
									wc_get_template_part( 'content', 'product' );
								endwhile;
							} else {
								echo __( 'No products' );
							}
                            wp_reset_postdata();
                            wp_reset_query();
							?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-3 py-lg-4 bg-grey" id="advantages">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 text-center vline1 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="82.14" height="82.141" viewBox="0 0 82.14 82.141">
                        <defs>
                            <style>.a {
                                    fill: #2b9ce6;
                                }</style>
                        </defs>
                        <g transform="translate(-0.001)">
                            <g transform="translate(40.363 38.57)">
                                <path class="a"
                                      d="M254.326,240.889a1.6,1.6,0,1,0,0,2.268A1.6,1.6,0,0,0,254.326,240.889Z"
                                      transform="translate(-251.587 -240.418)"/>
                            </g>
                            <g transform="translate(49.831 16.27)">
                                <path class="a"
                                      d="M324.293,103.766a8.022,8.022,0,1,0,0,11.344A8.018,8.018,0,0,0,324.293,103.766Zm-2.269,9.075a4.813,4.813,0,1,1,0-6.807A4.819,4.819,0,0,1,322.024,112.842Z"
                                      transform="translate(-310.603 -101.415)"/>
                            </g>
                            <g transform="translate(15.405 0)">
                                <g transform="translate(0 0)">
                                    <path class="a"
                                          d="M162.284.47A1.6,1.6,0,0,0,161.092,0,71.27,71.27,0,0,0,141.826,3.99a53.713,53.713,0,0,0-20.381,12.361C120.258,17.538,119.1,18.8,118,20.1c-5.238-3.083-9.435-2.116-12.088-.7-6.109,3.27-9.891,12.147-9.891,18.5a1.6,1.6,0,0,0,2.739,1.134,10.213,10.213,0,0,1,8.494-2.85l.562.562a56.43,56.43,0,0,0-2.65,7.792,4.541,4.541,0,0,0,.194,2.787,15.192,15.192,0,0,0-4.332,3.055c-4.13,4.13-4.968,14.194-5,14.621a1.6,1.6,0,0,0,1.6,1.731q.063,0,.126,0c.426-.034,10.491-.872,14.621-5a15.194,15.194,0,0,0,3.054-4.331,4.531,4.531,0,0,0,2.788.193A56.436,56.436,0,0,0,126,54.942l.562.562A10.214,10.214,0,0,1,123.715,64a1.6,1.6,0,0,0,1.134,2.739c6.35,0,15.227-3.782,18.5-9.891,1.42-2.653,2.387-6.85-.7-12.088,1.307-1.1,2.566-2.26,3.753-3.447a53.718,53.718,0,0,0,12.361-20.381,71.268,71.268,0,0,0,3.989-19.267A1.6,1.6,0,0,0,162.284.47ZM99.6,34.454c1-4.823,3.891-10.115,7.819-12.217,2.624-1.4,5.493-1.267,8.543.4a64.867,64.867,0,0,0-6.74,10.987,1.692,1.692,0,0,0-.849-.5A13.712,13.712,0,0,0,99.6,34.454ZM110.1,59.46C107.9,61.666,102.72,62.83,99.45,63.3c.475-3.271,1.639-8.445,3.845-10.651a11.561,11.561,0,0,1,4.107-2.7l5.4,5.4A11.559,11.559,0,0,1,110.1,59.46Zm7.314-4.978a1.505,1.505,0,0,1-1.4-.455l-3.142-3.142-4.143-4.143a1.506,1.506,0,0,1-.456-1.4,52.093,52.093,0,0,1,2-6.127L123.542,52.48A52.061,52.061,0,0,1,117.415,54.483Zm23.1.848c-2.1,3.927-7.394,6.822-12.217,7.818a13.655,13.655,0,0,0,1.315-8.811,1.675,1.675,0,0,0-.488-.81,64.89,64.89,0,0,0,10.987-6.741C141.784,49.838,141.922,52.707,140.518,55.331Zm3.617-16.29a58.237,58.237,0,0,1-4.627,4.151,61.638,61.638,0,0,1-12.789,7.928L111.635,36.036a61.628,61.628,0,0,1,7.928-12.789,58.223,58.223,0,0,1,4.151-4.627A50.025,50.025,0,0,1,141.95,7.361L155.393,20.8A50.021,50.021,0,0,1,144.135,39.041Zm12.413-21.62L145.334,6.207a72.128,72.128,0,0,1,14.077-2.864A72.139,72.139,0,0,1,156.547,17.421Z"
                                          transform="translate(-96.018 0)"/>
                                </g>
                            </g>
                            <g transform="translate(31.288 65.796)">
                                <path class="a"
                                      d="M202.3,410.591a1.6,1.6,0,0,0-2.269,0l-4.537,4.539a1.6,1.6,0,1,0,2.269,2.268l4.537-4.539A1.6,1.6,0,0,0,202.3,410.591Z"
                                      transform="translate(-195.021 -410.121)"/>
                            </g>
                            <g transform="translate(8.599 43.108)">
                                <path class="a"
                                      d="M60.869,269.171a1.6,1.6,0,0,0-2.269,0l-4.539,4.537a1.6,1.6,0,1,0,2.268,2.269l4.539-4.537A1.6,1.6,0,0,0,60.869,269.171Z"
                                      transform="translate(-53.592 -268.701)"/>
                            </g>
                            <g transform="translate(13.614 68.066)">
                                <path class="a"
                                      d="M98.458,424.741a1.6,1.6,0,0,0-2.269,0L85.321,435.607a1.6,1.6,0,1,0,2.269,2.269L98.458,427.01A1.6,1.6,0,0,0,98.458,424.741Z"
                                      transform="translate(-84.851 -424.271)"/>
                            </g>
                            <g transform="translate(0.779 68.066)">
                                <path class="a"
                                      d="M18.458,424.741a1.6,1.6,0,0,0-2.269,0L5.321,435.607a1.6,1.6,0,1,0,2.269,2.269L18.458,427.01A1.6,1.6,0,0,0,18.458,424.741Z"
                                      transform="translate(-4.851 -424.271)"/>
                            </g>
                            <g transform="translate(0.001 54.452)">
                                <path class="a"
                                      d="M13.606,339.88a1.6,1.6,0,0,0-2.269,0L.471,350.748a1.6,1.6,0,0,0,2.269,2.269l10.866-10.868A1.6,1.6,0,0,0,13.606,339.88Z"
                                      transform="translate(-0.001 -339.41)"/>
                            </g>
                            <g transform="translate(44.901 31.764)">
                                <path class="a"
                                      d="M284.879,198.46a1.6,1.6,0,0,0-2.269,0l-2.268,2.268A1.6,1.6,0,0,0,282.61,203l2.268-2.269A1.6,1.6,0,0,0,284.879,198.46Z"
                                      transform="translate(-279.871 -197.99)"/>
                            </g>
                        </g>
                    </svg>
                    <span class="d-block p-0 pt-3 font-weight-bolder">Spedizione Gratuita</span>
                    <span class="d-block p-0">Sopra i 150 € di spesa</span>
                    <div class="vline d-none d-lg-block"></div>
                </div>
                <div class="col-lg-4 text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="81.855" height="81.678" viewBox="0 0 81.855 81.678">
                        <defs>
                            <style>.a {
                                    fill: #2b9ce6;
                                }</style>
                        </defs>
                        <g transform="translate(0 -0.516)">
                            <g transform="translate(0 0.516)">
                                <g transform="translate(0 0)">
                                    <rect class="a" width="8.203" height="2.734" transform="translate(58.787 54.511)"/>
                                    <rect class="a" width="8.203" height="2.734" transform="translate(47.85 54.511)"/>
                                    <rect class="a" width="8.203" height="2.734" transform="translate(36.913 54.511)"/>
                                    <path class="a"
                                          d="M80.643,28.782,53.592,1.726A4.084,4.084,0,0,0,50.685.516h-.012a4.045,4.045,0,0,0-2.883,1.21l-28.7,28.692H4.1a4.1,4.1,0,0,0-4.1,4.1V72.8a4.1,4.1,0,0,0,4.1,4.1H24.357l4.08,4.084a4.084,4.084,0,0,0,2.907,1.21h.011a4.047,4.047,0,0,0,2.885-1.21L38.326,76.9h31.4a4.1,4.1,0,0,0,4.1-4.1V41.4l6.811-6.811a4.08,4.08,0,0,0,.007-5.809ZM63.252,15.256,48.09,30.418H36.481L57.447,9.452ZM49.726,3.654a1.348,1.348,0,0,1,1.906-.023l.023.023,3.859,3.865-22.9,22.9H22.96ZM32.3,79.057a1.33,1.33,0,0,1-.957.41,1.367,1.367,0,0,1-.973-.41L28.225,76.9H34.46ZM71.091,72.8a1.367,1.367,0,0,1-1.367,1.367H4.1A1.367,1.367,0,0,1,2.734,72.8V53.659H71.091Zm0-21.874H2.734v-8.2H71.091Zm0-10.937H2.734V34.519A1.367,1.367,0,0,1,4.1,33.152H69.724a1.367,1.367,0,0,1,1.367,1.367Zm7.619-7.337h0l-4.885,4.885V34.519a4.1,4.1,0,0,0-4.1-4.1H51.951L65.18,17.19,78.7,30.715a1.367,1.367,0,0,1,.41.978A1.34,1.34,0,0,1,78.71,32.651Z"
                                          transform="translate(0 -0.516)"/>
                                    <path class="a"
                                          d="M32.841,369.1a5.462,5.462,0,0,0,.559-.559,5.421,5.421,0,0,0,7.2.927,5.559,5.559,0,0,0,2.373-4.506A5.469,5.469,0,0,0,37.5,359.49a4.144,4.144,0,0,0-.809.068l-.036.01h-.04a5.4,5.4,0,0,0-3.217,1.816,5.468,5.468,0,1,0-.559,7.713Zm4.315-6.844a1.654,1.654,0,0,1,.346-.029,2.734,2.734,0,0,1,2.734,2.734,2.681,2.681,0,0,1-.537,1.6c-.049.067-.088.137-.144.206-.01.011-.023.018-.034.029a2.718,2.718,0,1,1-2.365-4.544Zm-7.857-.029a2.734,2.734,0,1,1-2.734,2.734A2.734,2.734,0,0,1,29.3,362.224Z"
                                          transform="translate(-19.729 -298.144)"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span class="d-block p-0 pt-3 font-weight-bolder">Metodi di pagamento multipli</span>
                    <span class="d-block p-0">Sicuri al 100%</span>
                    <div class="vline d-none d-lg-block"></div>
                </div>
                <div class="col-lg-4 text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="69.141" height="69.141" viewBox="0 0 69.141 69.141">
                        <defs>
                            <style>.a {
                                    fill: #2b9ce6;
                                }</style>
                        </defs>
                        <path class="a"
                              d="M39.487,40.928a1.441,1.441,0,0,1-1.44-1.44V33.726A15.865,15.865,0,0,0,22.2,17.881H16.44a1.44,1.44,0,0,1,0-2.881H22.2A18.747,18.747,0,0,1,40.928,33.726v5.762A1.441,1.441,0,0,1,39.487,40.928Z"
                              transform="translate(28.213 28.213)"/>
                        <path class="a"
                              d="M26.523,32.164a1.429,1.429,0,0,1-.936-.346L15.5,23.176a1.441,1.441,0,0,1,0-2.189l10.083-8.643a1.441,1.441,0,1,1,1.873,2.189l-8.807,7.548,8.807,7.548a1.44,1.44,0,0,1-.936,2.535Z"
                              transform="translate(28.213 22.572)"/>
                        <path class="a"
                              d="M45.653,44.451H5.321A4.327,4.327,0,0,1,1,40.13V8.44A1.441,1.441,0,0,1,2.44,7H51.415a1.441,1.441,0,0,1,1.44,1.44v8.815a1.44,1.44,0,1,1-2.881,0V9.881H3.881V40.13a1.445,1.445,0,0,0,1.44,1.44H45.653a1.44,1.44,0,0,1,0,2.881Z"
                              transform="translate(1.881 13.166)"/>
                        <path class="a" d="M22.845,12.881H8.44A1.44,1.44,0,1,1,8.44,10h14.4a1.44,1.44,0,1,1,0,2.881Z"
                              transform="translate(13.166 18.809)"/>
                        <path class="a"
                              d="M56.177,17.4H1.44A1.441,1.441,0,0,1,0,15.964V4.44A1.441,1.441,0,0,1,1.44,3H56.177a1.441,1.441,0,0,1,1.44,1.44V15.964A1.441,1.441,0,0,1,56.177,17.4Zm-53.3-2.881H54.737V5.881H2.881Z"
                              transform="translate(0 5.643)"/>
                        <path class="a"
                              d="M56.176,11.523a1.447,1.447,0,0,1-1.02-.421L46.937,2.881H10.678L2.459,11.1A1.44,1.44,0,0,1,.422,9.066L9.065.423A1.43,1.43,0,0,1,10.082,0H47.533a1.451,1.451,0,0,1,1.02.421L57.2,9.063a1.442,1.442,0,0,1-1.02,2.46Z"
                              transform="translate(0.001 0)"/>
                    </svg>
                    <span class="d-block p-0 pt-3 font-weight-bolder">Reso Gratuito entro 30 giorni</span>
                    <span class="d-block p-0">Per qualsiasi motivo</span>
                </div>
            </div>
        </div>
    </section>

<?php
$category_selected     = get_field('categoria_evidenza_2');;
$category_children_ids = get_term_children( $category_selected, 'product_cat' );
?>
    <section class="py-3 py-lg-5" id="featuredCategory">
        <div class="container">
            <div class="row equal">
                <div class="col-lg-2 py-3 py-lg-0">
                    <h3><?php echo $main_category = get_the_category_by_ID( $category_selected ); ?></h3>
					<?php
					if ( $category_children_ids ) {
						?>
                        <ul class="category_children">
							<?php

							foreach ( $category_children_ids as $category_child_id ) {
								$child_category = get_the_category_by_ID( $category_child_id );
								echo '<li><a href='.get_category_link($category_child_id).'>' . $child_category . '</a></li>';
							}
							?>
                        </ul>
						<?php
					}
					?>
                </div>
                <div class="col-lg-4 py-3 py-lg-0">
					<?php
					$cat_id = get_term_meta( $category_selected, 'thumbnail_id', true );
					$image  = wp_get_attachment_image_src( $cat_id, 'large' );
					?>
                    <div class="cat-img-featured h-100 bg-cover" style="background-image: url('<?php echo $image[0] ?>')">
                        <svg class="d-none d-lg-block" version="1.1" id="svg-home" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 358.41 358.41" style="enable-background:new 0 0 358.41 358.41;"
                             xml:space="preserve">
                           <g>
                               <path style="fill:#FFFFFF;" d="M0,358.41h358.41V0C358.41,197.95,197.95,358.41,0,358.41z"/>
                           </g>
                        </svg>
                        <div class="cat-text-featured p-4">
                            <p>Tutti i migliori accessori per xxxxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxx</p>
                            <div class="pt-5"><a href="<?php echo get_category_link($category_selected)?>" class="button1">Scopri</a></div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 py-3 py-lg-0">
                    <div class="woocommerce container">
                        <div class="products row selected-products">
							<?php
							$tax_query = array(
								array(
									'taxonomy' => 'product_cat',
									'field'    => 'term_id',
									'terms'    => array( $category_selected ),
									'operator' => 'IN'
								),
								array(
									'taxonomy' => 'product_visibility',
									'field'    => 'name',
									'terms'    => 'exclude-from-catalog',
									'operator' => 'NOT IN',

								)
							);
							$args      = array(
								'post_type'      => 'product',
								'posts_per_page' => 6,
								'tax_query'      => $tax_query,
								'orderby'        => 'rand'
							);
							$loop      = new WP_Query( $args );
							if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
									wc_get_template_part( 'content', 'product' );
								endwhile;
							} else {
								echo __( 'No products' );
							}
							wp_reset_postdata();
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-3 my-lg-5 bg-cover" style="background-image: url('<?php echo get_template_directory_uri() ?>/assets/images/calm-pensive-female.jpg')" id="newsletter">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 py-5 px-3 overlay-white">
					<?php dynamic_sidebar( 'newsletter' ) ?>
                </div>
            </div>
        </div>

    </section>

    <section class="py-3 py-lg-5" id="utilities">
        <div class="container">
            <div class="row equal justify-content-center">
                <div class="col-lg-5 p-0">
                    <div class="utilities-img-container overlay-blu">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/footer1.jpg" class="img-fluid">
                    </div>
                    <div class="utilities-text-container">
                        <span class="utilities-title pb-2 pt-2">Più di 5.000 prodotti in magazzino</span>
                        <span class="utilities-text">Prodotti pronti per essere spediti, tutto in pronta consegna.</span>
                        <div class="pt-2 pt-lg-4"><a href="#" class="button1">Scopri</a></div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-5 p-0">
                    <div class="utilities-img-container overlay-light-blu">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/footer2.jpg" class="img-fluid">
                    </div>
                    <div class="utilities-text-container">
                        <span class="utilities-title pb-2">Non trovi quello che cerchi?</span>
                        <span class="utilities-text">Chiamaci in questi orari e troveremo la soluzione giusta per te</span>
                        <div class="pt-2 pt-lg-4"><a href="#" class="button1">Contattaci</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-3 py-lg-5" id="brands">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <span class="pb-4 title-featured text-center d-block"><?php echo __( 'I Brand più cliccati', 'europarts' ) ?></span>
                </div>
            </div>
            <div class="row equal justify-content-center align-items-center">
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
                <div class="col-lg-3 text-center d-flex align-items-center"><span class="ball"></span></div>
            </div>
        </div>
    </section>



<?php get_footer(); ?>