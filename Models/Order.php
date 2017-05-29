<?php

class Order 
{
	
	protected $id;
	protected $costumer;
	protected $items;
	protected $total;

	function __construct($id,Costumer $costumer, $items, $total)
	{
		$this->id = $id;
		$this->costumer = $costumer;
		$this->items = $items;
		$this->total = $total;
	}

	public function getItems(){
		return $this->items;
	}

}