<?php

class Book extends Products {       

    protected $weight;
    protected $product_id;

    public function setWeight($w){
        $this->weight = $w;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function setProduct_id($pi){
        $this->product_id = $pi;
    }

    public function getProduct_id(){
        return $this->product_id;
    }

    public function queryInsert($weight, $last_id){   

        try{

        $objFunc = new BOOK();

        $objFunc->setWeight($weight);
        $objFunc->setProduct_id($last_id);

        $cstD = $this->con->connect()->prepare("INSERT INTO book (weight, product_id) VALUES (:weight, :product_id)");
        $cstD->bindParam(":weight", $objFunc->getWeight());
        $cstD->bindParam(":product_id", $objFunc->getProduct_id());
        $cstD->execute();
  
        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
           
    }

}


?>