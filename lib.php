<?php
$mysqli;
function dd() {
    

    echo '<pre>';
    header('Content-Type: text/html; charset=utf-8');
    
    $args = func_get_args();
    //var_dump($args);die();
    foreach ($args as $arg) {
        var_dump($arg);
    }
    
    echo '</pre>';
    die();
}

function route() {
    $explodeURI = explode('?', $_SERVER['REQUEST_URI']);
    $url = urldecode(trim($explodeURI[0], '/'));
    ///dd($url);
    //$query = trim($url, '/');
    $slices = explode('/', $url);
    $controllerName = '';
    $action = '';
    $params = NULL;
    
    if ($slices[0] == ''){
        $controllerName = 'index';
        $action = 'index';
    }
    elseif ($slices[0] == 'product') {
        $controllerName = 'product';
        $action = 'index';
        $params = (int)$slices[1];

        if(isset($slices[1]) && $slices[1] == 'add_to_basket') {
            $action = 'add_to_basket';
        }
    }
    
    elseif ($slices[0] == 'admin') {

            $controllerName = 'admin';
            $action = 'auth';
            
            if(isset($slices[1]) && $slices[1] == 'logout') {
                $action = 'logout';
            }

            else if(isset($slices[1]) && $slices[1] == 'orders') {
                $action = 'orders';
            }

            else if(isset($slices[1]) && $slices[1] == 'category') {
                $action = 'category';
            }

            else if(isset($slices[1]) && $slices[1] == 'change_category_name') {
                $action = 'change_category_name';
            }

            else if(isset($slices[1]) && $slices[1] == 'delete_category') {
                $action = 'delete_category';
            }

            else if(isset($slices[1]) && $slices[1] == 'hide_category') {
                $action = 'hide_category';
            }

            else if(isset($slices[1]) && $slices[1] == 'show_category') {
                $action = 'show_category';
            }

            else if(isset($slices[1]) && $slices[1] == 'products') {
                $action = 'products';
                $params = $slices[2];
            }

            else if(isset($slices[1]) && $slices[1] == 'product_add') {
                $action = 'product_add';
            }

            else if(isset($slices[1]) && $slices[1] == 'delete_product') {
                $action = 'delete_product';
            }

            else if(isset($slices[1]) && $slices[1] == 'hide_product') {
                $action = 'hide_product';
            }
            
            else if(isset($slices[1]) && $slices[1] == 'show_product') {
                $action = 'show_product';
            }

            else if(isset($slices[1]) && $slices[1] == 'hide_main_product') {
                $action = 'hide_main_product';
            }
            
            else if(isset($slices[1]) && $slices[1] == 'show_main_product') {
                $action = 'show_main_product';
            }

            else if(isset($slices[1]) && $slices[1] == 'product') {
                $action = 'product_detail';
                $params = (int)$slices[2];
            }

            else if(isset($slices[1]) && $slices[1] == 'product_edit') {
                $action = 'product_edit';
                $params = (int)$slices[2];
            }

            else if(isset($slices[1]) && $slices[1] == 'product_change') {
                $action = 'product_change';
            }

            else if(isset($slices[1]) && $slices[1] == 'orders_new') {
                $action = 'orders_new';
            }

            else if(isset($slices[1]) && $slices[1] == 'orders_done') {
                $action = 'orders_done';
            }

            else if(isset($slices[1]) && $slices[1] == 'orders_rejected') {
                $action = 'orders_rejected';
            }

            else if(isset($slices[1]) && $slices[1] == 'orders_archive') {
                $action = 'orders_archive';
            }

            else if(isset($slices[1]) && $slices[1] == 'move_rejected') {
                $action = 'move_rejected';
            }

            else if(isset($slices[1]) && $slices[1] == 'move_done') {
                $action = 'move_done';
            }

            else if(isset($slices[1]) && $slices[1] == 'move_deleted') {
                $action = 'move_deleted';
            }

            else if(isset($slices[1]) && $slices[1] == 'move_archived') {
                $action = 'move_archived';
            }

            else if(isset($slices[1]) && $slices[1] == 'order') {
                $action = 'order_detail';
                $params = (int)$slices[2];
            }

            else if(isset($slices[1]) && $slices[1] == 'paid') {
                $action = 'paid';
            }

            else if(isset($slices[1]) && $slices[1] == 'category_add') {
                $action = 'category_add';
            }
    }

    elseif ($slices[0] == 'category') {
        $controllerName = 'category';
        $action = 'index';
        $params = $slices[1];
    }

    elseif ($slices[0] == 'basket') {
        $controllerName = 'basket';
        $action = 'index';

        if (isset($slices[1]) && $slices[1] == 'delete_product') {
            $action = 'delete_product';
        }

        elseif (isset($slices[1]) && $slices[1] == 'delete_all_products') {
            $action = 'delete_all_products';
        }

        elseif (isset($slices[1]) && $slices[1] == 'change_count') {
        	$action = 'change_count';
        }

        elseif (isset($slices[1]) && $slices[1] == 'accept_order') {
        	$action = 'accept_order';
        }

    }

    elseif ($slices[0] == 'search') {
        $controllerName = 'search';
        $action = 'search';
        $params = $slices[1];
    }

    else {
        $controllerName = 'error';
        $action = 'status404';
    }
    

    $controllerPath = 'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'Controller.php';
    
    include $controllerPath;
    
    $action($params);
    //dd($action);
}

function view ($path, $name, $data = array()) {
    
    include 'View'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'head.html';
    include 'View'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'header.html';
    include 'View'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$name;
    include 'View'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'footer.html';
}

function adminView($path, $name, $data = array()) {
	 
	if($name == 'auth.html') {
        include 'View'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$name;
        exit;
    }

    include 'View'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'admin_head.html';
    include 'View'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$name;

    include 'View'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'admin_footer.html';
    
}

function isAuth() {
    if(empty($_SESSION['login']) || empty($_SESSION['pass'])) return false;
    return true;
}

function db_connect() {
    require_once 'db_setting.php';
    global $mysqli;
    
    $mysqli = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME, DB_PORT);
    if (mysqli_connect_errno($mysqli)) {
        echo "Не удалось подключиться к серверу MySQL: ". mysqli_connect_error();
        exit;
    }
}

function db_query($sql, $dml = false) {
    global $mysqli;
    $res = mysqli_query($mysqli, $sql);
    if ($res === false) {
        print_r($sql);
        echo "<br><br><br><br>";
        printf("Error message: %s\n", mysqli_error($mysqli));
        die();
    }
    
    if($dml) {
        return $res;
    }
    
    $result = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $result[] = $row;
    }
    
    return $result ? $result : false;
}

function db_close() {
    global $mysqli;
    if(!mysqli_close($mysqli)) echo 'Не удалось закрыть соединение с базой данных';
}

function insertQuery($table, $data) {
    db_connect();
    
    global $mysqli;
    
    $sql = "INSERT INTO $table (";
    $values = "VALUES (";
    $newDataColumns = array();
    $newDataValues = array();
    foreach ($data as $columnName => $value) {
        $newDataColumns[] = $columnName;
        if ($value == 'NULL') {
        	$newDataValues[] = $value;
        }
        else $newDataValues[] = "'".$value."'";
    }
    $sql .= implode(', ', $newDataColumns) . ') '. $values . implode(', ',$newDataValues) . ')';
    
    $result = db_query($sql, true);
    
    $lastId = $result !== false ? mysqli_insert_id($mysqli) : 0;
    
    db_close();
    
    return $lastId;
}

function selectQuery($selectFields, $from, $where = null, $additinal_data = null, $limit = null) {
    db_connect();

    $sql = "SELECT " .implode($selectFields, ', ');
    $sql .= " FROM $from";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    if(!empty($additinal_data))
        $sql .= "$additinal_data";
    if(!empty($limit))
        $sql .= " LIMIT $limit";
 
    return db_query($sql);
    
    db_close();
}

function updateQuery($table, $data, $where, $limit = null) {
    db_connect();
    
    $sql = "UPDATE `{$table}` SET ";
    
    $newData = array();
    foreach ($data as $columnName => $value) {
        $newData[] = "`{$columnName}` = '{$value}'";
    }
    
    $sql .= implode(',', $newData);
    $sql .= " WHERE ". $where;
    
    if(!empty($limit)){
        $sql .= " LIMIT {$limit}";
    }

    $result = db_query($sql, true);
    
    db_close();
    
    return $result;
}

function deleteQuery($table, $where, $limit = null) {
    db_connect();
    
    $sql = "DELETE FROM {$table} WHERE $where";
    
    if(!empty($limit)) $sql .= " LIMIT $limit";
    
    $result = db_query($sql, true);
    
    db_close();
    
    return $result;
}

function addModel($name) {
    include_once 'Models'. DIRECTORY_SEPARATOR . $name . 'Model.php';
}