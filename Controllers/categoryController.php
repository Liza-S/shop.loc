<?php

function index($params) {
	addModel('init');
	$id =  getIdFromUrlCat($params);
    $data = array(
        //'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
        'products' => getProductsFromCat($id),
        );
	view('index', 'index.html', $data);

}