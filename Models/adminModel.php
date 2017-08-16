<?php

function getAllCategories() {
    return selectQuery(array('*'), ' categories');
    /*dd($s);*/
}

function getOrders($status) {
    return selectQuery(array('*'), ' orders', 'status = "' . $status . '"');
}

function getOrderInfo($id) {
	return selectQuery(array('*'),'orders', 'id = '.$id);
}

function moveRejected() {
	$id = $_POST['id'];
	$data = array('status' => 3);
	return updateQuery('orders', $data, 'id = '.$id);
}

function moveDone() {
	$id = $_POST['id'];
	$data = array('status' => 2);
	return updateQuery('orders', $data, 'id = '.$id);
}

function deleteOrder() {
	$id = $_POST['id'];
	$data = array('status' => 5);
	return updateQuery('orders', $data, 'id = '.$id);
}

function archiveOrder() {
	$id = $_POST['id'];
	$data = array('status' => 4);
	return updateQuery('orders', $data, 'id = '.$id);
}

function changePaidStatus() {
	$id = $_POST['id'];
	$data = array('paid' => 1);
	return updateQuery('orders', $data, 'id = '.$id);
}

function changeCategoryName() {
	$name = $_POST['newName'];
	$id = $_POST['id'];
	$data = array('name' => $name);

	return updateQuery('categories', $data, 'id = '.$id);
}

function deleteCategory() {
	$id = $_POST['id'];
	//dd($id);
	deleteQuery('categories', 'id = '.$id);
	//$pics = PATH_TO_DELETE;
	//$imgs_src = selectQuery(array('img_src'), 'products', 'category_id = '.$id);
	//dd($imgs_src);
	deleteQuery('products', 'category_id = '.$id );
}

function hideCategory() {
	$id = $_POST['id'];
	//$display = '0';
	$data = array('display' => 0);
	return updateQuery('categories', $data, 'id = '.$id);
}

function showCategory() {
	$id = $_POST['id'];
	//$display = '0';
	$data = array('display' => 1);
	return updateQuery('categories', $data, 'id = '.$id);
}

function getProductsFromCat($idCategory = null){
	if ($idCategory) {
		return selectQuery(array('*'), 'products', 'category_id ='.$idCategory);
	}
	else return selectQuery(array('*'), 'products');
}

function getIdFromUrlCat($url) {
	//dd($url);
	$idCategory = selectQuery(array('id'), ' categories', 'url = "'.$url.'"');
	//dd($idCategory[0]['id']);
	return $idCategory[0]['id'];
}

function addProduct() {
	$name = $_POST['title'];
	$description = $_POST['description'];
	$categoryId = $_POST['categoryId'];
	$price = $_POST['price'];
	$image = $_FILES['file']['tmp_name'];

	$type = exif_imagetype($image);
	//dd($type);
	if(in_array($type, array(1,2,3))){
		if($type = 1) $picName = md5($image) . '.gif';
		if($type = 2) $picName = md5($image) . '.jpg';
		if($type = 3) $picName = md5($image) . '.png';
		move_uploaded_file($image, PATH_TO_SAVE . DIRECTORY_SEPARATOR . $picName );
	}

	if ($_POST['display'] == 'on') {
		$display = '1';
	}
	else $display = '0';

	if ($_POST['on_main'] == 'on') {
		$onMain = '1';
	}
	else $onMain = '0';
	$data = array('id' => 'NULL', 'title' => $name, 'img_src' => '/images/' . $picName, 'price' => $price, 'description' => $description, 'category_id' => $categoryId, 'on_main' => $onMain, 'display' => $display);
	insertQuery('products', $data);
	//echo 'Продукт успешно добавлен в БД';
	//dd($image);
    header("Location: /admin/products/");
}

function deleteProduct() {
	$id = $_POST['iD'];
	//dd($id);
	$pic = PATH_TO_DELETE;
	$img_src = selectQuery(array('img_src'), 'products', 'id = '.$id);
	//dd($pic);
	$pic .= $img_src[0]["img_src"];
	//dd($pic);
	unlink($pic);
	return deleteQuery('products', 'id = '.$id);
	//dd($id);
}

function hideProduct() {
	$id = $_POST['id'];
	$data = array('display' => 0);
	return updateQuery('products', $data, 'id = '.$id);
}

function showProduct() {
	$id = $_POST['id'];
	$data = array('display' => 1);
	return updateQuery('products', $data, 'id = '.$id);
}

function hideProductOnMain() {
	$id = $_POST['id'];
	$data = array('on_main' => 0);
	return updateQuery('products', $data, 'id = '.$id);
}

function showProductOnMain() {
	$id = $_POST['id'];
	$data = array('on_main' => 1);
	return updateQuery('products', $data, 'id = '.$id);
}

function getProductInfo($id) {
	return selectQuery(array('*'),'products', 'id = '.$id);
}

function getCategoryNameById($category_id) {
	$name = selectQuery(array('name'), 'categories', 'id = '.$category_id);
	return $name[0]['name'];
}

function productChange() {
	$id = $_POST['id'];
	$name = $_POST['title'];
	$description = $_POST['description'];
	$categoryId = $_POST['categoryId'];
	$price = $_POST['price'];
	$image = $_FILES['file']['tmp_name'];
	$type = exif_imagetype($image);
	//dd($type);
	if(in_array($type, array(1,2,3))){
		if($type = 1) $picName = md5($image) . '.gif';
		if($type = 2) $picName = md5($image) . '.jpg';
		if($type = 3) $picName = md5($image) . '.png';
		move_uploaded_file($image, PATH_TO_SAVE . DIRECTORY_SEPARATOR . $picName );
	}

	if ($_POST['display'] == 'on') {
		$display = '1';
	}
	else $display = '0';

	if ($_POST['on_main'] == 'on') {
		$onMain = '1';
	}
	else $onMain = '0';
	$data = array('id' => $id, 'title' => $name, 'img_src' => '/images/' . $picName, 'price' => $price, 'description' => $description, 'category_id' => $categoryId, 'on_main' => $onMain, 'display' => $display);
	//dd($data);
	updateQuery('products', $data, 'id = '.$id);
	header("refresh: 0; url=http://shop.loc/admin/products/");
}