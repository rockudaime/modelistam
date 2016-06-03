<?if (is_array($arResult['CART']) AND $arResult['CART']):?>
    <table class="order-block__cart-table" width="100%">
        <?/*
        <tr>
            <th class="order_cart_items_header">Товар</th>
            <th class="order_cart_items_header">Цена</th>
            <th class="order_cart_items_header">Кол-во</th>
            <th class="order_cart_items_header">Сумма</th>
        </tr>
        */?>
    <?$i=0;?>
    <?foreach ($arResult['CART'] as $cart_item):?>
            <?
        //VTL-5
        $image = $arResult['ITEMS'][$cart_item['PRODUCT_ID']]['DETAIL_PICTURE'];

        // Проверка на SKU
        if ($arResult['ITEMS'][$cart_item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']) {
            $parent_id = $arResult['ITEMS'][$cart_item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE'];
            $image = $arResult['ITEMS'][$parent_id]['DETAIL_PICTURE'];
        }
        //VTL-5
        ?>
        <?$i++;?>
        <tr>
            <td><img src="<?=MakeImage($image, array('wl'=>180, 'hl'=>140, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" alt=""> it's an image</td>
            <td class="order_cart_items_line<?=$i%2?> order_cart_items_line--name"><a href="<?=$cart_item['DETAIL_PAGE_URL']?>"><?=$cart_item['NAME']?></a></td>
            <td class="order_cart_items_line<?=$i%2?> order_cart_items_line--price" align="center"><?=price($cart_item['PRICE'], $cart_item['CURRENCY'])?></td>
            <td class="order_cart_items_line<?=$i%2?> order_cart_items_line--total-quantity" align="center"><?=format_qty($cart_item['QUANTITY'])?> шт.</td>
            <td class="order_cart_items_line<?=$i%2?> order_cart_items_line--total-price" align="center"><?=price($cart_item['PRICE']*$cart_item['QUANTITY'], $cart_item['CURRENCY'])?></td>
        </tr>
    <?endforeach;?>
    </table>
<?endif;?>
