<?php
function index() {
    addModel('basket');
    addModel('init');
    $data = array(
        'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
        'basketProduct' => getBasketProduct(),
    );
    /*dd($data['basketProduct']);*/
    view('basket', 'index.html', $data);
}

function delete_all_products() {
    
    addModel('basket');
    deleteAllProducts();
}

function delete_product() {
    addModel('basket');
   /* die('sd');*/
    deleteProduct($id);
}

function change_count() {
	addModel('basket');
	changeCount();
}

function accept_order() {
	addModel('basket');
	acceptOrder();
    addModel('init');
    view('basket', 'thanks.html', getBasketPrice());
}