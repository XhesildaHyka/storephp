<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Banner.php';

class HomeController {

    public function index() {
        $product = new Product();
        $banner = new Banner();

        $banners = $banner->getActive();
        $newArrivals = $product->getNewArrivals();
        $offers = $product->getOffers();

        require __DIR__ . '/../views/home/index.php';
    }
}
