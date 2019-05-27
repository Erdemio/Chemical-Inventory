<?php
error_reporting(0);
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.
session_start();
ob_start();
class database{
    private $host = 'localhost';
    private $user ='root';
    private $password ='';
    private $database ='bp';
    private $connection;

    function __construct() {

        if($this->connect()) {

            if($this->select_db()) {
                return true ;

            }
            else {
                echo 'Hata : Veritabanı seçilemedi !';
                exit();
            }
        }
        else {
            echo 'Hata : Veritabanı bağlantısı kurulamadı!';
        }
    }

    private function connect(){

        $this->connection = @mysql_connect($this->host,  $this->user,  $this->password);
        if($this->connection){ return true;} else { return false;}
    }

    private function select_db(){

        $db = mysql_select_db($this->database, $this->connection);
        if($db){
            mysql_query("SET NAMES 'utf8'");
            mysql_query("SET CHARACTER SET lutf8");
            mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
            return true;
        }
        else{
            return false;
        }
    }

    private function close() {

        $this->connection = @mysql_close($this->connection);
        if($this->connection) { return true ;} else { return false ;}

    }

    function __destruct() {

        $this->close();
    }

}
?>
