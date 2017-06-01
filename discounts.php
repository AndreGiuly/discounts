<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});


	//prepare data
	$categories = Category::getJson('Data/categories.json');
	$customers = Customer::getJson('Data/customers.json');
	$products = Product::getJson('Data/products.json',$categories);


if(isset($_POST)){
	

	if(isset($_FILES['file'])){
		
			$info   = pathinfo($_FILES['file']['name']);
			$ext    = $info['extension']; // get the extension of the file
	
		if($ext == 'json'){
			

				$target = 'Data/orders/'.$_FILES['file']['name'];
				move_uploaded_file( $_FILES['file']['tmp_name'], $target);


				$order       = json_decode(file_get_contents('Data/orders/'.$_FILES['file']['name']));

				if(is_null($order)){
					header('Location: index.php?e=400');
				}
				
				$customer    = Customer::getCostumerById($customers,$order->{'customer-id'});
			

				$order_items = [];
				$bonus       = [];


				foreach ($order->items as $key => $product) {
					$order_item = Product::getProductById($products,$product->{'product-id'});
					$order_item->setQuantity($product->quantity);
					array_push($order_items, $order_item);
				}
				
				$order = new Order($order->id,$customer,$order_items,$order->total);
	

				//A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
				if($order->getCustomer()->getRevenue() > 1000){
					$lastTotal = (float)$order->getTotal();
					$discount = 0.1;

					$newTotal = round($lastTotal - ($lastTotal * $discount),2);
					$order->setTotal($newTotal);
					array_push($bonus, '> 1000€ of revenue');
				}


				//For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.
				foreach ($order->getProducts() as $product) {
					
					if((int)$product->getCategory()->getId() === 2){
						if($product->getQuantity() >= 5){
							$quantity = $product->getQuantity();
							$extra = 0;

							for ($i=1; $i <= $product->getQuantity(); $i += 5) { 
								$extra++;
							}

							$product->setQuantity($quantity + $extra);
							array_push($bonus,'Bought '.$quantity.' of '.$product->getDescription());
						}
					}
				}

				//If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
				$quantity = 0;

				//check quantity products of category "Tools"
				foreach ($order->getProducts() as $product) {
					if((int)$product->getCategory()->getId() === 1){
						$quantity++;
					}
				}


				if($quantity >= 2){
					//set an index value;
					$cheapest = (float)$order->getProducts()[0]->getPrice();

					foreach ($order->getProducts() as $product) {
						if((float)$product->getPrice() <= $cheapest){
							$cheapest = $product->getPrice();
							$productID = $product->getId();
						}

					}
					//get cheapest Product
					$cheapestProduct = Product::getProductById($products,$productID);

					//discount
					$discount = 0.2;

					//set new price
					$lastPrice = (float)$cheapestProduct->getPrice();
					$newPrice = round($lastPrice - ($lastPrice * $discount),2);
					$cheapestProduct->setPrice($newPrice);
					array_push($bonus,'Get 20% discount on '.$cheapestProduct->getDescription().' for buy '.$quantity.' Tools');

				}

				echo '<pre>';
				print_r($bonus);
				return $bonus;
			
			
		} else {
		header('Location: index.php?e=422');
	}
	} 
} else {
	header('Location: index.php?e=405');	
}

 ?>
