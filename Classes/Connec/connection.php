<?php

class Connection {
    private $user;
    private $pass;
    private $dbname;
    private $host;
    private static $pdo;

    public function __construct()
    {
        $this->host = "localhost";
        $this->dbname = "product_table";
        $this->user = "root";
        $this->pass = "";

    }

    public function connect(){
        try{
            if(is_null(self::$pdo)){
                self::$pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->pass);
            }
            return self::$pdo;

        }catch(PDOException $ex){
            return 'error '.$ex->getMessage();
        }
    }

}
