<?php

class Order 
{
	
	protected $id;
	protected $costumer;
	protected $items;
	protected $total;

	function __construct($id, Customer $customer, $products, $total)
	{
		$this->id = $id;
		$this->customer = $customer;
		$this->products = $products;
		$this->total = $total;
	}

	public function getItems(){
		return $this->items;
	}

}