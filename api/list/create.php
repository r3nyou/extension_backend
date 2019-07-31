<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Lists.php';

$database = new Database();
$db = $database->connect();

$lists = new Lists($db);

$data = json_decode(file_get_contents("php://input"));

$lists->user_id = $data->id;
$lists->black_url = $data->blackUrl;
$lists->white_url = $data->whiteUrl;

if($lists->create()) {
	echo json_encode(
		array(
			'message' => 'lists Created',
			'id' => $lists->user_id
		)
	);
} else {
	echo json_encode(
		array('message' => 'lists Not Created')
	);
}