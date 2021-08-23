<?php

namespace Register;

use Database\Database as Database;

class Register extends Database {

    /*
        Register
    */
    protected function getAllRegisters(string $text = '', string $searchby = ''){

        $searcSQL = "";
        if($text != ''){
            $searcSQL = $this->searchRegister($text, $searchby);
        }

        $sql = "SELECT {$this->tbTransportName}.ID, 
        {$this->tbTransportName}.plates, 
        {$this->tbTransportName}.model_id, 
        {$this->tbTransportName}.fuel_tank_volume, 
        {$this->tbTransportName}.average_fuel_consumption, 
        {$this->tbTransportModelName}.manufacturer_name, 
        {$this->tbTransportModelName}.model_name FROM 
        {$this->tbTransportName} LEFT JOIN {$this->tbTransportModelName} ON 
        {$this->tbTransportName}.model_id = {$this->tbTransportModelName}.ID $searcSQL ORDER BY ID DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$text]);
        return $stmt->fetchAll();
    }

    protected function searchRegister(string $search, string $searchby){
        $output = '';
        switch ($searchby) {
            case 'plates':
                $output = "WHERE {$this->tbTransportName}.plates = ?";
                break;
            case 'manufacturer_name':
                $output = "WHERE {$this->tbTransportModelName}.$searchby = ?";
                break;
            case 'model_name':
                $output = "WHERE {$this->tbTransportModelName}.$searchby = ?";
                break;
        }
        return $output;
    }

    protected function getRegister(string $type, string $value, string $all = ''){
        $sql = "SELECT * FROM {$this->tbTransportName} WHERE {$type} = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$value]);
        if($all == 'all'){
            return $stmt->fetchAll();
        }else{
            return $stmt->fetch();
        }
    }

    protected function setRegister(array $args){
        $output = '';
        try {
            $sql = "INSERT INTO {$this->tbTransportName} (plates, model_id, fuel_tank_volume, average_fuel_consumption) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$args['plates'], $args['model_id'], $args['fuel_tank_volume'], $args['average_fuel_consumption']]);
        } catch(PDOException $e) {
            $output .= $e->getMessage();
        }
        return $output;
    }

    protected function updateRegister(array $args){
        $output = '';
        try {
            $sql = "UPDATE {$this->tbTransportName} SET plates = ?, model_id = ?, fuel_tank_volume = ?, average_fuel_consumption = ?, updated_at = NOW() WHERE ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$args['plates'], $args['model_id'], $args['fuel_tank_volume'], $args['average_fuel_consumption'], $args['ID']]);
        } catch(PDOException $e) {
            $output .= $e->getMessage();
        }
        return $output;
    }

    protected function deleteRegister(int $id){
        $output = '';
        try {
            $sql = "DELETE FROM {$this->tbTransportName} WHERE ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
        } catch(PDOException $e) {
            $output .= $e->getMessage();
        }
        return $output;
    }

    protected function getPlatesMatch(string $plates, int $id){
        $platesArr = $this->getRegister('plates', $plates, 'all');
        if(empty($platesArr)){
            $return = false;
        }else{
            if(count($platesArr) > 1){
                $return = true;
            }else{
                $return = $platesArr[0]['ID'] == $id ? false : true;
            }
        }
        return $return;
    }

    /*
        Models
    */

    protected function setModel(array $args){
        $modelMatch = $this->getModelMatch($args['manufacturer_name'], $args['model_name']);
        if(!empty($modelMatch)){
            return $modelMatch['ID'];
        }
        $connect = $this->connect();
        $sql = "INSERT INTO {$this->tbTransportModelName} (manufacturer_name, model_name) VALUES (?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$args['manufacturer_name'], $args['model_name']]);
        return $connect->lastInsertId();
    }

    protected function getModel(string $type, string $value){
        $sql = "SELECT * FROM {$this->tbTransportModelName} WHERE {$type} = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    protected function getModelMatch(string $manufacturer_name, string $model_name){
        $sql = "SELECT * FROM {$this->tbTransportModelName} WHERE manufacturer_name = ? AND model_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$manufacturer_name, $model_name]);
        return $stmt->fetch();
    }

    protected function updateModel(array $args){
        $sql = "UPDATE {$this->tbTransportModelName} SET manufacturer_name = ?, model_name = ?, updated_at = NOW() WHERE ID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$args['manufacturer_name'], $args['model_name'], $args['model_id']]);
    }

    protected function deleteModel(int $id){
        $sql = "DELETE FROM {$this->tbTransportModelName} WHERE ID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

    protected function predictedDistance(string $tank, string $average){
        $math = $tank/$average*100;
        return round($math, 2);
    }

}
