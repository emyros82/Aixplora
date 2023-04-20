<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
$placeModel = new PlaceModel();
$places = $placeModel->getAllPlaces();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

$tableauLieux = array();

foreach ($places as $place) {
  $tableauLieux['places'][] = $place;
}

$mapDatas = json_encode($tableauLieux);

var_dump($mapDatas);

    // foreach ($places as $place) {
    //     extract($place);
        
    //     $tableauLieux['places'][] = $place;
        
    // }
    
    // On encode en json et on envoie
    // echo json_encode($tableauLieux);
    // $mapDatas = json_encode($tableauLieux);
    // 
    // echo $mapDatas;
    
    
    // Inclusion du template
    $template = 'carteInteractive';
    include '../templates/carteInteractive.phtml';
    // var_dump($place);
    // //   $place = [
    // //     "idPlace" => $idPlace,
    // //     "adressPlace" => $adressPlace,
    // //     "abstractPlace" =>  $abstractPlace,
    // //     "descriptionPlace" => $descriptionPlace,
    // //     "lonPlace" => $lonPlace,
    // //     "latPlace" => $latPlace,
    // //     "imagePlace" => $imagePlace
    // ];