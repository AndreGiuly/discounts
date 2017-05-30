<?php 

spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});


	
	echo '<pre>';
	foreach ($products as $product) {
		var_dump($product->category());
	}
	
?>

<form action="discounts.php" method="post" enctype='multipart/form-data'>
	<input type="file" name="file">
	<input type="submit">
</form>