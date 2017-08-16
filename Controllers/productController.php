<?php

function index($params) {
    addModel('init');
    $data = array(
        'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
        'product' => getProductInfo($params),
    );
    //dd($data);
    if(!$data['product'] or $data['product'][0]['display'] == 0){
        header('Location: /404/');
        die();
    }
    view('product', 'index.html', $data);
}

function add_to_basket() {

	// обработка входящих данных
	$id = $_POST['id'];
	$price = $_POST['basketPrice'];
	$id = (int)$id;
	if ($id == 0) {
		die(json_encode(['status' => false, 'error_desc' => 'Ошибка входящих данных']));
	}

	addModel('init');
	addToBasket($id);
	
	/*$basketPrice = getBasketPrice();
	dd($basketPrice);

	die(json_encode(['price' => getBasketPrice()]));*/
	/*dd($data['price']);*/
	/*json_encode($basketPrice);*/
	/*dd($basketPrice);*/
}