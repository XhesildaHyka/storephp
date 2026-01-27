<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function category()
    {
        $category = $_GET['cat'] ?? '';
        $gender   = $_GET['gen'] ?? '';

        $perPage = 6;
        $pageNum = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $offset  = ($pageNum - 1) * $perPage;

        $product = new Product();

        // total items
        $totalItems = $product->countByCategory($category, $gender);
        $totalPages = max(1, (int)ceil($totalItems / $perPage));

        // page items
        $items = $product->getByCategoryPaged($category, $gender, $perPage, $offset);

        require "../app/views/products/category.php";
    }

}
