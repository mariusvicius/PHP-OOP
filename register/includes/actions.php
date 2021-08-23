<?php
require_once 'autoload.php';


$registerView = new Register\RegisterView();
$registerController = new Register\RegisterController();

if($_POST['action'] == 'newTransport'){

    $form = [
        'form_title'    => 'Pridėti transportą',
        'form_button'   => 'Pridėti',
        'form_action'   => 'addtransport',
        'id'            => '',
        'form' => [
            'plates' => [
                'text' => 'Valstybinis numeris',
                'value' => '',
                'type' => 'text'
            ],
            'manufacturer_name' => [
                'text' => 'Gamintojas',
                'value' => '',
                'type' => 'text'
            ],
            'model_name' => [
                'text' => 'Modelis',
                'value' => '',
                'type' => 'text'
            ],
            'fuel_tank_volume' => [
                'text' => 'Kuro bako talpa (l)',
                'value' => '',
                'type' => 'number'
            ],
            'average_fuel_consumption' => [
                'text' => 'Vidutinis kuro sunaudojimas (l/100 km)',
                'value' => '',
                'type' => 'number'
            ],
        ]
    ];

    echo $registerView->registerForm($form);
}

if($_POST['action'] == 'edittransport'){

    $id = intval($_POST['id']);
    $transport = $registerController->getRegisterByID($id);
    $form = [
        'form_title'    => 'Redaguoti transportą',
        'form_button'   => 'Atnaujinti',
        'form_action'   => 'updatetransport',
        'id'            => $id,
        'form' => [
            'plates' => [
                'text' => 'Valstybinis numeris',
                'value' => $transport['plates'],
                'type' => 'text'
            ],
            'manufacturer_name' => [
                'text' => 'Gamintojas',
                'value' => $transport['manufacturer_name'],
                'type' => 'text'
            ],
            'model_name' => [
                'text' => 'Modelis',
                'value' => $transport['model_name'],
                'type' => 'text'
            ],
            'fuel_tank_volume' => [
                'text' => 'Kuro bako talpa (l)',
                'value' => $transport['fuel_tank_volume'],
                'type' => 'number'
            ],
            'average_fuel_consumption' => [
                'text' => 'Vidutinis kuro sunaudojimas (l/100 km)',
                'value' => $transport['average_fuel_consumption'],
                'type' => 'number'
            ]
        ]
    ];

    echo $registerView->registerForm($form);
}

if($_POST['action'] == 'deletetransport'){

    $id = intval($_POST['id']);
    $transport = $registerController->getRegisterByID($id);
    $form = [
        'form_title'    => 'Ar tikrai norite naikinti šį transportą?',
        'form_button'   => 'Panaikinti',
        'form_action'   => 'removetransport',
        'id'            => $id,
        'form' => [
            'plates' => [
                'text' => 'Valstybinis numeris',
                'value' => $transport['plates'],
                'type' => 'text'
            ],
            'manufacturer_name' => [
                'text' => 'Gamintojas',
                'value' => $transport['manufacturer_name'],
                'type' => 'text'
            ],
            'model_name' => [
                'text' => 'Modelis',
                'value' => $transport['model_name'],
                'type' => 'text'
            ],
            'fuel_tank_volume' => [
                'text' => 'Kuro bako talpa (l)',
                'value' => $transport['fuel_tank_volume'],
                'type' => 'number'
            ],
            'average_fuel_consumption' => [
                'text' => 'Vidutinis kuro sunaudojimas (l/100 km)',
                'value' => $transport['average_fuel_consumption'],
                'type' => 'number'
            ]
        ]
    ];

    echo $registerView->registerForm($form);
}

if($_POST['action'] == 'addtransport'){
    
    $output = [];
    $form = [
            'plates' => htmlspecialchars($_POST['plates']),
            'manufacturer_name' => htmlspecialchars($_POST['manufacturer_name']),
            'model_name' => htmlspecialchars($_POST['model_name']),
            'fuel_tank_volume' => htmlspecialchars($_POST['fuel_tank_volume']),
            'average_fuel_consumption' => htmlspecialchars($_POST['average_fuel_consumption'])
    ];

    $createMsg = $registerController->createRegister($form);
    
    if($createMsg == ''){
        $output['text'] = 'Duomenys išsaugoti'; 
        $output['error'] = false; 
    }else{
        $output['text'] = $createMsg; 
        $output['error'] = true; 
    }

    $output = json_encode($output);

    echo $output;

}

if($_POST['action'] == 'updatetransport'){
    
    $output = [];
    $form = [
            'ID' => intval($_POST['id']),
            'plates' => htmlspecialchars($_POST['plates']),
            'manufacturer_name' => htmlspecialchars($_POST['manufacturer_name']),
            'model_name' => htmlspecialchars($_POST['model_name']),
            'fuel_tank_volume' => htmlspecialchars($_POST['fuel_tank_volume']),
            'average_fuel_consumption' => htmlspecialchars($_POST['average_fuel_consumption'])
    ];

    $createMsg = $registerController->updateRegisterData($form);

    if($createMsg == ''){
        $output['text'] = 'Duomenys išsaugoti'; 
        $output['error'] = false; 
    }else{
        $output['text'] = $createMsg; 
        $output['error'] = true; 
    }

    $output = json_encode($output);
    echo $output;

}

if($_POST['action'] == 'removetransport'){
    $output = [];
    $form = [
            'ID' => intval($_POST['id'])
    ];

    $createMsg = $registerController->removeRegisterData($form);

    if($createMsg == ''){
        $output['text'] = 'Duomenys panaikinti'; 
        $output['error'] = false; 
    }else{
        $output['text'] = $createMsg; 
        $output['error'] = true; 
    }

    $output = json_encode($output);
    echo $output;
}

if($_POST['action'] == 'updatelist'){
    
    echo $registerView->showAllRegisters();

}

if($_POST['action'] == 'search'){
    
    $searchText = htmlspecialchars($_POST['search']);
    $searchBy   = htmlspecialchars($_POST['search-by']);

    echo $registerView->showAllRegisters($searchText, $searchBy);

}
