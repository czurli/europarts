<?php
defined('ABSPATH') || exit;

get_header();
do_action('woocommerce_before_main_content');

if (is_archive()) {
    ?>
    <h1><?php woocommerce_page_title(); ?></h1>

    <?php
    do_action('woocommerce_archive_description');
    ?>
    <?php

    if (woocommerce_product_loop()) {

        do_action('woocommerce_before_shop_loop');
        ?>

        <div class="clearfix"></div>

        <?php

        woocommerce_product_loop_start();


        if ((is_active_sidebar('shop-filtri') || is_active_sidebar('shop-categorie')) && is_archive()) {
            ?>

            <div class="col-lg-3 order-1 order-lg-1">

                <?php
                do_action('woocommerce_sidebar');
                ?>

            </div>
            <div class="col-lg-9 order-1 order-lg-1 pb-3">
            <div class="container">
            <div class="row products">

            <?php
        }
        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                do_action('woocommerce_shop_loop');

                wc_get_template_part('content-product', 'shop');
            }
        }

        woocommerce_product_loop_end();
        ?>

        </div>
        </div>
        </div>

        <?php
        do_action('woocommerce_after_shop_loop');

    } else {
        do_action('woocommerce_no_products_found');
    }

} else {

    // sono nella pagina del prodotto

    while (have_posts()): the_post();
        wc_get_template_part('content', 'single-product');
    endwhile;
}

do_action('woocommerce_after_main_content');

get_footer();
