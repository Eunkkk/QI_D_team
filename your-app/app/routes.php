<?php
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

//코멘트 달기
$app->get('/user/account/activate/{nonce}', 'App\Controller\UserController:account_activate')
    ->setName('useraccountactivate');

$app->post('/user/signin/request', 'App\Controller\UserController:sign_in_request')
    ->setName('usersigninrequest');

$app->get('/user/signin', 'App\Controller\UserController:sign_in_page')
    ->setName('usersignin');

$app->get('/user/signup', 'App\Controller\UserController:sign_up')
    ->setName('usersignup');

$app->post('/user/signup/request', 'App\Controller\UserController:sign_up_request')
    ->setName('usersignuprequest');

$app->get('/user/signout', 'App\Controller\UserController:sign_out')
    ->setName('usersignout');

$app->get('/user/pwchange', 'App\Controller\UserController:pw_change')
    ->setName('userpwchange');

$app->get('/user/fpwchange', 'App\Controller\UserController:forgotton_pw_change')
    ->setName('userforgottenpwchange');

$app->get('/user/idcancellation', 'App\Controller\UserController:ID_cancellation')
    ->setName('useridcancellation');

$app->post('/user/duplicatecheck', 'App\Controller\UserController:duplicate_check')
    ->setName('userduplicatecheck');

// $app->post('/user/signuprequest', 'App\Controller\UserController:sign_up_request')
//     ->setName('usersignuprequest');

//===================================================================================================================

$app->post('/sensor/register', 'App\Controller\SensorController:sensor_register')
    ->setName('sensorregister');

$app->post('/sensor/association', 'App\Controller\SensorController:sensor_association')
    ->setName('sensorassociation');

$app->post('/sensor/deregister', 'App\Controller\SensorController:sensor_deregister')
    ->setName('sensorderegister');

$app->post('/sensor/deassociation', 'App\Controller\SensorController:sensor_deassociation')
    ->setName('sensordeassociation');

//===================================================================================================================




/*
User password change
Forgotten password upate
ID Cancellation
Adminisotr user lsit
*/
