<?php 

spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});

	//prepare data
	$categories = Category::getJson('Data/categories.json');
	$customers = Customer::getJson('Data/customers.json');
	$products = Product::getJson('Data/products.json',$categories);
	
	echo '<pre>';
	foreach ($products as $product) {
		var_dump($product->category());
	}
	
?>

<form action="discounts.php" method="post" enctype='multipart/form-data'>
	<input type="file" name="file">
	<input type="submit">
</form>