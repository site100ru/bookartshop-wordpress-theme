            <!-- Корзина WooCommerce с визуалом Tilda -->
            <div class="t706" style="position: fixed; top: 0; right: 0; z-index: 9999;">
                <div class="t706__carticon" style="cursor: pointer;">
                    <div class="t706__carticon-text t-name t-name_xs">
                        = <?php echo WC()->cart ? WC()->cart->get_total() : '0 ₽'; ?>
                    </div>
                    <div class="t706__carticon-wrapper">
                        <div class="t706__carticon-imgwrap">
                            <svg class="t706__carticon-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <path fill="none" stroke-width="2" stroke-miterlimit="10" d="M44 18h10v45H10V18h10z" />
                                <path fill="none" stroke-width="2" stroke-miterlimit="10" d="M22 24V11c0-5.523 4.477-10 10-10s10 4.477 10 10v13" />
                            </svg>
                        </div>
                        <div class="t706__carticon-counter" style="background-color:#fa2d2d; <?php echo WC()->cart && WC()->cart->get_cart_contents_count() > 0 ? '' : 'display:none;'; ?>">
                            <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                        </div>
                    </div>
                </div>

                <div class="t706__cartwin" style="display: none;">
                    <div class="t706__cartwin-close">
                        <div class="t706__cartwin-close-wrapper"> <svg class="t706__cartwin-close-icon" width="23px" height="23px" viewBox="0 0 23 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g stroke="none" stroke-width="1" fill="#fff" fill-rule="evenodd">
                                    <rect transform="translate(11.313708, 11.313708) rotate(-45.000000) translate(-11.313708, -11.313708) " x="10.3137085" y="-3.6862915" width="2" height="30"></rect>
                                    <rect transform="translate(11.313708, 11.313708) rotate(-315.000000) translate(-11.313708, -11.313708) " x="10.3137085" y="-3.6862915" width="2" height="30"></rect>
                                </g>
                            </svg> </div>
                    </div>

                    <div class="t706__cartwin-content">
                        <div class="t706__cartwin-top">
                            <div class="t706__cartwin-heading t-name t-name_xl">Ваш заказ:</div>
                        </div>

                        <div class="t706__cartwin-products">
                            <?php if (WC()->cart && !WC()->cart->is_empty()) : ?>
                                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                                    $product = $cart_item['data'];
                                    $product_id = $cart_item['product_id'];
                                ?>
                                    <div class="t706__product" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                        <div class="t706__product-title t-descr t-descr_sm">
                                            <a style="color: inherit" href="<?php echo get_permalink($product_id); ?>">
                                                <?php echo $product->get_name(); ?>
                                            </a>
                                        </div>
                                        <div class="t706__product-plusminus t-descr t-descr_sm">
                                            <span class="t706__product-minus" data-action="minus">-</span>
                                            <span class="t706__product-quantity"><?php echo $cart_item['quantity']; ?></span>
                                            <span class="t706__product-plus" data-action="plus">+</span>
                                        </div>
                                        <div class="t706__product-amount t-descr t-descr_sm">
                                            <?php echo WC()->cart->get_product_subtotal($product, $cart_item['quantity']); ?>
                                        </div>
                                        <div class="t706__product-del" data-action="remove">×</div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>Корзина пуста</p>
                            <?php endif; ?>
                        </div>

                        <div class="t706__cartwin-bottom">
                            <div class="t706__cartwin-prodamount-wrap t-descr t-descr_sm">
                                <span class="t706__cartwin-prodamount-label">Сумма: </span>
                                <span class="t706__cartwin-prodamount"><?php echo WC()->cart ? WC()->cart->get_total() : '0 ₽'; ?></span>
                            </div>
                        </div>

                        <div class="t706__orderform">
                            <?php if (cart_has_delivery_products()) : ?>
                                <!-- Форма для delivery -->
                                <form id="delivery-checkout-form" style="margin: 20px 0;">
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваше имя</div>
                                        <input class="t-input js-tilda-rule" type="text" name="billing_first_name" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваш Email</div>
                                        <input class="t-input js-tilda-rule" type="email" name="billing_email" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваш телефон</div>
                                        <input class="t-input js-tilda-rule" type="tel" name="billing_phone" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Адрес доставки</div>
                                        <textarea class="t-input js-tilda-rule" name="billing_address" required rows="3"
                                            style="color:#000000; border:1px solid #000000; height:auto; padding:10px;"></textarea>
                                    </div>
                                    <div class="t-form__submit">
                                        <button type="submit" class="t-submit" style="color:#ffffff;background-color:#000000; border:none; width:100%; cursor:pointer; padding:15px;">
                                            Отправить заявку
                                        </button>
                                    </div>
                                </form>
                            <?php else : ?>
                                <!-- Обычная форма для Робокассы -->
                                <form id="quick-checkout-form" style="margin: 20px 0;">
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваше имя</div>
                                        <input class="t-input js-tilda-rule" type="text" name="billing_first_name" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваш Email</div>
                                        <input class="t-input js-tilda-rule" type="email" name="billing_email" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <div class="t-input-title t-descr t-descr_md">Ваш телефон</div>
                                        <input class="t-input js-tilda-rule" type="tel" name="billing_phone" required
                                            style="color:#000000; border:1px solid #000000;">
                                    </div>
                                    <div class="t-form__submit">
                                        <button type="submit" class="t-submit" style="color:#ffffff;background-color:#000000; border:none; width:100%; cursor:pointer; padding:15px;">
                                            Оформить заказ
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .t706 .t-descr_md {
                    font-size: 16px;
                }

                .t706 .t-input {
                    height: 56px;
                }
            </style>

            <script>
                jQuery(document).ready(function($) {
                // Перехватываем клик на кнопку "Купить"
                $(document).on('click', '.ajax_add_to_cart', function(e) {
                    e.preventDefault();
                    
                    var $button = $(this);
                    var href = $button.attr('href'); // например ?add-to-cart=885
                    
                    // Показываем что идет загрузка
                    $button.text('Добавляем...');
                    
                    // Переходим на страницу добавления с нашим параметром
                    window.location.href = href + '&open_cart=1';
                });
                
                // Проверяем нужно ли открыть корзину после загрузки
                if (window.location.search.indexOf('open_cart=1') !== -1) {
                    setTimeout(function() {
                        $('.t706__cartwin').fadeIn(300);
                    }, 100);
                    
                    // Убираем параметры из URL без перезагрузки
                    if (history.replaceState) {
                        history.replaceState({}, '', window.location.pathname);
                    }
                }
            });
                
                jQuery(document).ready(function($) {
                    // Показываем иконку если есть товары
                    <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                        $('.t706__carticon').addClass('t706__carticon_showed').fadeIn();
                        $('.t706__carticon-text').show();
                    <?php endif; ?>

                    // После добавления товара в корзину
                    $(document.body).on('added_to_cart', function() {
                        location.reload(); // Перезагрузка для обновления корзины
                    });
                });
            </script>

            <script>
            jQuery(document).ready(function($) {
                var isUpdating = false;
                
                $('.t706__carticon').on('click', function() {
                    $('.t706__cartwin').fadeToggle(300);
                });
                
                $('.t706__cartwin-close').on('click', function() {
                    $('.t706__cartwin').fadeOut(300);
                });
                
                // Плюс/минус/удаление
                $(document).on('click', '.t706__product-minus, .t706__product-plus, .t706__product-del', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (isUpdating) return;
                    isUpdating = true;
                    
                    var $product = $(this).closest('.t706__product');
                    var cartKey = $product.data('cart-key');
                    var currentQty = parseInt($product.find('.t706__product-quantity').text());
                    var newQty = currentQty;
                    
                    if ($(this).hasClass('t706__product-plus')) {
                        newQty = currentQty + 1;
                    } else if ($(this).hasClass('t706__product-minus')) {
                        newQty = Math.max(1, currentQty - 1);
                    } else if ($(this).hasClass('t706__product-del')) {
                        newQty = 0;
                    }
                    
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'update_cart_item',
                            cart_item_key: cartKey,
                            quantity: newQty
                        },
                        success: function(response) {
                            if (response.success) {
                                if (newQty === 0) {
                                    $product.fadeOut(300, function() { $(this).remove(); });
                                } else {
                                    $product.find('.t706__product-quantity').text(newQty);
                                    // Обновляем сумму товара
                                    var price = parseFloat(response.data.item_total);
                                    $product.find('.t706__product-amount').html(response.data.item_total_html);
                                }
                                // Обновляем общую сумму
                                $('.t706__carticon-text').html('= ' + response.data.cart_total);
                                $('.t706__cartwin-prodamount').html(response.data.cart_total);
                                $('.t706__carticon-counter').text(response.data.cart_count);
                                
                                if (response.data.cart_count === 0) {
                                    $('.t706__carticon').removeClass('t706__carticon_showed').fadeOut();
                                    $('.t706__cartwin-products').html('<p>Корзина пуста</p>');
                                }
                            }
                            isUpdating = false;
                        },
                        error: function() {
                            isUpdating = false;
                        }
                    });
                });
                
                $(document.body).on('added_to_cart', function() {
                    location.reload();
                });
                
                <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                    $('.t706__carticon').addClass('t706__carticon_showed').fadeIn();
                    $('.t706__carticon-text').show();
                <?php endif; ?>
                
                $('#quick-checkout-form').on('submit', function(e) {
                    e.preventDefault();
                    var $btn = $(this).find('.t-submit');
                    $btn.prop('disabled', true).text('Создаём заказ...');
                    
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: $(this).serialize() + '&action=quick_checkout',
                        success: function(response) {
                            if (response.success && response.data.redirect) {
                                window.location.href = response.data.redirect;
                            }
                        }
                    });
                });
            });

            // Обработчик для delivery формы
            $('#delivery-checkout-form').on('submit', function(e) {
                e.preventDefault();
                var $btn = $(this).find('.t-submit');
                $btn.prop('disabled', true).text('Отправляем...');
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: $(this).serialize() + '&action=delivery_checkout',
                    success: function(response) {
                        if (response.success) {
                            $btn.text('Отправлено!');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    }
                });
            });
            </script>
			
			
			<!--footer-->
			<div id="t-footer" class="t-records" data-hook="blocks-collection-content-node" data-tilda-project-id="849445" data-tilda-page-id="5446529" data-tilda-formskey="c321776b1b2260fcaea9c7ac132877c5" >
				<div id="rec97847894" class="r t-rec t-rec_pt_45 t-rec_pb_30" style="padding-top:45px;padding-bottom:30px;background-color:#1c1c1c; " data-record-type="573" data-bg-color="#1c1c1c">
					<!-- t573-->
					<div class="t573">
						<div class="t-container">
							<div class="t-col t-col_6 t-prefix_3 t-align_center">
								<div class="t573__contacts t-title t-title_sm" style="" field="text">
									<div style="color:#ffffff;" data-customstyle="yes">+7 926 222 9186<br />
										<a href="mailto:book_ted@mail.ru" style="color:#ffffff !important;text-decoration: none;border-bottom: 0px solid;box-shadow: inset 0px -0px 0px 0px;-webkit-box-shadow: inset 0px -0px 0px 0px;-moz-box-shadow: inset 0px -0px 0px 0px;">book_ted@mail.ru</a>
									</div>
								</div>
								<div class="t573__address t-text t-text_sm" style="" field="text2"><div style="color:#ffffff;" data-customstyle="yes">Москва, ул. Тверская, 23</div></div>
								<div class="t-sociallinks">
									<div class="t-sociallinks__wrapper">
										<div class="t-sociallinks__item">
											<a href="https://www.facebook.com/groups/theatreandhisdiary/?ref=bookmarks" target="_blank"> <svg class="t-sociallinks__svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve"><desc>Facebook</desc><path style="fill:#ffffff;" d="M47.761,24c0,13.121-10.638,23.76-23.758,23.76C10.877,47.76,0.239,37.121,0.239,24c0-13.124,10.638-23.76,23.764-23.76C37.123,0.24,47.761,10.876,47.761,24 M20.033,38.85H26.2V24.01h4.163l0.539-5.242H26.2v-3.083c0-1.156,0.769-1.427,1.308-1.427h3.318V9.168L26.258,9.15c-5.072,0-6.225,3.796-6.225,6.224v3.394H17.1v5.242h2.933V38.85z"/></svg></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/footer-->
		</div><!--/allrecords-->
		
		<!-- Stat -->
		<!-- Yandex.Metrika counter 53084590 -->
		<script type="text/javascript" >
			(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); window.mainMetrikaId = 53084590; ym(window.mainMetrikaId , "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true,ecommerce:"dataLayer" });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/53084590" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		
		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');	ga('create', 'UA-137489108-1', 'auto');	ga('send', 'pageview');	window.mainTracker = 'user';	if (! window.mainTracker) { window.mainTracker = 'tilda'; }	(function (d, w, k, o, g) { var n=d.getElementsByTagName(o)[0],s=d.createElement(o),f=function(){n.parentNode.insertBefore(s,n);}; s.type = "text/javascript"; s.async = true; s.key = k; s.id = "tildastatscript";
			s.src=g;
			if (w.opera=="[object Opera]") {d.addEventListener("DOMContentLoaded", f, false);} else { f(); } })(document, window, 'bf780b5d5dfe599fa8ef0b82e82badad','script','https://stat.tildacdn.com/js/tildastat-0.2.min.js');
		</script>
		
		<!-- FB Pixel code (noscript) -->
		<noscript>
			<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=318088142244970&ev=PageView&agent=pltilda&noscript=1"/>
		</noscript>
		<!-- End FB Pixel code (noscript) -->
	</body>
</html>