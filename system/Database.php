<?php
namespace App\System;
use PDOException;
use PDO;

class DataBase{
    protected $db;
    public function __construct() {
        try {
            //code...
            $host ="localhost";
            $database = "cfjselam_emlakdb";

            $userName = "serifcicek";
            $passWord = "rW+4J2Ub9SUe";

            // $userName = "cfjselam_serifcicek";
            // $passWord = "rW+4J2Ub9SUe";

            $this->db = new PDO("mysql:host=$host;dbname=$database",$userName,$passWord,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
            // $this->db->exec("SET NAMES 'utf8'");
            // $this->db->exec("SET CHARACTER SET utf8");
            // $this->db->exec("SET CHARACTER_SET_CONNECTION=utf8");
            // $this->db->exec("SET SQL_MODE = ''");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}