<?php
ob_start();
include_once("Conexao.php");
include_once("Place.php");
include_once("PlacesApi.php");
include_once("Price.php");
ob_end_clean();

class ServiceDAO{

	public function insertPlace(Place $place){

		$cn = new Conexao();
	
		$sql = "INSERT INTO places_added (name, description, address, lat, lng, phone, type, site, facebook_page, plus_page, photo) VALUES ('".$place->getName()."','".$place->getDescription()."','".$place->getAddress()."','".$place->getLat()."','".$place->getLng()."','".$place->getPhone()."','".$place->getType()."','".$place->getSite()."','".$place->getFacebookPage()."','".$place->getPlusPage()."','".$place->getPhoto()."')";
				
		$result = $cn->execute($sql);
		$id = $cn->returnInsertedId();
		
		$cn->disconnect();
		
		if($result != false){
			
			return true;
			
		} else {

			return false;
		}
	}
	
	public function verifyApiPlace($placeApiId){
	
		$cn = new Conexao();
	
		$sql = "SELECT id FROM places_api_edited WHERE place_api_id = '".$placeApiId."'";
		
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			
			$rs = mysql_fetch_array($result);
			$id = $rs["id"];
			return $id;
	
		} else {
	
			return false;
		}
	}
	
	public function insertEditedApiPlace(PlacesApi $placesApi){
				
		$cn = new Conexao();
		
		$sql = "INSERT INTO places_api_edited (place_api_id, phone, site, facebook_page, photo, prices_added) VALUES ('".$placesApi->getPlaceApiId()."','".$placesApi->getPhone()."','".$placesApi->getSite()."','".$placesApi->getFacebookPage()."','".$placesApi->getPhoto()."','".$placesApi->getPriceAdded()."')";

		$result = $cn->execute($sql);
		$id = $cn->returnInsertedId();
		
		$cn->disconnect();
		
		if($result != false){
		
			return $id;
		
		} else {
		
			return false;
		}
	}
	
	
	public function insertPrice(Price $price){
	
		$cn = new Conexao();
	
		$sql = "INSERT INTO prices_added (name, description, price, place_id, place_api_id) VALUES ('".$price->getName()."','".$price->getDescription()."','".$price->getPrice()."','".$price->getPlaceId()."','".$price->getPlaceApiId()."')";
		
		$result = $cn->execute($sql);
		$id = $cn->returnInsertedId();
	
		$cn->disconnect();
	
		if($result != false){
				
			return true;
				
		} else {
	
			return false;
		}
	}
	
	public function listPlaces($type){
	
		$cn = new Conexao;
	
		$sql = "SELECT id, name, description, address, lat, lng FROM places_added WHERE type = ".$type."";
	
		$places = array();
	
		$result = $cn->execute($sql);
	
		if($result != false){
			while ($rs = mysql_fetch_array($result)) {
					
				$place = new Place($rs["id"], $rs["name"], $rs["description"], $rs["address"], $rs["lat"],$rs["lng"], null, null, null, null, null, null);
				array_push($places, $place->transformaArray());
					
			}
				
			$cn->disconnect();
			return $places;
				
		} else {
				
			$cn->disconnect();
			return false;
				
		}
	}
	
	public function listPrice($placeApiId, $placeId){
	
		$cn = new Conexao;

		$prices = array();
		
	
		if($placeApiId != null && $placeId == null){
			$sql = "SELECT id, name, description, price FROM prices_added WHERE place_api_id like '".$placeApiId."'";
	
			$result = $cn->execute($sql);
	
			if($result != false){
				while ($rs = mysql_fetch_array($result)) {
						
					$price = new Price($rs["id"], $rs["name"], $rs["description"], $rs["price"], null, $placeApiId);
					array_push($prices, $price->transformaArray());
						
				}
		
				$cn->disconnect();
				return $prices;
		
			} else {
		
				$cn->disconnect();
				return false;
		
			}
		}else if($placeApiId == null && $placeId != null){
			$sql = "SELECT id, name, description, price FROM prices_added WHERE place_id = ".$placeId."";
			
			$places = array();
			
			$result = $cn->execute($sql);
			
			if($result != false){
				while ($rs = mysql_fetch_array($result)) {

					$price = new Price($rs["id"], $rs["name"], $rs["description"], $rs["price"], $placeId, null);
					array_push($prices, $price->transformaArray());
			
				}
			
				$cn->disconnect();
				return $prices;
			
			} else {
			
				$cn->disconnect();
				return false;
			
			}
		}
	}
	
	
	public function detailsPlaces($id){
	
		$cn = new Conexao;
	
		$sql = "SELECT id, name, description, address, lat, lng, phone, type, site, facebook_page, plus_page, photo FROM places_added WHERE id = ".$id."";
		
		$places = array();
	
		$result = $cn->execute($sql);
	
		if($result != false){
			while ($rs = mysql_fetch_array($result)) {
					
				$place = new Place($rs["id"], $rs["name"], $rs["description"], $rs["address"], $rs["lat"],$rs["lng"], $rs["phone"], $rs["type"], $rs["site"], $rs["facebook_page"], $rs["plus_page"], $rs["photo"]);
				array_push($places, $place->transformaArray());
					
			}
	
			$cn->disconnect();
			return $places;
	
		} else {
	
			$cn->disconnect();
			return false;
	
		}
	}
	
	public function detailsPlacesApi($placeApiId){
	
		$cn = new Conexao;
	
		$sql = "SELECT id, place_api_id, phone, site, facebook_page, photo, prices_added FROM places_api_edited WHERE place_api_id LIKE '".$placeApiId."'";
	
		$places = array();
	
		$result = $cn->execute($sql);
	
		if($result != false){
			while ($rs = mysql_fetch_array($result)) {
					
				$place = new PlacesApi($rs["id"], $rs["place_api_id"], $rs["phone"], $rs["site"], $rs["facebook_page"],$rs["photo"], $rs["prices_added"]);
				array_push($places, $place->transformaArray());
					
			}
	
			$cn->disconnect();
			return $places;
	
		} else {
	
			$cn->disconnect();
			return false;
	
		}
	}
	
	public function updatePhonePlacesApi($placeApiId, $phone){

		$cn = new Conexao();

		$sql = "INSERT INTO places_api_edited (place_api_id, phone) VALUES('".$placeApiId."','".$phone."') ON DUPLICATE KEY UPDATE phone=VALUES(phone)";

		$result = $cn->execute($sql);

		$cn->disconnect();

		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSitePlacesApi($placeApiId, $site){
	
		$cn = new Conexao();
	
		$sql = "INSERT INTO places_api_edited (place_api_id, site) VALUES('".$placeApiId."','".$site."') ON DUPLICATE KEY UPDATE site=VALUES(site)";
	
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updateFacebookPlacesApi($placeApiId, $facebookPage){
	
		$cn = new Conexao();
	
		$sql = "INSERT INTO places_api_edited (place_api_id, facebook_page) VALUES('".$placeApiId."','".$facebookPage."') ON DUPLICATE KEY UPDATE facebook_page=VALUES(facebook_page)";
	
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updatePhoneNativePlace($placeId, $phone){
	
		$cn = new Conexao();
	
		$sql = "UPDATE places_added SET phone = '".$phone."' WHERE id = ".$placeId."";
	
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSiteNativePlace($placeId, $site){
	
		$cn = new Conexao();
	
		$sql = "UPDATE places_added SET site = '".$site."' WHERE id = ".$placeId."";
		
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updateFacebookNativePlace($placeId, $facebookPage){
	
		$cn = new Conexao();

		$sql = "UPDATE places_added SET facebook_page = '".$facebookPage."' WHERE id = ".$placeId."";
	
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	public function updatePlusNativePlace($placeId, $plusPage){
	
		$cn = new Conexao();

		$sql = "UPDATE places_added SET plus_page = '".$plusPage."' WHERE id = ".$placeId."";
	
		$result = $cn->execute($sql);
	
		$cn->disconnect();
	
		if($result != false){
			return true;
		} else {
			return false;
		}
	}
	
	
// 	public function updatePriceApp($price, $place_id){
	
// 		$cn = new Conexao();
	
// 		$sql = "INSERT INTO pending_prices_updated (price, place_id) VALUES ('".$price."','".$place_id."')";
	
// 		$result = $cn->execute($sql);
// 		$id = $cn->returnInsertedId();
	
// 		$cn->disconnect();
	
// 		if($result != false){
	
// 			return true;
	
// 		} else {
	
// 			return false;
// 		}
// 	}
	
// 	public function updatePricePlaces($price, $place_api_id){
	
// 		$cn = new Conexao();
	
// 		$sql = "INSERT INTO pending_prices_updated (price, place_api_id) VALUES ('".$price."','".$place_api_id."')";
	
// 		$result = $cn->execute($sql);
// 		$id = $cn->returnInsertedId();
	
// 		$cn->disconnect();
	
// 		if($result != false){
	
// 			return true;
	
// 		} else {
	
// 			return false;
// 		}
// 	}
	
// 	public function insertPhoto($photo, $placeId, $cn){
	
	
// 		$sql = "INSERT INTO photos (photo, place_id) VALUES ('".$photo."','".$placeId."')";
	
// 		$result = $cn->execute($sql);
	
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function updateConfirmedStatus($id){
	
// 		$cn = new Conexao();
	
// 		$sql = "UPDATE places SET confirmation = confirmation + true WHERE id = ".$id;
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	//Update Photo
	
// 	public function updatePhotoApp($id, $photo){
	
// 		$cn = new Conexao();
	
// 		$sql = "INSERT INTO pending_photos (photo, place_id) VALUES ( ".$photo.",".$id.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function updatePhotoPlaces($placesId, $photo){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_photos (photo, place_api_id) VALUES ( ".$photo.",".$placesId.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	//Update Phone
	
// 	public function updatePhoneApp($id, $phone){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_phones (phone, place_id) VALUES ( ".$phone.",".$id.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function updatePhonePlaces($placeId, $phone){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_phones (phone, place_api_id) VALUES ( ".$phone.",".$placeId.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	//Update FacebookPage
	
// 	public function updateFacebookPageApp($id, $facebookPage){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_facebook_pages (facebook_page, place_id) VALUES ( ".$facebookPage.",".$id.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function updateFacebookPagePlaces($placeId, $facebookPage){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_facebook_pages (facebook_page, place_api_id) VALUES ( ".$facebookPage.",".$placeId.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	//Update PlusPage

// 	public function updatePlusPageApp($id, $plusPage){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_plus_pages (plus_page, place_id) VALUES ( ".$plusPage.",".$id.")";
		
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	//Update Site
	
// 	public function updateSiteApp($id, $site){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_sites (site, place_id) VALUES ( ".$site.",".$id.")";
		
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
// 	public function updateSitePlaces($placeId, $site){
	
// 		$cn = new Conexao();

// 		$sql = "INSERT INTO pending_sites (site, place_api_id) VALUES ( ".$site.",".$placeId.")";
	
// 		$result = $cn->execute($sql);
	
// 		$cn->disconnect();
	
// 		if($result != false){
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
	
	

}
		
?>