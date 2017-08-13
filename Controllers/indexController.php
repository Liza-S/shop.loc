<?php


function index() {
    addModel('init');
    $data = array(
        'title' => 'Главная',
        'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
        'products' => getProductsOnMain(),
    );
    //dd($data);
    view('index', 'index.html', $data);
}

