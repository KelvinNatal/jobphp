<?php

require_once 'products.php';


class Dvd extends Products {       

    protected $size;
    protected $product_id;

    protected function setSize($s){
        $this->size = $s;
    }

    protected function getSize(){
        return $this->size;
    }

    protected function setProduct_id($pi){
        $this->product_id = $pi;
    }

    protected function getProduct_id(){
        return $this->product_id;
    }    

    protected function queryInsert($size, $last_id){ 
        
        $objFunc = new DVD();

        try{

            $objFunc->setSize($size);
            $objFunc->setProduct_id($last_id);
    
            $cstD = $this->con->connect()->prepare("INSERT INTO dvd (size, product_id) VALUES (:size, :product_id)");
            $cstD->bindValue(":size", $objFunc->getSize());
            $cstD->bindValue(":product_id", $objFunc->getProduct_id());
            $cstD->execute();
        
            
        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
    }
           
}




?>