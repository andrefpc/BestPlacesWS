<?php
class Price{
	private $id;
	private $name;
	private $description;
	private $price;
	private $placeId;
	private $placeApiId;
	
	public function __construct($id, $name, $description, $price, $placeId, $placeApiId){
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->price = $price;
		$this->placeId = $placeId;
		$this->placeApiId = $placeApiId;
	}

	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}	
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}

	public function getDescription(){
		return $this->description;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getPrice(){
		return $this->price;
	}
	
	public function setPrice($price){
		$this->price = $price;
	}

	public function getPlaceId(){
		return $this->placeId;
	}
	
	public function setPlaceId($placeId){
		$this->placeId = $placeId;
	}

	public function getPlaceApiId(){
		return $this->placeApiId;
	}
	
	public function setPlaceApiId($placeApiId){
		$this->placeApiId = $placeApiId;
	}

	
	public function transformaArray(){
		$array = array(
				"name" => $this->name,
				"description" => $this->description,
				"price" => $this->price,
				"placeId" => $this->placeId,
				"placeApiId" => $this->placeApiId
		);
		return $array;
	}
}
?>