<?php

namespace Register;

class RegisterView extends Register {
    
    public function showAllRegisters(string $text = '', string $searchby = ''){
        $registers = $this->getAllRegisters($text, $searchby);
        $output = '<table class="register-table">';
        if(!empty($registers)){
            $headArgs = [
                'Valstybinis numeris',
                'Gamintojas ir modelis',
                'Kuro bako talpa (l)',
                'Vidutinis kuro sunaudojimas (l/100 km)',
                'Prognozuojama distancija',
                'Veiksmai'
            ];

            $output .= $this->registerTableHeader($headArgs);

            foreach ($registers as $row) {
                $rowArgs = [
                    'ID'                        => $row['ID'],
                    'plates'                    => $row['plates'],
                    'manufacturer_name'         => $row['manufacturer_name'],
                    'model_name'                => $row['model_name'], 
                    'fuel_tank_volume'          => $row['fuel_tank_volume'], 
                    'average_fuel_consumption'  => $row['average_fuel_consumption'],
                    'predicted'                 => $this->predictedDistance($row['fuel_tank_volume'], $row['average_fuel_consumption'])
                ];

                $output .= $this->registerTableRow($rowArgs);
            }
        }else{
            $output .= '<tr><td>Nerasta nė vienos transporto priemonės.</td></tr>';
        }
        $output .= '</table>';
        return $output;
    }

    public function registerTableRow(array $args){
        $output = '<tr id="transport-'.$args['ID'].'" class="transport-row" data-id="'.$args['ID'].'">
            <td class="cell">'.$args['plates'].'</td>
            <td class="cell">'.$args['manufacturer_name'].' '.$args['model_name'].'</td>
            <td class="cell">'.$args['fuel_tank_volume'].'</td>
            <td class="cell">'.$args['average_fuel_consumption'].'</td>
            <td class="cell">'.$args['predicted'].'</td>
            <td class="cell">
                <a href="#" title="Redaguoti" onclick="edittransport(this);  return false;" class="edit-register"><img src="'.baseurl().'assets/images/edit.png" /></a> 
                <a href="#" title="Trinti" onclick="removetransport(this);  return false;" class="remove-register"><img src="'.baseurl().'assets/images/bin.png" /></a>
            </td>
        </tr>';
        return $output;
    }

    public function registerTableHeader(array $args){
        $output = '<tr class="row">';
            foreach($args as $arg){
                $output .= '<th class="cell">'.$arg.'</th>';
            }
        $output .= '</tr>';
        return $output;
    }

    public function registerForm(array $args){
        $output = '<form id="register-form">';
        $output .= '<h4>'.$args['form_title'].'</h4>';
        foreach($args['form'] as $k=>$v){
            $step = $v['type'] == 'number' ? 'step="0.001"' : '';
            $output .= '<p>
                <label>'.$v['text'].'</label>
                <input class="input-text" type="'.$v['type'].'" '.$step.' name="'.$k.'" value="'.$v['value'].'"/>
            </p>';
        }
        $output .= '<input type="hidden" name="action" value="'.$args['form_action'].'" >';
        if($args['id'] != ''){
            $output .= '<input type="hidden" name="id" value="'.$args['id'].'" >';
        }
        $removeClass = $args['form_action'] == 'removetransport' ? 'remove-btn' : '';
        $output .= '<p><input type="submit" class="form-submit '.$removeClass.'" value="'.$args['form_button'].'" ></p>';
        $output .= '</form>';
        return $output;
    }


}
