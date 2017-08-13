<?php

function status404() {
    addModel('init');
    $data = array(
        'categories' => getPublicCategories(),
        'basketPrice' => getBasketPrice(),
    );
    //dd($data);
    view('error', '404.html', $data);
}