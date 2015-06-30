<?php
class PlacesApi{
	private $id;
	private $placeApiId;
	private $phone;
	private $site;
	private $facebookPage;
	private $photo;
	private $priceAdded;

	public function __construct($id, $placeApiId, $phone, $site, $facebookPage, $photo, $priceAdded){
		$this->id = $id;
		$this->placeApiId = $placeApiId;
		$this->phone = $phone;
		$this->site = $site;
		$this->facebookPage = $facebookPage;
		$this->photo = $photo;
		$this->priceAdded = $priceAdded;
	}


	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getPlaceApiId(){
		return $this->placeApiId;
	}

	public function setPlaceApiId($placeApiId){
		$this->placeApiId = $placeApiId;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($phone){
		$this->phone = $phone;
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

	public function getPhoto(){
		return $this->photo;
	}

	public function setPhoto($photo){
		$this->photo = $photo;
	}

	public function getPriceAdded(){
		return $this->priceAdded;
	}

	public function setPriceAdded($priceAdded){
		$this->priceAdded = $priceAdded;
	}

	public function transformaArray(){
		$array = array(
				"id" => $this->id,
				"placeApiId" => $this->placeApiId,
				"phone" => $this->phone,
				"site" => $this->site,
				"facebook_page" => $this->facebookPage,
				"photo" => $this->photo,
				"price_added" => $this->priceAdded,
		);
		return $array;
	}
}

?>