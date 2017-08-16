<?php

function getPublicCategories() {
    return selectQuery(array('*'), ' categories', ' display = 1');
}

function getBasketPrice() {
	//unset($_SESSION);
//
    //dd($_SESSION);
    $basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : '';
    
    if(empty($basket))        return 0;
    
    $ids = array();
    foreach ($basket as $item) {
        $ids[] = $item['id'];
    }

    $ids = implode(', ', $ids);

    
    db_connect();
    $db_res = db_query("SELECT id, price FROM products WHERE id IN ({$ids})");
            //selectQuery(array('id', 'price'), ' products', " WHERE id IN({$ids})");
    db_close();
    $basketPrice = 0;
    
    foreach ($basket as $k => $item) {
        $db_item_key = array_search($item['id'], array_column($db_res, 'id'));
        if($db_item_key === false) {
            unset($_SESSION['basket'][$k]);
            continue;
        }
        $basketPrice += $db_res[$db_item_key]['price'] * $item['count'];
    }
    
    return round($basketPrice, 2);
    
}

function getProductsOnMain() {
    return selectQuery(array('*'), ' products', ' on_main = 1');
}

function getProductsFromCat($idCategory){
    //dd($idCategory);
    return selectQuery(array('*'), 'products', 'category_id ='.$idCategory.' AND '.'display = 1');
    //else return selectQuery(array('*'), 'products');
}

function getIdFromUrlCat($url) {
    //dd($url);
    $idCategory = selectQuery(array('id'), ' categories', 'url = "'.$url.'"');
    //dd($idCategory[0]['id']);
    return $idCategory[0]['id'];
}

function getProductInfo($id) {
    return selectQuery(array('*'),'products', 'id = '.$id);
    /*dd($d);*/
}

function getSearchRes() {
    $name = htmlspecialchars($_GET['search_str'], ENT_QUOTES);
    return selectQuery(array('*'),"products", "`title` LIKE '%".$name."%' and display = 1");
    /*dd($s);*/
}

function addToBasket($id) {
    
    /*$_SESSION['basket'] = array(
    [4] => array('id', ''),
    [1] =>10,
    [3] => 1
    ); */

    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = array();
    }
    if (isset($_SESSION['basket'][$id]['count'])) {
        $_SESSION['basket'][$id]['count']++;
    } else {
        $_SESSION['basket'][$id] = ['id' => $id,'count'=> 1];
    }

    die(json_encode(['status' => true, 'price' => getBasketPrice()]));

}