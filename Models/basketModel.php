<?php

function getBasketProduct() {
	//dd($_SESSION['basket']);
	$basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : '';
    
    if(empty($basket))        return 0;
    
    $ids = array();
    foreach ($basket as $item) {
        $ids[] = $item['id'];
    }
    
    $ids = implode(', ', $ids);
    
    db_connect();
    $db_res = db_query("SELECT * FROM products WHERE id IN ({$ids})");
    db_close();
    
    foreach ($db_res as $keyProduct => $product) {
        $db_res[$keyProduct]['count'] = $basket[$product['id']]['count'];
    }

    return ($db_res);
}

function deleteAllProducts() {
    //dd($_SESSION);
    $_SESSION['basket'] = array();
    addModel('init');
    json_encode(['status' => true, 'price' => getBasketPrice()]);
}

function deleteProduct($id) {
    $id = $_POST['id'];
    unset($_SESSION['basket'][$id]);
    addModel('init');
    die(json_encode(['status' => true, 'price' => getBasketPrice()]));
    //dd($_SESSION['basket'][$id]);
}

function changeCount() {
	$id = (int)$_POST['id'];
	$count = (int)$_POST['count'];

	if (($id <= 0) || ($count <= 0)) {
		die(json_encode(['status' => false, 'error_desc' => 'Переданы неверные параметры']));
	}
	
	$_SESSION['basket'][$id]['count'] = $count;
	addModel('init');
	die(json_encode(['status' => true, 'price' => getBasketPrice()]));

}

function acceptOrder() {
	$time = date("d-m-Y, G:i");
	$phone = intval($_POST['customerPhone_number']);
	$email = htmlspecialchars($_POST['customerEmail'],ENT_QUOTES);
	$name = htmlspecialchars($_POST['customerFIO'],ENT_QUOTES);
	$address = htmlspecialchars($_POST['customerAddress'],ENT_QUOTES);
	$order = getBasketProduct();
	$basket = serialize($order);
	$paid = '0';
	$status = '1';
	addModel('init');
	$price = getBasketPrice();
	$data = array('id' => 'NULL', 'time' => $time, 'phone_number' => $phone, 'email' => $email, 'fio' => $name, 'address' => $address, 'serialize_data' => $basket, 'paid' => $paid, 'status' => $status, 'common_price' => $price);
	//dd($basket);
	insertQuery('orders', $data);
	deleteAllProducts();
}