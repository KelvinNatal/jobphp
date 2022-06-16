<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

include_once 'Classes/products.php';
include_once 'Classes/dvd.php';
include_once 'Classes/functions.php';
include_once 'Classes/book.php';
include_once 'Classes/furniture.php';

/*ini_set('display_errors', 0 );
error_reporting(0);*/

$objPdd = new Dvd();
$objPdb = new Book();
$objPdt = new Functions();
$objPdf = new Furniture();


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    
    case "GET":
        $objPdt->querySelect();
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

        $objPdt->queryInsert($sku, $name, $price, $size, $height, $width, $length, $weight);
                
    break; 

    case "DELETE": 
        $id = filter_input(INPUT_GET, "id");
        $pat = explode(',', $id);
        $data = implode(',', $pat);

        $objPdt->queryDelete($data);
    break;
    }

?>

