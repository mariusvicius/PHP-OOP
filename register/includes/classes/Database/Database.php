<?php

namespace Database;

use PDO;

class Database {

    private $host = ""; 
    private $user = "";
    private $psw = "";
    private $dbName = "";
    protected $tbTransportName = "transport";
    protected $tbTransportModelName = "transport_model";

    private function config(){
        include 'config.php';
        $this->host = $host;
        $this->user = $user;
        $this->psw = $psw;
        $this->dbName = $dbName;
        $this->createBase();
        $this->createTables();
    }

    protected function createBase() {
        try {
            $db = new PDO("mysql:host={$this->host}", $this->user, $this->psw);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS {$this->dbName}";
            $db->exec($sql);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function createTables() {
        try {
            $db = new PDO("mysql:dbname={$this->dbName};host={$this->host}",  $this->user, $this->psw);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $sqlTbTransportName ="CREATE TABLE IF NOT EXISTS {$this->tbTransportName} (
            ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
            plates VARCHAR( 10 ) NOT NULL, 
            model_id INT( 11 ) NOT NULL, 
            fuel_tank_volume DECIMAL(10,2) NOT NULL, 
            average_fuel_consumption DECIMAL(10,2) NOT NULL, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);" ;
            $db->exec($sqlTbTransportName);

            $sqlTbTransportModelName ="CREATE TABLE IF NOT EXISTS {$this->tbTransportModelName} (
            ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
            manufacturer_name VARCHAR( 100 ) NOT NULL, 
            model_name VARCHAR( 100 ) NOT NULL, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);" ;
            $db->exec($sqlTbTransportModelName);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function connect() {
        $this->config();
        $db = new PDO("mysql:dbname={$this->dbName};host={$this->host}",  $this->user, $this->psw);
        $db->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        return $db;
    }
    
}
