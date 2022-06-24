<?php

require_once 'Connec/connection.php';
 abstract class Products {

    protected $id;
    protected $sku;
    protected $name;
    protected $price;

    protected function setId($i){
        $this->id = $i;
    }

    protected function getId(){
        return $this->id;
    }

    protected function setSku($s){
        $this->sku = $s;
    }

    protected function getSku(){
        return $this->sku;
    }

    protected function setName($n){
        $this->name = $n;
    }

    protected function getName(){
        return $this->name;
    }

    protected function setPrice($p){
        $this->price = $p;
    }

    protected function getPrice(){
        return $this->price;
    }
             
    public function __construct(){
        $this->con = new Connection();
    }

    abstract protected function queryInsert($type, $Lid);

    public function productBase($sku, $name, $price, $size, $weigth, $furniture){       

        try{

            $objFuncD = new Dvd();
            $objFuncF = new Furniture();
            $objFuncB = new Book();
    
            $objFuncD->setSku($sku);
            $objFuncD->setName($name);
            $objFuncD->setPrice($price);

            $cst = $this->con->connect()->prepare("SELECT COUNT(*) AS `ContSKU` FROM 
            `products` WHERE `sku`=:sku;");
            $cst->bindValue(":sku", $objFuncD->getSku());
            $cst -> execute();
            $RowCheck = $cst -> fetch(PDO::FETCH_OBJ);
            $ContSKU = $RowCheck -> ContSKU;
    
            if ($ContSKU == 0) {
     
                $cst = $this->con->connect()->prepare("INSERT INTO products (sku,name,price) VALUES (:sku, :name, :price)");
                $cst->bindValue(":sku", $objFuncD->getSku(), PDO::PARAM_STR);
                $cst->bindValue(":name", $objFuncD->getName(), PDO::PARAM_STR);
                $cst->bindValue(":price", $objFuncD->getPrice(), PDO::PARAM_STR);
                $cst->execute();            
                
                $last_id = $this->con->connect()->lastInsertId();
                $objFuncD->queryInsert($size, $last_id);
                $objFuncB->queryInsert($weigth, $last_id);
                $objFuncF->queryInsert($furniture, $last_id);
                    
            }else{
                $response = [
                    "erro" => true,
                    "message" => "SKU already exists"
                ];
            }   
                http_response_code(200);
                echo json_encode($response); 
    
            }catch(PDOException $ex){
                return 'error '.$ex->getMessage();
            }
    }

    public function querySelect(){       
        
        try{
           $cst = $this->con->connect()->prepare("SELECT pds.id, pds.sku, pds.name, pds.price, dv.size, fnt.height, fnt.width, fnt.length, bo.weight FROM products pds 
                                                  LEFT JOIN dvd AS dv ON dv.product_id=pds.id 
                                                  LEFT JOIN book AS bo ON bo.product_id=pds.id 
                                                  LEFT JOIN furniture AS fnt ON fnt.product_id=pds.id
                                                  ORDER BY pds.id DESC");
           $cst->execute();
           
            if(($cst)){
                    while($row_product = $cst->fetch(PDO::FETCH_ASSOC)){
                    extract($row_product);
                    $list_products["records"][$id] = [
                    'select' => false,
                    'id' => $id,
                    'sku' => $sku,
                    'name' => $name,
                    'price' => $price,
                    'size' => $size,  
                    'height' => $height,
                    'width' => $width,
                    'length' => $length, 
                    'weight' => $weight                    
            
                ];
            }
        }    
        if($cst->rowCount() === 0){
            $list_products[] = [];
        }
            http_response_code(200);
            echo json_encode($list_products);
            }catch(PDOException $ex){
                return 'error '.$ex->getMessage();
            }
    }

    public function queryDelete($data){     
        
        $response = '';

        try{          
            $cst = $this->con->connect()->prepare("DELETE pds, dv, bo, fnt From products pds 
                                                        LEFT JOIN dvd AS dv ON dv.product_id=pds.id 
                                                        LEFT JOIN book AS bo ON bo.product_id=pds.id 
                                                        LEFT JOIN furniture AS fnt ON fnt.product_id=pds.id 
                                                        WHERE pds.id IN($data)");
            if($cst->execute()){
                $response = [
                    "erro" => false,
                    "mensagem" => "Product deleted sucessfully"
                ];
            
            }else{
                $response = [
                    "erro" => true,
                    "mensagem" => "Error: Product not deleted sucessfully"
                ];
            }

            http_response_code(200);
            echo json_encode($response);

        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
    }
    
    }

?>
