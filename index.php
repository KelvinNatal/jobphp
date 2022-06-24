<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

include_once 'Classes/products.php';
include_once 'Classes/furniture.php';
include_once 'Classes/dvd.php';
include_once 'Classes/book.php';

$objPdp = new Dvd();

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    
    case "GET":
        $objPdp->querySelect();
    break;    

    case "POST":  
        $response_json = file_get_contents("php://input");
        $data = json_decode($response_json, true);

        $sku =  $data['product']['sku'];
        $name = $data['product']['name'];
        $price = $data['product']['price'];
        $size = $data['product']['size'];       
        $height = $data['product']['height']; 
        $width = $data['product']['width']; 
        $length = $data['product']['length']; 
        $weight = $data['product']['weight'];

        $furniture = [$height, $width, $length];
                 
        $objPdp->productBase($sku, $name, $price, $size, $weight, $furniture);
                
    break; 

    case "DELETE": 
        $id = filter_input(INPUT_GET, "id");
        $pat = explode(',', $id);
        $data = implode(',', $pat);

        $objPdp->queryDelete($data);
    break;
    }


?>

