<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT,POST,GET,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Origin,Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Lists.php';

$database = new Database();
$db = $database->connect();

$lists = new lists($db);

$data = json_decode(file_get_contents("php://input"));

$lists->user_id = $data->id;

if(isset($data->blackUrl)) {
	$lists->black_url = $data->blackUrl;

	if($lists->update('black_url')) {
		echo json_encode(
			array('message' => 'blackUrl Update')
		);
	} else {
		echo json_encode(
			array('message' => 'blackUrl Not Update')
		);
	}

} else if (isset($data->whiteUrl)) {
	$lists->white_url = $data->whiteUrl;

	if($lists->update('white_url')) {
		echo json_encode(
			array('message' => 'whiteUrl Update')
		);
	} else {
		echo json_encode(
			array('message' => 'whiteUrl Not Update')
		);
	}
}

