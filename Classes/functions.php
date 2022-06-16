<?php

class Functions extends Products{    

    public function queryInsert($sku, $name, $price, $size, $height, $width, $length, $weigth){
        try{

            $objFunc = new Functions();
            $objDVD = new Dvd();
            $objBook = new Book();
            $objFurni = new Furniture();
    
            $objFunc->setSku($sku);
            $objFunc->setName($name);
            $objFunc->setPrice($price);
    
            $cst = $this->con->connect()->prepare("SELECT COUNT(*) AS `ContSKU` FROM 
            `products` WHERE `sku`=:sku;");
            $cst -> bindParam(":sku", $objFunc->getSku());
            $cst -> execute();
            $RowCheck = $cst -> fetch(PDO::FETCH_OBJ);
            $ContSKU = $RowCheck -> ContSKU;
    
            if ($ContSKU == 0) {
     
                $cst = $this->con->connect()->prepare("INSERT INTO products (sku,name,price) VALUES (:sku, :name, :price)");
                $cst->bindParam(":sku", $objFunc->getSku(), PDO::PARAM_STR);
                $cst->bindParam(":name", $objFunc->getName(), PDO::PARAM_STR);
                $cst->bindParam(":price", $objFunc->getPrice(), PDO::PARAM_STR);
                $cst->execute();            
                
                $last_id = $this->con->connect()->lastInsertId();

                if($size > 0){
                    $objDVD->queryInsert($size, $last_id);       
                }else if($weigth > 0){
                    $objBook->queryInsert($weigth, $last_id);
                }else{
                    $objFurni->queryInsert($height, $width, $length, $last_id);
                }

    
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
            $cst = $this->con->connect()->prepare("DELETE pds, dv, bo From products pds 
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