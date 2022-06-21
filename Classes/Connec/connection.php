<?php

class Connection {
    private $user;
    private $pass;
    private $dbname;
    private $host;
    private static $pdo;

    public function __construct()
    {
        $this->host = "us-cdbr-east-05.cleardb.net";
        $this->dbname = "heroku_af82a28c15e044b";
        $this->user = "bc7d0502027993";
        $this->pass = "e70383ad";

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
