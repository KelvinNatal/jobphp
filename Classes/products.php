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

}

?>
