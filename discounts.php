<?php 


spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});


	//prepare data
	$categories = Category::getJson('Data/categories.json');
	$customers = Customer::getJson('Data/customers.json');
	$products = Product::getJson('Data/products.json',$categories);

	
	$customer = Customer::getCostumerById($customers,1);




if(isset($_POST)){


	//store order
	$info = pathinfo($_FILES['file']['name']);
	$ext = $info['extension']; // get the extension of the file
	$target = 'Data/orders/'.$_FILES['file']['name'];
	move_uploaded_file( $_FILES['file']['tmp_name'], $target);


	$order = json_decode(file_get_contents('Data/orders/'.$_FILES['file']['name']));

	echo '<pre>';
	//var_dump($order);
//	var_dump($order->{'customer-id'});
	$customer = Customer::getCostumerById($customers,$order->{'customer-id'});
//	var_dump($customer);
	$order1 = new Order($order->id,$customer,1,$total);
	var_dump($order1);



} else {
	echo 'NOT';
}

 ?>
