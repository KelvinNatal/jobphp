<?php

require_once 'products.php';

class Book extends Products {       

    protected $weight;
    protected $product_id;

    protected function setWeight($w){
        $this->weight = $w;
    }

    protected function getWeight(){
        return $this->weight;
    }

    protected function setProduct_id($pi){
        $this->product_id = $pi;
    }

    protected function getProduct_id(){
        return $this->product_id;
    }

    protected function queryInsert($weight, $last_id){   

        try{
            
        $objFunc = new BOOK();

        $objFunc->setWeight($weight);
        $objFunc->setProduct_id($last_id);

        $cstD = $this->con->connect()->prepare("INSERT INTO book (weight, product_id) VALUES (:weight, :product_id)");
        $cstD->bindValue(":weight", $objFunc->getWeight());
        $cstD->bindValue(":product_id", $objFunc->getProduct_id());
        $cstD->execute();
  
        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
           
    }

}


?>