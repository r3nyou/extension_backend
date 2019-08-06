<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->get_password();

$user_arr = array(
	'sn' => $user->sn,
	'id' => $user->id,
	'password' => $user->password,
	'email' => $user->email
);

print_r(json_encode($user_arr));