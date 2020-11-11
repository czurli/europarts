<?php
add_theme_support('post-thumbnails');

function register_my_menus()
{
	register_nav_menus(
		array(
			'main-navigation' => __('Main Navigation'),
		)
	);
}

add_action('init', 'register_my_menus');

function widgets_init()
{
	register_sidebar(array(
		'name' => __('Primary Sidebar', 'europarts'),
		'id' => 'primary',
		'before_widget' => '<div class="%2$s col pb-3">',
		'after_widget' => '</div>',
		'before_title' => '<p class="mb-1">',
		'after_title' => '</p>',
	));
	register_sidebar(array(
		'name' => __('Top Sidebar', 'europarts'),
		'id' => 'top-sidebar',
		'description' => __('', 'europarts'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Newsletter', 'europarts'),
		'id' => 'newsletter',
		'description' => __('', 'europarts'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
    register_sidebar(array(
        'name' => __('Shop Categorie', 'europarts'),
        'id' => 'shop-categorie',
        'description' => __('', 'europarts'),
        'before_widget' => '<div class="shop-widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Shop Filtri', 'europarts'),
        'id' => 'shop-filtri',
        'description' => __('', 'europarts'),
        'before_widget' => '<div class="shop-widgets">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'widgets_init');

require 'inc/woocommerce-functions.php';

