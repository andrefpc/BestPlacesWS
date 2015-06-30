<?php
ini_set('display_errors', 1);
$servico = null;
$description = null;
$name = null;
$address = null;
$lat = null;
$lng = null;
$phone = null;
$type = null;
$id = null;
$site = null;
$facebookPage = null;
$plusPage = null;
$photo = null;
$price = null;
$placeId = null;
$placeApiId = null;

if(isset($_GET['servico'])){
	$servico = $_GET['servico'];
}

ob_start();
include_once("ServiceDAO.php");
ob_end_clean();

$serviceDAO = new ServiceDAO();

// Insert Place

if(!strcmp($servico,"insertPlace")){
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}

	if(isset($_POST['description'])){
		$description = $_POST['description'];
	}
	
	if(isset($_POST['address'])){
		$address = $_POST['address'];
	}
	
	if(isset($_POST['lat'])){
		$lat = $_POST['lat'];
	}
	
	if(isset($_POST['lng'])){
		$lng = $_POST['lng'];
	}
	
	if(isset($_POST['phone'])){
		$phone = $_POST['phone'];
	}
	
	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}

	if(isset($_POST['site'])){
		$site = $_POST['site'];
	}

	if(isset($_POST['facebookPage'])){
		$facebookPage = $_POST['facebookPage'];
	}
	
	if(isset($_POST['plusPage'])){
		$plusPage = $_POST['plusPage'];
	}

	if(isset($_POST['photo'])){
		$photo = $_POST['photo'];
	}
	
	echo json_encode($serviceDAO->insertPlace(new Place(null, $name, $description, $address, $lat, $lng, $phone, $type, $site, $facebookPage, $plusPage, $photo)));
	

// Insert Price
	
}else if(!strcmp($servico,"insertPrice")){

	if(isset($_GET['type'])){
		$type = $_GET['type'];
	}
	
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}

	if(isset($_POST['description'])){
		$description = $_POST['description'];
	}
	
	if(isset($_POST['price'])){
		$price = $_POST['price'];
	}

	if(!strcmp($type,"1")){
		if(isset($_POST['placeApiId'])){
			$placeApiId = $_POST['placeApiId'];
			
			$idReturned = $serviceDAO->verifyApiPlace($placeApiId);
			if($idReturned == false){
				$idReturned = $serviceDAO->insertEditedApiPlace(new PlacesApi(null, $placeApiId, null, null, null, null, 1));
				if($idReturned != false){
					$serviceDAO->insertPrice(new Price($id, $name, $description, $price, $placeId, $idReturned));
					echo json_encode($serviceDAO->listPrice($idReturned, null));
				}else{			
					echo false;
				}
			}else{
				$serviceDAO->insertPrice(new Price($id, $name, $description, $price, $placeId, $idReturned));
				echo json_encode($serviceDAO->listPrice($idReturned, null));
			}
			
		}
	}else{
		if(isset($_POST['placeId'])){
			$placeId = $_POST['placeId'];
			
			$serviceDAO->insertPrice(new Price($id, $name, $description, $price, $placeId, $placeApiId));
			echo json_encode($serviceDAO->listPrice(null, $placeId));
		}
	}

//List Places	
	
}else if(!strcmp($servico,"listPlaces")){
	
	if(isset($_GET['type'])){
		$type = $_GET['type'];
	}
	
	echo json_encode($serviceDAO->listPlaces($type));
	
//List Prices	

}else if(!strcmp($servico,"listPrices")){
	
	if(isset($_GET['type'])){
		$type= $_GET['type'];
	}
	
	if(!strcmp($type,"1")){
		if(isset($_GET['placeApiId'])){
			$placeApiId= $_GET['placeApiId'];
			
			$idReturned = $serviceDAO->verifyApiPlace($placeApiId);
			
			if($idReturned != false){
				echo json_encode($serviceDAO->listPrice($idReturned, null));
			}else{
				echo false; 
			}
		}

	}else{
		if(isset($_GET['placeId'])){
			$placeId= $_GET['placeId'];
			echo json_encode($serviceDAO->listPrice(null, $placeId));
		}else{
			echo false;
		}
	}
	
}else if(!strcmp($servico,"detailsPlaces")){
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	echo json_encode($serviceDAO->detailsPlaces($id));
	
}else if(!strcmp($servico,"detailsPlacesApi")){
	
	if(isset($_GET['placesApiId'])){
		$placeApiId = $_GET['placesApiId'];
	}
	
	echo json_encode($serviceDAO->detailsPlacesApi($placeApiId));
	
}else if(!strcmp($servico,"updateNativePhone")){
	
	if(isset($_GET['placeId'])){
		$placeId = $_GET['placeId'];
	}
	if(isset($_GET['phone'])){
		$phone = $_GET['phone'];
	}
	
	echo json_encode($serviceDAO->updatePhoneNativePlace($placeId,$phone));
	
}else if(!strcmp($servico,"updateNativeSite")){
	
	if(isset($_GET['placeId'])){
		$placeId = $_GET['placeId'];
	}
	if(isset($_GET['site'])){
		$site = $_GET['site'];
	}
	
	echo json_encode($serviceDAO->updateSiteNativePlace($placeId,$site));
	
}else if(!strcmp($servico,"updateNativeFacebookPage")){
	
	if(isset($_GET['placeId'])){
		$placeId = $_GET['placeId'];
	}
	if(isset($_GET['facebookPage'])){
		$facebookPage = $_GET['facebookPage'];
	}
	
	echo json_encode($serviceDAO->updateFacebookNativePlace($placeId,$facebookPage));
	
}else if(!strcmp($servico,"updateNativePlusPage")){
	
	if(isset($_GET['placeId'])){
		$placeId = $_GET['placeId'];
	}
	if(isset($_GET['plusPage'])){
		$plusPage = $_GET['plusPage'];
	}
	
	echo json_encode($serviceDAO->updatePlusNativePlace($placeId,$plusPage));
	
}else if(!strcmp($servico,"updateApiPhone")){

	if(isset($_GET['placeApiId'])){
		$placeApiId = $_GET['placeApiId'];
	}
	if(isset($_GET['phone'])){
		$phone = $_GET['phone'];
	}

	echo json_encode($serviceDAO->updatePhonePlacesApi($placeApiId,$phone));

}else if(!strcmp($servico,"updateApiSite")){

	if(isset($_GET['placeApiId'])){
		$placeApiId = $_GET['placeApiId'];
	}
	if(isset($_GET['site'])){
		$site = $_GET['site'];
	}

	echo json_encode($serviceDAO->updateSitePlacesApi($placeApiId,$site));

}else if(!strcmp($servico,"updateApiFacebook")){

	if(isset($_GET['placeApiId'])){
		$placeApiId = $_GET['placeApiId'];
	}
	if(isset($_GET['facebookPage'])){
		$facebookPage = $_GET['facebookPage'];
	}

	echo json_encode($serviceDAO->updateFacebookPlacesApi($placeApiId,$facebookPage));

}
	
// }else if(!strcmp($servico,"updateConfirmationStatus")){
	
// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
	
// 	echo json_encode($serviceDAO->updateConfirmedStatus($id));
	

// }else if(!strcmp($servico,"updatePhotoApp")){

// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
// 	if(isset($_POST['photo'])){
// 		$photo = $_POST['photo'];
// 	}
	
// 	echo json_encode($serviceDAO->updatePhotoApp($id, $photo));
	
// }else if(!strcmp($servico,"updatePhotoPlaces")){

// 	if(isset($_POST['placeId'])){
// 		$placeId = $_POST['placeId'];
// 	}
// 	if(isset($_POST['photo'])){
// 		$photo = $_POST['photo'];
// 	}
	
// 	echo json_encode($serviceDAO->updatePhotoPlaces($placesId, $photo));
	
// }else if(!strcmp($servico,"updatePhoneApp")){

// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
// 	if(isset($_POST['phone'])){
// 		$phone = $_POST['phone'];
// 	}
	
// 	echo json_encode($serviceDAO->updatePhoneApp($id, $phone));
	
// }else if(!strcmp($servico,"updatePhonePlaces")){

// 	if(isset($_POST['placeId'])){
// 		$placeId = $_POST['placeId'];
// 	}
// 	if(isset($_POST['phone'])){
// 		$phone = $_POST['phone'];
// 	}
	
// 	echo json_encode($serviceDAO->updatePhonePlaces($placeId, $phone));
	
// }else if(!strcmp($servico,"updateFacebookPageApp")){

// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
// 	if(isset($_POST['facebookPage'])){
// 		$facebookPage = $_POST['facebookPage'];
// 	}
	
// 	echo json_encode($serviceDAO->updateFacebookPageApp($id, $facebookPage));
	
// }else if(!strcmp($servico,"updateFacebookPagePlaces")){

// 	if(isset($_POST['placeId'])){
// 		$placeId = $_POST['placeId'];
// 	}
// 	if(isset($_POST['facebookPage'])){
// 		$facebookPage = $_POST['facebookPage'];
// 	}
	
// 	echo json_encode($serviceDAO->updateFacebookPagePlaces($placeId, $facebookPage));
	
// }else if(!strcmp($servico,"updatPlusPageApp")){

// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
// 	if(isset($_POST['plusPage'])){
// 		$plusPage = $_POST['plusPage'];
// 	}
	
// 	echo json_encode($serviceDAO->updatePlusPageApp($id, $plusPage));
	
// }else if(!strcmp($servico,"updateSiteApp")){

// 	if(isset($_POST['id'])){
// 		$id = $_POST['id'];
// 	}
// 	if(isset($_POST['site'])){
// 		$site = $_POST['site'];
// 	}
	
// 	echo json_encode($serviceDAO->updateSiteApp($id, $site));
	
// }else if(!strcmp($servico,"updateSitePlaces")){

// 	if(isset($_POST['placeId'])){
// 		$placeId = $_POST['placeId'];
// 	}
// 	if(isset($_POST['site'])){
// 		$site = $_POST['site'];
// 	}
	
// 	echo json_encode($serviceDAO->updateSitePlaces($placeId, $site));
	
else{
	
	echo false;
	
}
?>