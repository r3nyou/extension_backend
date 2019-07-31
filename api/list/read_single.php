<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Lists.php';

$database = new Database();
$db = $database->connect();

$lists = new Lists($db);
$lists->user_id = isset($_GET['id']) ? $_GET['id'] : die();

$lists->read_single();

$lists_arr = array(
	'blackUrl' => $lists->black_url,
	'whiteUrl' => $lists->white_url,
);

print_r(json_encode($lists_arr));