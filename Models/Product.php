<?php

class Product implements JsonSerializable
{
	
	protected $id;
	protected $name;
	protected $category;
	protected $price;

	function __construct($id,$name, Category $category, $price)
	{
		$this->id = $id;
		$this->name = $name;
		$this->category = $category;
		$this->price = $price;
	}

	public function category(){
		return $this->category;
	}

	public function getId(){
		return $this->id;
	}

	public function jsonSerialize() {
        return $this->array;
    }


	public static function getJson($path,$categories){
		$products = json_decode(file_get_contents($path));

		foreach ($products as $key => $product) {
			foreach ($categories as $key => $category) {
			
				if($category->getId() == $product->category){
					$product_cat =  $category;

				}
			}
			
			
			$list[] = new Product($product->id, $product->name, $product_cat, $product->price);
		}

		return $list;
	}	
}