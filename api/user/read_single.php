<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->read_single();

$user_arr = array(
	'id' => $user->id,
	'password' => $user->password,
	'email' => $user->email
);

print_r(json_encode($user_arr));