<?php

class Furniture extends Products {       

    protected $height;
    protected $width;
    protected $length;
    protected $product_id;

    public function setHeight($h){
        $this->height = $h;
    }

    public function getHeight(){
        return $this->height;
    }

    public function setWidth($w){
        $this->width = $w;
    }

    public function getWidth(){
        return $this->width;
    }

    public function setLength($l){
        $this->length = $l;
    }

    public function getLength(){
        return $this->length;
    }

    public function setProduct_id($pi){
        $this->product_id = $pi;
    }

    public function getProduct_id(){
        return $this->product_id;
    }

    public function queryInsert($height, $width, $length, $last_id){   

        try{

        $objFunc = new Furniture();

        $objFunc->setHeight($height);
        $objFunc->setWidth($width);
        $objFunc->setLength($length);
            
        $objFunc->setProduct_id($last_id);

        $cstD = $this->con->connect()->prepare("INSERT INTO furniture (height, width, length, product_id) VALUES (:height, :width, :length, :product_id)");
        $cstD->bindParam(":height", $objFunc->getHeight());
        $cstD->bindParam(":width", $objFunc->getWidth());
        $cstD->bindParam(":length", $objFunc->getLength());
        $cstD->bindParam(":product_id", $objFunc->getProduct_id());
        $cstD->execute();

        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
           
    }

}


?>