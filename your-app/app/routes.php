<?php
// Routes
//============================================================================================
// User rending page
//============================================================================================

$app->get('/', 'App\Controller\UserController:index')
    ->setName('index');

$app->get('/user/signup', 'App\Controller\UserController:sign_up_page')
    ->setName('usersignup');

$app->get('/user/signin', 'App\Controller\UserController:sign_in_page')
    ->setName('usersignin');

$app->get('/user/pwchange', 'App\Controller\UserController:pw_change_page')
    ->setName('userpwchange');

$app->get('/user/fpwchange', 'App\Controller\UserController:forgotton_pw_change_page')
    ->setName('userforgottenpwchange');

$app->get('/user/idcancellation', 'App\Controller\UserController:ID_cancellation_page')
    ->setName('useridcancellation');

$app->get('/user/index', 'App\Controller\UserController:user_index_page')
    ->setName('userindex');

//============================================================================================
// Application API
//============================================================================================

$app->post('/app/signup', 'App\Controller\AppController:app_signin_up_request')
    ->setName('appsignup');

$app->post('/app/account/actiavte/{nonce}', 'App\Controller\AppController:app_account_activate')
    ->setName('appaccountactivate');

$app->post('/app/signin', 'App\Controller\AppController:app_signin_in_request')
    ->setName('appsignin');

$app->post('/app/signout', 'App\Controller\AppController:app_signin_out_request')
    ->setName('appsignout');

$app->post('/app/pwchange', 'App\Controller\AppController:app_pw_change_request')
    ->setName('apppwchange');

$app->post('/app/fpwchange', 'App\Controller\AppController:app_forgotton_pw_change_request')
    ->setName('appforgottenpwchange');

$app->post('/app/resetpasswd/{nonce}', 'App\Controller\AppController:app_forgotton_pw_change_request2')
    ->setName('appforgottenpwchange');

$app->post('/app/idcancellation', 'App\Controller\AppController:app_ID_cancellation_request')
    ->setName('appidcancellation');

//============================================================================================
// User Management API
//============================================================================================

$app->get('/user/signin/activate/{nonce}', 'App\Controller\UserController:account_activate')
    ->setName('useraccountactivate');

$app->post('/user/signin/request', 'App\Controller\UserController:sign_in_request')
    ->setName('usersigninrequest');

$app->post('/user/signup/request', 'App\Controller\UserController:sign_up_request')
    ->setName('usersignuprequest');

$app->post('/user/signout/request', 'App\Controller\UserController:sign_out_request')
    ->setName('usersignoutrequest');

$app->post('/user/duplicatecheck', 'App\Controller\UserController:duplicate_check')
    ->setName('userduplicatecheck');

$app->post('/user/idcancellation/request', 'App\Controller\UserController:ID_cancellation_request')
    ->setName('useridcancellationrequest');

$app->post('/user/pwchange/request', 'App\Controller\UserController:pw_change_request')
    ->setName('userpwchangerequest');

$app->post('/user/fpwchange/request', 'App\Controller\UserController:forgotton_pw_change_request')
    ->setName('userforgottenpwchangerequest');

$app->get('/account/resetpasswd/{nonce}', 'App\Controller\UserController:account_resetpasswd')
    ->setName('accountreset');

$app->post('/account/resetpasswd2/{nonce}', 'App\Controller\UserController:account_resetpasswd2')
    ->setName('accountreset2');

//============================================================================================
// Sensor Management API
//============================================================================================

$app->post('/sensor/registration', 'App\Controller\SensorController:sensor_register_request')
    ->setName('sensorregister');

$app->post('/sensor/association', 'App\Controller\SensorController:sensor_association')
    ->setName('sensorassociation');

$app->post('/sensor/deregistration', 'App\Controller\SensorController:sensor_deregister')
    ->setName('sensorderegister');

$app->post('/sensor/dessociation', 'App\Controller\SensorController:sensor_deassociation')
    ->setName('sensordeassociation');

    
//============================================================================================
// Data Management API
//============================================================================================

$app->post('/data/transfer', 'App\Controller\DataController:data_transfer_request')
    ->setName('datatransfer');

// $app->post('/data/registration', 'App\Controller\SensorController:sensor_register_request')
//     ->setName('sensorregister');

//============================================================================================
// Maps API
//============================================================================================


$app->get('/    ', 'App\Controller\MapsController:defaulta')
    ->setName('defaultmap');

// example with red circles instead of pins
$app->get('/maps/circles', 'App\Controller\MapsController:circles')
    ->setName('circlesmap');

// fake sensor information
$app->get('/maps/fakesensors', 'App\Controller\MapsController:fakesensors')
    ->setName('fakesensorsmap');

$app->get('/maps/fakesensors_as_json', 'App\Controller\MapsController:fakesensors_as_json')
    ->setName('fakesensors_as_json');

/*
$app->get('/maps/newyork-as-json', 'App\Controller\MapsController:default')
    ->setName('defaultmap');
*/

$app->get('/maps/pokemonjson', 'App\Controller\MapsController:pokemonjson')
    ->setName('pokemapjson');


$app->get('/maps/pokemon', 'App\Controller\MapsController:pokemon')
    ->setName('pokemap');

$app->get('/mapjson', 'App\Controller\MapsController:mapjson')
    ->setName('pokemapjsonsfasdf');


$app->get('/maps/air', 'App\Controller\MapsController:map_air')
    ->setName('pokemapasdfsdf');
