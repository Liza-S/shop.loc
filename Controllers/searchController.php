<?php
function search($params) {

    addModel('init');
    $data = array(
        'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
        'search_res' => getSearchRes($params),
    );
    /*dd($data['search_res']);*/
    view('search','index.html', $data);
}