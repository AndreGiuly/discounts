<?php

class Product implements JsonSerializable
{
	
	protected $id;
	protected $description;
	protected $category;
	protected $price;
	protected $quantity;

	function __construct($id,$description, Category $category, $price)
	{
		$this->id = $id;
		$this->description = $description;
		$this->category = $category;
		$this->price = $price;
	}

	public function getId(){
		return $this->id;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getCategory(){
		return $this->category;
	}

	public function getPrice(){
		return $this->price;
	}

	public function getQuantity(){
		return $this->quantity;
	}

	public static function getJson($path,$categories){
		$products = json_decode(file_get_contents($path));

		foreach ($products as $key => $product) {
			foreach ($categories as $key => $category) {
			
				if($category->getId() == $product->category){
					$product_cat =  $category;
				}
			}
			
			$list[] = new Product($product->id, $product->description, $product_cat, $product->price);
		}

		return $list;
	}	

	public static function getProductById($list,$id){
		foreach ($list as $product) {
			if($product->getId() == $id){
				
				return $product;
			}
		}

	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function setDescription($description){
		$this->description = $description;
		return $this;
	}

	public function setCategory($category){
		$this->category = $category;
		return $this;
	}

	public function setPrice($price){
		$this->price = $price;
		return $this;
	}

	public function setQuantity($quantity){
		$this->quantity = $quantity;
		return $this;
	}

	public function jsonSerialize() {
        return $this->array;
    }


}