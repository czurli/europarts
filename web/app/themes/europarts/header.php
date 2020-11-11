<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head() ?>
    <link href="<?php echo get_template_directory_uri() ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/vendor/slick/slick.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo get_template_directory_uri() ?>/vendor/slick/slick-theme.css">
    <link href="<?php echo get_template_directory_uri() ?>/assets/css/europarts.css" rel="stylesheet">


</head>
<body <?php body_class(); ?>>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 py-1 text-center text-white payoff">Sconto del 5% sul primo ordine</div>
        </div>
    </div>
</section>
<header>
    <div class="container-fluid bg-white" data-toggle="sticky-onscroll">
        <div class="row align-items-center py-2">
            <div class="col col-lg-4 text-center text-lg-left py-2">
                <a href="<?php echo get_home_url()?>"><img src="<?php echo get_template_directory_uri() ?>/assets/images/europarts-logo.png"
                                class="logo img-fluid"></a>
            </div>
            <div class="d-none d-lg-block col-lg-4">
                <div id="ricerca"><?php echo do_shortcode('[wcas-search-form]'); ?></div>
            </div>
            <div class="col col-lg-4 icons text-right py-2">
                <ul>
                    <li class="px-2">
                        <a href="#" class="cart-contents">
                            <?php
                            if (WC()->cart->get_cart_contents_count() > 0) {
                                ?>
                                <span class="cart-contents-count">  <?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <?php
                            }
                            ?>
                        </a>
                        <a href="<?php echo wc_get_cart_url() ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/images/shopping-cart.png">
                    </li>
                    <li class="px-2"><a href=""><img
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/heart.png"></a></li>
                    <li class="px-2"><a href=""><img
                                    src="<?php echo get_template_directory_uri() ?>/assets/images/user.png"></a></li>
                </ul>
            </div>
        </div>

        <div class="row py-2 py-lg-0">
            <div class="col p-0"><?php wp_nav_menu(array('theme_location' => 'main-navigation')); ?></div>
        </div>
    </div>
</header>
