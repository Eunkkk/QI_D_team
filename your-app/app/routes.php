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
// Sensor rending page
//============================================================================================
$app->get('/sensor/listview', 'App\Controller\SensorController:sensor_userlist_view_page')
    ->setName('sensorlistview');


//============================================================================================
// Sensor rending page
//============================================================================================
       
$app->get('/data/heart', 'App\Controller\DataController:data_heartrate_page')
    ->setName('dataheartrate');

$app->get('/data/airquality', 'App\Controller\DataController:data_airquality_page')
    ->setName('dataairquality');



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

$app->post('/sensor/registration', 'App\Controller\SensorController:sensor_registraion_request')
    ->setName('sensorregister');

$app->post('/sensor/deregistration/request', 'App\Controller\SensorController:sensor_deregistration_request')
    ->setName('sensorderegister');

$app->post('/sensor/app/deregistration/request', 'App\Controller\SensorController:app_sensor_deregistration_request')
    ->setName('sensorderegister');

$app->post('/sensor/userlistview/request', 'App\Controller\SensorController:sensor_userlist_view_request')
->setName('sensorlisttview');

$app->post('/sensor/app/userlistview/request', 'App\Controller\SensorController:app_sensor_userlist_view_request')
->setName('sensorapplistview');



//============================================================================================
// Data Management API
//============================================================================================

$app->post('/data/airquality/transfer', 'App\Controller\DataController:data_airquality_transfer_request')
    ->setName('datatransfer');

    
$app->post('/data/heartrate/transfer', 'App\Controller\DataController:data_heartrate_transfer_request')
->setName('datatransfer');



//============================================================================================
// Data Monitoring
//============================================================================================

$app->post('/data/get/real/airquality', 'App\Controller\DataController:select_realtime_data_from_airquality_table')
    ->setName('getrealairquality');

    
$app->post('/app/data/get/real/airquality', 'App\Controller\DataController:app_select_realtime_data_from_airquality_table')
->setName('getrealairquality'); // app

$app->post('/data/get/real/heartrate', 'App\Controller\DataController:select_realtime_data_from_heartrate_table')
    ->setName('getrealheart');

$app->post('/data/get/historical/airquality', 'App\Controller\DataController:select_historical_data_from_airquality_table')
->setName('gethistoricalairquality'); // This data is  for chart

$app->post('/data/get/historical/airquality/marker', 'App\Controller\DataController:marker_select_historical_data_from_airquality_table')
->setName('markerthistoricalairquality'); // This data is  for map

$app->post('/app/data/get/historical/airquality', 'App\Controller\DataController:app_select_historical_data_from_airquality_table')
->setName('apphistoricalairquality'); 


$app->post('/data/get/historical/heartrate', 'App\Controller\DataController:select_historical_heartrate_data_from_heartrate_table')
    ->setName('gethistoricalairquality'); 

    
    

$app->get('/test', 'App\Controller\UserController:test')
->setName('gethistoricalairquality');