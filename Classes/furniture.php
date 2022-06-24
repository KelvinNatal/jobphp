<?php

require_once 'products.php';
class Furniture extends Products{       

    protected $height;
    protected $width;
    protected $length;
    protected $product_id;

    protected function setHeight($h){
        $this->height = $h;
    }

    protected function getHeight(){
        return $this->height;
    }

    protected function setWidth($w){
        $this->width = $w;
    }

    protected function getWidth(){
        return $this->width;
    }

    protected function setLength($l){
        $this->length = $l;
    }

    protected function getLength(){
        return $this->length;
    }

    protected function setProduct_id($pi){
        $this->product_id = $pi;
    }

    protected function getProduct_id(){
        return $this->product_id;
    }

    protected function queryInsert($furniture, $last_id){
        try{

        $objFunc = new Furniture();

        $objFunc->setHeight($furniture[0]);
        $objFunc->setWidth($furniture[1]);
        $objFunc->setLength($furniture[2]);
            
        $objFunc->setProduct_id($last_id);

        $cstD = $this->con->connect()->prepare("INSERT INTO furniture (height, width, length, product_id) VALUES (:height, :width, :length, :product_id)");
        $cstD->bindValue(":height", $objFunc->getHeight());
        $cstD->bindValue(":width", $objFunc->getWidth());
        $cstD->bindValue(":length", $objFunc->getLength());
        $cstD->bindValue(":product_id", $objFunc->getProduct_id());
        $cstD->execute();

        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
           
    }

    

}



?>