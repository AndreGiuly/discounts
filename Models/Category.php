<?php

class Category implements JsonSerializable
{
	
	protected $id;
	protected $description;
	protected static $list = [];
	

	function __construct($id,$description)
	{
		$this->id = $id;
		$this->description = $description;
	}


	public static function getJson($path){
		$catgs = json_decode(file_get_contents($path));
		
		foreach ($catgs as $key => $category) {
			$list[] = new Category($category->id, $category->description);
		}

		return $list;
	}	

	public function jsonSerialize() {
        return $this->array;
    }

	public function getId(){
		return $this->id;
	}

	public function getList(){
		return self::$list;
	}


	public  static function getCategoryById($id){
		if($this->getId() == $id){
			return $this;
		}
		return null;
	}
}