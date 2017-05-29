<?php

class Customer {
	protected $id;
	protected $name;

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

	public static function getJson($path){
		$customers = json_decode(file_get_contents($path));
		
		foreach ($customers as $key => $customer) {
			$list[] = new Category($customer->id, $customer->name,$customer->since,$customer->revenue);
		}

		return $list;
	}

}

