<?php

class Customer {
	protected $id;
	protected $name;
	protected static $list;

	function __construct($id,$name,$since,$revenue){
		$this->id = $id;
		$this->name = $name;
		if($since instanceof DateTime){
			$this->since = $since;
		} else {
			$this->since = new DateTime($since);
		}
		
		$this->revenue = $revenue;
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getList(){
		return self::$list;
	}

	public function getRevenue(){
		return $this->revenue;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setList($list){
		self::$list = $list;
		return $this;
	}

	public function setRevenue($revenue){
		$this->revenue = $revenue;
		return $this;
	}
	public static function getJson($path){
		$customers = json_decode(file_get_contents($path));
		
		foreach ($customers as $key => $customer) {
			$list[] = new Customer($customer->id, $customer->name,$customer->since,$customer->revenue);
		}

		return $list;
	}

	public static function getCostumerById($list,$id){
		foreach ($list as $customer) {
			if($customer->getId() == $id){
				
				return $customer;
			}
		}

	}

}

