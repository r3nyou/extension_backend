<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

//$user->sn = $data->sn;
$user->id = $data->id;
$user->password = $data->password;
$user->email = $data->email;

if($user->update()) {
	echo json_encode(
		array('message' => 'User Update')
	);
} else {
	echo json_encode(
		array('message' => 'User Not Update')
	);
}