<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function createOneClickOrder()
{

}

function getMyCartData($my_cart, $user, $coupon = false)
{
    $summa = 0;
    $summaNotSale = 0;

    if ($my_cart) {
        $count = count($my_cart);
        for ($i = 0; $i < $count; $i++) {
            $shop = $this->shop->getProductById($my_cart[$i]['shop_id']);

            $my_cart[$i]['final_price'] = $my_cart[$i]['original_price'] = $shop['price'];
            if ($shop['discount'] > 0) {
                $my_cart[$i]['final_price'] = getNewPrice($shop['price'], $shop['discount']);
                $my_cart[$i]['discount'] = $shop['discount'];
            } elseif ($coupon) {
                $my_cart[$i]['final_price'] = getNewPrice($shop['price'], $coupon['discount']);
                $my_cart[$i]['discount'] = $coupon['discount'];
            }

            if ($shop) {
                if (isDiscount($shop)) {
                    $akciya = 1;
                }


                $razmer = explode('*', $shop['razmer']);
                $rcount = count($razmer);
                for ($i2 = 0; $i2 < $rcount; $i2++) {
                    if (isset($my_cart[$i]['kolvo_' . $razmer[$i2]])) {
                        //$message_table .= $razmer[$i2].': '.$mc['kolvo_'.$razmer[$i2]].'<br>';
                        $res = getAkciyaPrice($shop) * $my_cart[$i]['kolvo_' . $razmer[$i2]];
                        $summa = $summa + $res;
                        if ($shop['discount'] == 0)
                            $summaNotSale = $summaNotSale + $res;
                    }
                }


            }
            //vd($akciya);
        }
    }
    $nadbavka = 0;
    $kolvo = shop_count();
    if ($kolvo > 0) {
        if ($kolvo < $shop_opt_from) {
            if (isset($user_type['delivery_price']) && $user_type['delivery_price'] != -1)
                $shop_nadbavka = $user_type['delivery_price'];
            else
                $shop_nadbavka = getOption('shop_nadbavka');

            //$shop_nadbavka = $shop_nadbavka * $kolvo;
            //$summa = $summa + $shop_nadbavka;
            //$summaNotSale = $summaNotSale + $shop_nadbavka;
            $nadbavka = $shop_nadbavka;
        }
    }

    $discount = 0;
    if (isset($coupon) && !isset($coupon['err'])) {
        $discount = $coupon['discount'];
        if ($coupon['type'] == 0) {
            if ($coupon['not_sale'] == 1) {
                // высчитываем скидку без учёта товаров из раздела Sale
                $res = $summaNotSale / 100 * $discount;
                // vd($summaNotSale.': '.$res);
                $summa = $summa - $res;
            } else {
                // высчитываем скидку полностью на всю покупку
                $res = $summa / 100 * $discount;
                //  vd("not");
                $summa = $summa - $res;
            }
        } elseif ($coupon['type'] == 1) {
            $summa = $summa - $discount;
        }
    }

    if ($nadbavka)
        $summa = $summa + $nadbavka;

    $full_summa = $summa;

    $currencies = array(
        'UAH' => getCurrencyValue('UAH'),
        'USD' => getCurrencyValue('USD'),
        'RUB' => getCurrencyValue('RUB'),
    );

    $delivery_to_russia_price = false;
    $deliveryPrice = 0;
    if (post('country') != 1) {
        $myCartCount = shop_count();
        $delivery_to_russia_price = (float)getOption('delivery_to_russia_price');
        if ($delivery_to_russia_price > 0) {
            $deliveryPrice = (float)$delivery_to_russia_price * $myCartCount;
            //vd($deliveryPrice);
            $full_summa = $full_summa + $deliveryPrice;
        }

    }

    $result = array();
    $result['summa'] = $summa;
    $result['summaNotSale'] = $summaNotSale;
    $result['nadbavka'] = $nadbavka;
    $result['full_summa']   = $full_summa;
    $result['currencies'] = json_encode($currencies);
    $result['deliveryPrice'] = $deliveryPrice;

    return $result;
}

function createMyCartTable($order, $user, $toAdmin = false, $coupon = false){
     $message_table = '<table class="products" border="1" style="width: 100%; style="width: 100%; border-top:1px solid #c2c2c2;">
					<th>Товар</th>
					<th>Цвет</th>
					<th>Размер:Кол-во</th>
					<th>Цена за шт.</th>
					<th>Общая стоимость</th>';

    $currencyValue = getCurrencyValue(strtoupper($order['currency']));
    $order['inCurrency'] = $currencyValue * $order['summa'];

    $shop_nadbavka = 0;
    $my_cart = unserialize($order['products']);
    $pcount = count($my_cart);
    $full_price = 0;
    $kolvo = 0;
    for ($j = 0; $j < $pcount; $j++) {
        $mc = $my_cart[$j];
        $product = $this->shop->getProductById($mc['shop_id']);
        $cat = $this->model_categories->getCategoryById($product['category_id']);
        $razmer = explode('*', $product['razmer']);
        $rcount = count($razmer);
        $parent = false;
        $price = getAkciyaPrice($product);
        $productSale = false;
        if ($product['discount'] > 0)
            $productSale = true;
        $akciya = isActionTime();


        $price_one = round($price, 2);

        //if($mc['kolvo'] > 1)
        //$price = $price * $mc['kolvo'];
        //var_dump($price);die();
        if ($product['parent_category_id'] != 0) $parent = $this->model_categories->getCategoryById($product['parent_category_id']);
        $message_table .= '<tr><td>
						    <a href="http://' . $_SERVER['SERVER_NAME'] . '/';
        if ($parent) $message_table .= $parent['url'] . '/';
        $message_table .= $cat['url'] . '/' . $product['url'] . '/" target="_blank">' . $product['name'] . '</a> (' . $product['articul'] . ')
						</td>
						<td align="center">' . $product['color'] . '</td>
						<td align="center">';

        $pres = 0;
        for ($i2 = 0; $i2 < $rcount; $i2++) {
            if (isset($mc['kolvo_' . $razmer[$i2]]) && $mc['kolvo_' . $razmer[$i2]] != '0') {
                $message_table .= $razmer[$i2] . ': ' . $mc['kolvo_' . $razmer[$i2]] . '<br>';
                $res = $price * $mc['kolvo_' . $razmer[$i2]];
                $pres += $res;
                $kolvo += $mc['kolvo_' . $razmer[$i2]];
            }
        }
        $full_price += $pres;
        if (isset($full_price_discount) && $full_price_discount > 0) $full_price = $full_price_discount + $pres;

        $price = round($pres, 2);


        $message_table .= '</td>
						<td align="center">' . get_price($price_one) . ' ' . $order['currency'];
        if($toAdmin) $message_table .= ' (' . $price_one . '$)';
        if ($coupon && $productSale == false) $message_table .= ' (<b>Акция!</b>)';
        elseif ($productSale) $message_table .= ' (<b>Sale</b>)';
        $message_table .= '</td>
						<td align="center">' . get_price($price) . ' ' . $order['currency'] . '(' . $price . '$)</td>
					    </tr>';
    }

    $message_table .= '</table><br />';

    if ($coupon) {
        $message_table .= '<b>Был использован скидочный купон</b>: ' . $coupon['code'];
        $full_price_discount = $full_price;
        if (isset($coupon) && !isset($coupon['err'])) {
            $discount = $coupon['discount'];
            $message_table .= ' (делает скидку ' . $discount;
            if ($coupon['type'] == 0) {
                $res = 0;
                if ($coupon['not_sale'] == 1) {
                    $res = $summaNotSale / 100 * $discount;
                } else {
                    $res = $full_price / 100 * $discount;
                }
                $full_price_discount = $full_price - $res;
                $full_price = $full_price_discount;
                $message_table .= '%';
                if ($coupon['not_sale'] == 1)
                    $message_table .= ' на все товары, кроме раздела Sale';
            } elseif ($coupon['type'] == 1) {
                $full_price_discount = $full_price - $discount;
                $full_price = $full_price_discount;
                $message_table .= ' USD';
            }
            $message_table .= ')<br />';
            if ($coupon['info'] != '') $message_table .= 'Дополнительная информация о купоне: <i>' . $coupon['info'] . '</i><br />';
        }
        unset_userdata('coupon');
    }
    $nadbavka = false;
    $shop_opt_from = getOption('shop_opt_from');

    $kolvo = shop_count();
    if ($kolvo < $shop_opt_from) {
        $shop_nadbavka = 2;
        if (isset($user_type['delivery_price']) && $user_type['delivery_price'] != -1)
            $shop_nadbavka = $user_type['delivery_price'];
        else
            $shop_nadbavka = getOption('shop_nadbavka');


        //$shop_nadbavka = $shop_nadbavka * $kolvo;
        $nadbavka = '<b style="color:red">Розничная надбавка</b>: ' . get_price($shop_nadbavka) . ' ' . $order['currency'];
        if($toAdmin) $nadbavka .=  ' (' . $shop_nadbavka . '$)';
        $nadbavka .= '</b><br />';
    }
    $delivery_price_msg = '';
    $delivery_price = 0;
    if (post('country') != 1) {
        $delivery_to_russia_price = getOption('delivery_to_russia_price');
        $delivery_price = $delivery_to_russia_price * $kolvo;
        $delivery_price_msg = '<b>Стоимость доставки в Вашу страну: ' . get_price($delivery_price) . ' ' . $order['currency'] . '</b>';
        $delivery_price_msg .= '(' . $delivery_price . '$)';
        $delivery_price_msg .= '<br />';
    }

    //var_dump($message_table);die();

    //	var_dump($order['summa']);die();

    $message_table .= '<br />';


    if ($user['user_type_id'] == 11 && $toAdmin)
        $message_table .= '<b>Заказ от дропшиппера</b><br />';

    $shop_sended = getOption('shop_sended');
    $message_table .= $shop_sended;
    $message_table .= 'Фамилия, Имя: ' . $user['lastname'] . ', ' . $user['name'] . '<br />
					e-mail: ' . $user['email'] . '<br />';
    if ($coupon) {
        if (isset($full_price_discount) && $full_price_discount > 0) $full_price = $full_price_discount;
        $message_table .= '<b>Стоимость товаров со скидкой: ' . get_price($full_price_discount) . ' ' . $order['currency'] . ' (' . $full_price_discount . '$)</b><br />';
    } else
        $message_table .= 'Стоимость товаров: ' . get_price($full_price) . ' ' . $order['currency'] . ' (' . $full_price . '$)<br />';

    $message_table .= $nadbavka;
    $message_table .= $delivery_price_msg;
    $message_table .= 'Общее количество товаров: ' . $kolvo . ' <br />';

    $price_sum = $full_price + $shop_nadbavka + $delivery_price;
    $message_table .= '<h2><b>Общая стоимость заказа</b>: ' . get_price($price_sum) . ' ' . $order['currency'] . ' (' . $price_sum . '$)</h2>';

    //if ($order['delivery'] != 'Новая Почта')
    $message_table .= 'Доставка: ' . $order['delivery'] . '<br />';

    if ($npnp) {
        $npnp_price = getOption('npnp_price');
        $message_table .= 'Предоплата наложенного платежа: ' . get_price($npnp_price) . ' ' . $order['currency'] . '<br />';
        $message_table .= 'Остаток наложенного платежа: ' . get_price($full_price - $npnp_price) . ' ' . $order['currency'] . '<br />';
    }

    $message_table .= 'Адрес: ' . $order['adress'] . '<br />
					Оплата: ' . $order['payment'] . '<br />

					Валюта: ' . $order['currency'] . '
					<br />
					Дополительная информация:<br />
					' . $_POST['adding'];

    $message = $message . $message_table;


    //echo $message;die();

    // Обработка купона
    if ($coupon) {
        $coupon['used_date'] = date("Y-m-d H:i");
        $coupon['used_by'] = $user['login'];
        $coupon['order_id'] = $order['id'];
        $this->db->where('id', $coupon['id'])->limit(1)->update('coupons', $coupon);

        if ($coupon['multi'] != 1) {
            $dbins = array(
                'coupon_id' => $coupon['id'],
                'user_login' => $user['login'],
                'date' => date("Y-m-d H:i"),
                'order_id' => $order['id']
            );
            $this->db->insert('coupons_using', $dbins);
        }
    }


}

function getMyCartCount()
{
    $CI = &get_instance();

    $my_cart = array();
    if ($CI->session->userdata('my_cart') !== false)
        $my_cart = $CI->session->userdata('my_cart');

    echo count($my_cart);
}

function set_currency()
{
    if (isset($_GET['currency'])) {
        $CI = &get_instance();
        $CI->session->set_userdata('currency', $_GET['currency']);

        $back = $_SERVER['REQUEST_URI'];
        $pos = strpos($back, '?');
        if ($pos)
            $back = substr($back, 0, $pos);

        redirect($back);
    }
}

function get_price($price, $back = false, $round = 2)
{
    //$CI = & get_instance();

    //   $shop_currencies = getOptionArray('shop_currencies');

    $main_currency = getOption('main_currency');
    $currency = userdata('currency');
    if (!$currency)
        $currency = $main_currency;
    if ($currency) {
        $currency_to = getCurrencyValue($currency);
        if ($currency_to) {
            if (!$back)
                $price = $price * $currency_to;
            else
                $price = $price / $currency_to;
        }

    }
    //var_dump($currency_to);
    return round($price, $round);
}

function getCurrency()
{
    $CI = &get_instance();
    $currency = userdata('currency');
    return ($currency) ?
        $CI->model_currency->getByCode($currency) :
        $CI->model_currency->getMainCurrency();
}

function productToHtml($product, $view = false)
{
    $CI = &get_instance();
    $currency = getCurrency();
    $product['url'] = getFullUrl($product);
    $product = parseFilters($product, true, false, array('id', 'title', 'name', 'show_type', 'classes'), array('id', 'value'));
    if ($view) {
        ?>
        <div class="col-md-12 list-category">
            <div class="media">
                <div class="media-left media-middle">
                    <?php
                    if ($product['image']) {
                        ?>
                        <a href="<?= $product['url'] ?>"><img
                                    src="<?= CreateThumb(268, 268, $product['image'], 'catalog') ?>" width="268"
                                    height="268"/></a>
                        <?php
                    } ?>
                </div>
                <div class="media-body">
                    <h4><a href="<?= $product['url'] ?>"><?= getLangText($product['name']) ?></a></h4>

                    <p><?= getLangText($product['short_content']) ?></p>
                    <table class="iteam-table" border="0" align="center">
                        <tr>
                            <td><?php
                                if ($product['old_price']) {
                                    ?>
                                    <p class="old-price"><?= get_price($product['old_price']) . ' ' . $currency['view'] ?></p>
                                    <?php
                                } else echo '<p class = "old-price"> </p>';
                                ?></td>
                            <td><?= printCompare($product['id']) ?></td>
                        </tr>
                        <tr>
                            <td width="129px">
                                <span class="count-iteam"><?= get_price($product['price']) . '</span> <span class="uah">' . $currency['view'] ?></span>
                            </td>
                            <td>
                                <a class="buy-btn"
                                   href="<?= $product['url'] ?>"><?= $CI->lang->line('catalog_button_buy') ?></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="col-md-3 block-category">
            <?php
            if ($product['image']) {
                ?>
                <a href="<?= $product['url'] ?>"><img width="268" height="268"
                                                      src="<?= CreateThumb(268, 268, $product['image'], 'catalog') ?>"/></a>
                <?php
            } ?>
            <h4><a href="<?= $product['url'] ?>"><?= getLangText($product['name']) ?></a></h4>
            <table class="iteam-table" border="0" width="95%" align="center">
                <tr>
                    <td><?php
                        if ($product['old_price']) {
                            ?>
                            <p class="old-price"><?= get_price($product['old_price']) . ' ' . $currency['view'] ?></p>
                            <?php
                        } else echo '<p class = "old-price"> </p>';
                        ?></td>
                    <td><?= printCompare($product['id']) ?></td>
                </tr>
                <tr>
                    <td width="129px">
                        <span class="count-iteam"><?= get_price($product['price']) . '</span> <span class="uah">' . $currency['view'] ?></span>
                    </td>
                    <td>
                        <a class="buy-btn"
                           href="<?= $product['url'] ?>"><?= $CI->lang->line('catalog_button_buy') ?></a>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }
}

function printCompare($id)
{
    if (userdata('compare') && in_array($id, userdata('compare')))
        echo '<a rel="nofollow" href = "/compare/">В сравнении</a>';
    else
        echo '<a rel="nofollow" href = "/compare/add/' . $id . '/">Сравнить</a>';
}

function createOrder($product = false, $price)
{
    $CI = &get_instance();
    $user = getUserData();
    if (!$product)
        $product = modules_getLastProduct();
    if (!$price) $price = 1;
    $unix = time();
    $description = getLine('Пожертвование') . ' ' . getLine('на сумму') . ' ' . $price;
    $dbins = array(
        'user_id' => $user['id'],
        'login' => $user['login'],
        'products' => json_encode($product),
        'product_id' => $product['id'],
        'unix' => $unix,
        'price' => $price,
        'description' => $description,
        'date' => date("Y-m-d"),
        'time' => date('H:i')
    );

    $CI->db->insert('orders', $dbins);

    $CI->db->where('user_id', $user['id']);
    $CI->db->where('login', $user['login']);
    $CI->db->where('product_id', $product['id']);
    $CI->db->where('unix', $unix);
    $result = $CI->db->get('orders')->result_array();
    if (isset($result[0])) return $result[0];

    return false;
}

function editOrder($id, $dbins)
{
    $CI = &get_instance();
    $CI->db->where('id', $id)->limit(1)->update('orders', $dbins);
}

function getOrder($id)
{
    $order = false;
    $CI = &get_instance();
    $order = $CI->db->where('id', $id)->limit(1)->get('orders')->result_array();
    if (isset($order[0])) return $order[0];

    return false;
}