<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
include '../lib/common.php';


$headers = apache_request_headers();

foreach ($headers as $header => $value) {
    if($header=='Authorization')
      $auth = $value; 
}

// echo "SELECT * FROM sessions where LOWER(`condition`) LIKE LOWER('%auth%')";
$session = db_query_array('SELECT * FROM `sessions` WHERE `sessions`.`session_key`="'.$auth.'"');
$account = User::getInfo($session[0]['session_id']);
$info = User::setInfo($account);
// $count=false,$page=false,$per_page=false,$c_currency=false,$currency=false,$user=false,$start_date=false,$type=false,$order_by=false,$order_desc=false,$public_api_all=false,$dont_paginate=false
$transaction = Transactions::get(false,false,false,$account['default_c_currency'], $account['default_currency'], $session[0]['user_id'] );
echo json_encode($transaction);
// $result = db_query_array("SELECT site_users.*, site_users_access.start AS `start`, site_users_access.last AS `last`, site_users_access.attempts AS attempts FROM site_users LEFT JOIN site_users_access ON (site_users_access.site_user = site_users.id) WHERE ".(($user_id > 0) ? "site_users.id = $user_id" :  "site_users.user = '$user1'"));

?>

