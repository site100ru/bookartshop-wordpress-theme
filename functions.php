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

add_theme_support('woocommerce');

add_action('wp_ajax_update_cart_item', 'update_cart_item_ajax');
add_action('wp_ajax_nopriv_update_cart_item', 'update_cart_item_ajax');

function update_cart_item_ajax() {
    if (!defined('WOOCOMMERCE_CART')) {
        define('WOOCOMMERCE_CART', true);
    }
    
    WC()->frontend_includes();
    if (is_null(WC()->cart)) {
        wc_load_cart();
    }
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity <= 0) {
        WC()->cart->remove_cart_item($cart_item_key);
    } else {
        WC()->cart->set_quantity($cart_item_key, $quantity, true);
    }
    
    WC()->cart->calculate_totals();
    
    // Получаем обновленные данные
    $cart_item = WC()->cart->get_cart_item($cart_item_key);
    $item_total_html = '';
    
    if ($cart_item) {
        $item_total_html = WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']);
    }
    
    wp_send_json_success(array(
        'cart_total' => WC()->cart->get_total(),
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'item_total_html' => $item_total_html
    ));
}

add_action('wp_ajax_quick_checkout', 'quick_checkout_ajax');
add_action('wp_ajax_nopriv_quick_checkout', 'quick_checkout_ajax');

function quick_checkout_ajax() {
    $order = wc_create_order();
    
    foreach (WC()->cart->get_cart() as $cart_item) {
        $order->add_product($cart_item['data'], $cart_item['quantity']);
    }
    
    $order->set_address(array(
        'first_name' => sanitize_text_field($_POST['billing_first_name']),
        'email' => sanitize_email($_POST['billing_email']),
        'phone' => sanitize_text_field($_POST['billing_phone']),
    ), 'billing');
    
    $order->set_payment_method('robokassa');
    $order->calculate_totals();
    $order->save();
    
    WC()->cart->empty_cart();
    
    // Получаем gateway Robokassa и генерируем прямую ссылку на оплату
    $gateways = WC()->payment_gateways->get_available_payment_gateways();
    if (isset($gateways['robokassa'])) {
        $robokassa = $gateways['robokassa'];
        $payment_url = $robokassa->process_payment($order->get_id());
        
        if (isset($payment_url['redirect'])) {
            wp_send_json_success(array('redirect' => $payment_url['redirect']));
            return;
        }
    }
    
    // Если не получилось - стандартная страница
    wp_send_json_success(array('redirect' => $order->get_checkout_payment_url()));
}
add_action('wp_footer', 'auto_submit_robokassa_payment');
function auto_submit_robokassa_payment() {
    if (is_wc_endpoint_url('order-pay') && isset($_GET['auto_submit'])) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            setTimeout(function() {
                $('#place_order').click();
            }, 1000);
        });
        </script>
        <?php
    }
}
function custom_add_to_cart_text( $text ) {
    return 'Купить';
}
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_add_to_cart_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_add_to_cart_text' );



// Отправка письма администратору при успешной оплате
add_action('woocommerce_order_status_processing', 'send_admin_email_on_payment', 10, 1);
add_action('woocommerce_order_status_completed', 'send_admin_email_on_payment', 10, 1);

function send_admin_email_on_payment($order_id) {
    $order = wc_get_order($order_id);
    
    if ($order->get_meta('_admin_email_sent')) {
        return;
    }
    
    $admin_emails = array(
        'vasilyev-r@mail.ru',
        'sidorov-vv3@mail.ru'
    );
    
    $subject = '=?utf-8?B?' . base64_encode('Новый оплаченный заказ #' . $order->get_order_number()) . '?=';
    
    $message = "Получен новый оплаченный заказ!\n\n";
    $message .= "Номер заказа: #" . $order->get_order_number() . "\n";
    $message .= "Дата: " . $order->get_date_created()->format('d.m.Y H:i') . "\n";
    $message .= "Сумма: " . strip_tags($order->get_formatted_order_total()) . "\n\n";
    
    $message .= "КЛИЕНТ:\n";
    $message .= "Имя: " . $order->get_billing_first_name() . "\n";
    $message .= "Email: " . $order->get_billing_email() . "\n";
    $message .= "Телефон: " . $order->get_billing_phone() . "\n\n";
    
    $message .= "ТОВАРЫ:\n";
    foreach ($order->get_items() as $item) {
        $message .= "- " . $item->get_name() . " x" . $item->get_quantity() . " = " . strip_tags($order->get_formatted_line_subtotal($item)) . "\n";
    }
    
    $message .= "\nИТОГО: " . strip_tags($order->get_formatted_order_total()) . "\n\n";
    $message .= "Ссылка на заказ: " . admin_url('post.php?post=' . $order_id . '&action=edit') . "\n";
    
    foreach ($admin_emails as $email) {
        mail($email, $subject, $message);
    }
    
    $order->update_meta_data('_admin_email_sent', 'yes');
    $order->save();
}


add_filter('woocommerce_product_add_to_cart_text', 'change_button_for_category', 99);
add_filter('woocommerce_product_single_add_to_cart_text', 'change_button_for_category', 99);

function change_button_for_category($text) {
    global $product;
    
    if (!$product) return $text;
    
    // Получаем все категории товара
    $terms = get_the_terms($product->get_id(), 'product_cat');
    
    if ($terms) {
        foreach ($terms as $term) {
            if ($term->slug == 'delivery') {
                return 'Выставить счёт';
            }
        }
    }
    
    return $text;
}

?>


