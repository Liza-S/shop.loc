<?php

function orders_new() {
    addModel('admin');
    $data = array('orders' => getNewOrders());
    //dd($data);
    adminView('admin', 'orders.html', $data);
}

function auth() {
    if(!empty($_POST['login']) && !empty($_POST['pass'])){

        $uName = $_POST['login'];
        $uPass = $_POST['pass'];
      
        include_once 'admin_setting.php';

        // Обработка формы
        foreach ($admins as $admin) {

            if($admin['login'] == $uName && $admin['pass'] == $uPass) {
                $_SESSION['login'] = $uName;
                $_SESSION['pass'] = $uPass;
                orders_new();
                //adminView('admin', 'orders.html');
                //header("Location:" . '/admin/orders.html');
                exit;
            }

        }
    }
    adminView('admin', 'auth.html');
}

function orders_done() {
    addModel('admin');
    $data = array('orders' => getDoneOrders());
    //dd($data);
    adminView('admin', 'orders.html', $data);
}

function orders_rejected() {
    addModel('admin');
    $data = array('orders' => getRejectedOrders());
    //dd($data);
    adminView('admin', 'orders.html', $data);
}

function move_rejected() {
    addModel('admin');
    moveRejected();
}

function move_done() {
    addModel('admin');
    moveDone();
}

function move_deleted() {
    addModel('admin');
    deleteOrder();
}

function move_archived() {
    addModel('admin');
    archiveOrder();
}

function orders_archive() {
    addModel('admin');
    $data = array('orders' => getArchiveOrders());
    //dd($data);
    adminView('admin', 'orders.html', $data);
}

function order_detail($params) {
    addModel('admin');
    $data = getOrderInfo($params);
    $data = $data[0];
    //dd($data);
    //$data['category_name'] = getCategoryNameById($data['category_id']);
    adminView('admin', 'order.html', $data);
}

function paid() {
    addModel('admin');
    changePaidStatus();
}

function logout() {
	//session_start();
	$_SESSION = array();
	session_destroy();
	//dd($_SESSION);
	adminView('admin', 'auth.html');
}

function category() {
    //die('ggg');
    addModel('admin');
    $data = array('categories' => getAllCategories(), );
    //dd($data['categories']);
    adminView('admin', 'category.html', $data);
}

function category_add() {
	//var_dump($_POST);
	/*код добавления новой категории в БД*/
	$name = $_POST['name'];
	//$name = strval($name);
	$url = $_POST['url'];
	//$url = strval($name);

	if ($_POST['display'] == 'on') {
		$display = '1';
	}
	else $display = '0';

	$data = array('id' => 'NULL', 'name' => $name, 'url' =>  $url , 'display' =>$display);
	insertQuery('categories', $data);
	//echo 'Категория успешно добавлена в БД';
    header("refresh: 0; url=http://shop.loc/admin/category/");
}

function change_category_name () {
    addModel('admin');
    changeCategoryName();
}

function delete_category() {
    addModel('admin');
    deleteCategory();
}

function hide_category() {
    addModel('admin');
    hideCategory();
}

function show_category() {
    addModel('admin');
    showCategory();
}

function products($params) {
    addModel('admin');

    if($params) {
        $id =  getIdFromUrlCat($params);
        $data['products'] = getProductsFromCat($id);
        //dd($data['products']);
    }
    else if (empty($params)) {
        $data['products'] = getProductsFromCat();
    }

    $data['categories'] = getAllCategories();

    adminView('admin', 'products.html', $data);
}

function product_add() {
    addModel('admin');
    addProduct();
}

function delete_product() {
    addModel('admin');
    deleteProduct();
    
}

function hide_product() {
    addModel('admin');
    hideProduct();
}

function show_product() {
    dd($_POST);
    addModel('admin');
    showProduct();
}

function hide_main_product() {
    addModel('admin');
    hideProductOnMain();
}

function show_main_product() {
    addModel('admin');
    showProductOnMain();
}

function product_detail($params) {
    addModel('admin');
    $data = getProductInfo($params);
    $data = $data[0];
    $data['category_name'] = getCategoryNameById($data['category_id']);
    adminView('admin', 'productDetail.html', $data);
}

function product_edit($params) {
    addModel('admin');
    $data = getProductInfo($params);
    $data = $data[0];
    $data['category_name'] = getCategoryNameById($data['category_id']);
    $data['categories'] = getAllCategories();
    /*dd($data);*/
    adminView('admin', 'productEdit.html', $data);
}

function product_change() {
    addModel('admin');
    productChange();
}