<?php
class Place{
	private $id;
	private $name;
	private $description;
	private $address;
	private $lat;
	private $lng;
	private $phone;
	private $type;
	private $site;
	private $facebookPage;
	private $plusPage;
	private $photo;
	
	public function __construct($id, $name, $description, $address, $lat, $lng, $phone, $type, $site, $facebookPage, $plusPage, $photo){
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->address = $address;
		$this->lat = $lat;
		$this->lng = $lng;
		$this->phone = $phone;
		$this->type = $type;
		$this->site = $site;
		$this->facebookPage = $facebookPage;
		$this->plusPage = $plusPage;
		$this->photo = $photo;
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
	
	public function getAddress(){
		return $this->address;
	}
	
	public function setAddress($address){
		$this->address = $address;
	}

	public function getLat(){
		return $this->lat;
	}
	
	public function setLat($lat){
		$this->lat = $lat;
	}

	public function getLng(){
		return $this->lng;
	}
	
	public function setLng($lng){
		$this->lng = $lng;
	}

	public function getPhone(){
		return $this->phone;
	}
	
	public function setPhone($phone){
		$this->phone = $phone;
	}

	public function getType(){
		return $this->type;
	}
	
	public function setType($type){
		$this->type = $type;
	}

	public function getSite(){
		return $this->site;
	}
	
	public function setSite($site){
		$this->site = $site;
	}

	public function getFacebookPage(){
		return $this->facebookPage;
	}
	
	public function setFacebookPage($facebookPage){
		$this->facebookPage = $facebookPage;
	}
	
	public function getPlusPage(){
		return $this->plusPage;
	}
	
	public function setPlusPage($plusPage){
		$this->plusPage = $plusPage;
	}
	
	public function getPhoto(){
		return $this->photo;
	}
	
	public function setPhoto($photo){
		$this->photo = $photo;
	}
	
	public function transformaArray(){
		$array = array(
				"id" => $this->id,
				"name" => $this->name,
				"description" => $this->description,
				"address" => $this->address,
				"lat" => $this->lat,
				"lng" => $this->lng,
				"phone" => $this->phone,
				"type" => $this->type,
				"site" => $this->site,
				"facebook_page" => $this->facebookPage,
				"plus_page" => $this->plusPage,
				"photo" => $this->photo
		);
		return $array;
	}
	
	
}
?>