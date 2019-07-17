<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once 'uid.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id = guid();
$user->password = $data->password;
$user->email = $data->email;

if($user->create()) {
	echo json_encode(
		array(
			'message' => 'User Created',
			'id' => $user->id
		)
	);
} else {
	echo json_encode(
		array('message' => 'User Not Created')
	);
}