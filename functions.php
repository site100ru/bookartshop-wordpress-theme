<?php
	
	add_theme_support( 'post-thumbnails' );
	
	add_post_type_support( 'post', 'custom-fields' );
	
	/*** Adding WooCommerce support ***/
	add_action( 'after_setup_theme', 'wp_template_add_woocommerce_support' );
	function wp_template_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	
	
	/* Disable auto-add tags in the post */
	remove_filter( 'the_content', 'wpautop' );
	
	/* Disable auto-tagging in the announcement */
	remove_filter( 'the_excerpt', 'wpautop' );
	
	/* Remove the <p> tag from images */
	add_filter( 'the_content', 'img_unautop', 30 );
	function img_unautop($pee) {
		$pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
		return $pee;
	}
	
	
	/*** Включение редактора Gutenberg для товаров ***/
	add_filter( 'use_block_editor_for_post_type', 'art_enable_rest_for_product', 10, 2 );
	add_filter( 'woocommerce_taxonomy_args_product_cat', 'art_show_in_rest_for_product', 10, 1 );
	add_filter( 'woocommerce_taxonomy_args_product_tag', 'art_show_in_rest_for_product', 10, 1 );
	add_filter( 'woocommerce_register_post_type_product', 'art_show_in_rest_for_product', 10, 1 );

	/**
	 * Включение редактора Gutenberg для товаров
	 *
	 * @sourcecode https://wpruse.ru/?p=4150
	 *
	 * @param  bool   $can_edit
	 * @param  string $post_type
	 *
	 * @return bool
	 *
	 * @author        Artem Abramovich
	 * @testedwith    WC 3.9
	 */
	function art_enable_rest_for_product( $can_edit, $post_type ) {

		if ( 'product' === $post_type ) {
			$can_edit = true;
		}

		return $can_edit;
	}

	/**
	 * Включение поддержки REST для товаров
	 *
	 * @sourcecode https://wpruse.ru/?p=4150
	 *
	 * @param  array $args
	 *
	 * @return mixed
	 *
	 * @author        Artem Abramovich
	 * @testedwith    WC 3.9
	 */
	function art_show_in_rest_for_product( $args ) {

		$args['show_in_rest'] = true;

		return $args;
	}
	
	// Переопределяем текст на русском
function custom_woocommerce_thankyou_text($translated_text, $text, $domain) {
    // Меняем текст на странице благодарности
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'Thank you. Your order has been received.':
                $translated_text = 'Спасибо. Ваш заказ принят.';
                break;
            case 'Order number:':
                $translated_text = 'Номер заказа:';
                break;
            case 'Date:':
                $translated_text = 'Дата:';
                break;
            case 'Total:':
                $translated_text = 'Итого:';
                break;
            case 'Order details':
                $translated_text = 'Детали заказа';
                break;
            case 'Product':
                $translated_text = 'Товар';
                break;
            case 'Total':
                $translated_text = 'Итого';
                break;
            case 'Subtotal:':
                $translated_text = 'Промежуточный итог:';
                break;
            case 'Order again':
                $translated_text = 'Заказать снова';
                break;
        }
    }
    
    return $translated_text;
}

add_filter('gettext', 'custom_woocommerce_thankyou_text', 20, 3);

?>