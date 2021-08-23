<?php

namespace Register;

class RegisterController extends Register {

    public function createRegister(array $args){
        $plates = $this->getPlatesMatch($args['plates'], 0);

        if(!$plates){
            $model_id = $this->setModel($args);
            $args['model_id'] = $model_id;
            $output = $this->setRegister($args);
        }else{
            $output = 'Toks valstybinis numeris jau egzistuoja';
        }
        return $output;
    }

    public function getRegisterByID(int $id){
        $register = $this->getRegister('ID', $id);
        $model = $this->getModel('ID', $register['model_id']);
        $register['manufacturer_name'] = $model['manufacturer_name'];
        $register['model_name'] = $model['model_name'];
        return $register;
    }

    public function updateRegisterData(array $args){
        $plates = $this->getPlatesMatch($args['plates'], $args['ID']);
        $register = $this->getRegister('ID', $args['ID']);

        if(!$plates){
            $args['model_id'] = $register['model_id'];
            $this->updateModel($args);
            $output = $this->updateRegister($args);
        }else{
            $output = 'Toks valstybinis numeris jau egzistuoja';
        }
        return $output;
    }

    public function removeRegisterData(array $args){
        $register = $this->getRegister('ID', $args['ID']);
        $registerByModel = $this->getRegister('model_id', $register['model_id'], 'all');

        if(count($registerByModel) == 1){
            $this->deleteModel($register['model_id']);
        }
        $output = $this->deleteRegister($args['ID']);
        return $output;
    }



}
