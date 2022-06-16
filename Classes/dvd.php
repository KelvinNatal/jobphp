<?php

class Dvd extends Products {       

    protected $size;
    protected $product_id;

    public function setSize($s){
        $this->size = $s;
    }

    public function getSize(){
        return $this->size;
    }

    public function setProduct_id($pi){
        $this->product_id = $pi;
    }

    public function getProduct_id(){
        return $this->product_id;
    }

    public function queryInsert($size, $last_id){   

        try{

        $objFunc = new DVD();

        $objFunc->setSize($size);  
        $objFunc->setProduct_id($last_id);

        $cstD = $this->con->connect()->prepare("INSERT INTO dvd (size, product_id) VALUES (:size, :product_id)");
        $cstD->bindParam(":size", $objFunc->getSize());
        $cstD->bindParam(":product_id", $objFunc->getProduct_id());
        $cstD->execute();
            
        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
    }
           
}




?>