<?php

class Order 
{
	
	protected $id;
	protected $customer;
	protected $products;
	protected $total;

	function __construct($id, Customer $customer, $products, $total)
	{
		$this->id = $id;
		$this->customer = $customer;
		$this->products = $products;
		$this->total = $total;
	}

	public function getId(){
		return $this->id;
	}

	public function getCustomer(){
		return $this->customer;
	}

	public function getProducts(){
		return $this->products;
	}

	public function getTotal(){
		return $this->total;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function setCustomer(Customer $Customer){
		$this->Customer = $Customer;
		return $this;
	}

	public function setProducts(Product $products){
		$this->products = $products;
		return $this;
	}

	public function setTotal($total){
		$this->total = $total;
		return $this;
	}

}