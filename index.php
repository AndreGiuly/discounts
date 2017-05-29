<?php 

spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});

	//prepare data
	$categories = Category::getJson('Data/categories.json');
	$customers = Customer::getJson('Data/customers.json');
	$products = Product::getJson('Data/products.json',$categories);
	echo '<pre>';
	print_r($products);
?>