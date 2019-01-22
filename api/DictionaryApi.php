<?php
session_start();
include './DBOperations.php';
include './SettingOperations.php';
include './StringOperations.php';
include './CommonOperations.php';

$dbOp = new DBOperations ();
$settingsOp = new SettingOperations ();
$stringOp = new StringOperations ();
$commonOp = new CommonOperations ();

date_default_timezone_set ( $settingsOp->getSiteSettingsFromKey ( "default_timezone" ));

function readInput() {
	$result = array();
	if(isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
		$result = array_merge($result, (array) json_decode(trim(file_get_contents('php://input')), true));
	}
	return $result;
}

function createDefinitions($definitions, $locutionId) {
	$stringOp = new StringOperations();
	$dbOp = new DBOperations();
	$result = array();
	$definitounCreatorSQL = "";
	foreach($definitions as $key => $val) {
		$definition = $stringOp->veri_replace($val);
		$definitionKey = $stringOp->seoFriendlyString($val);
		$query = "INSERT INTO tm_definitions (locution_id, definition, definition_key, creation_date, state) values(".$locutionId.", '".$definition."', '".$definitionKey."', '".date("YmdHis")."', 0);";
		if(!$dbOp->query($query)) {
			if($dbOp->getLastErrorNumber() == 1062) {
				//TODO: 
			}
		}
	}
	return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if(isset($_GET['query']) && strlen($_GET['query']) > 0) {
		$searchKey = $stringOp->veri_replace($_GET['query']);
		$query = "SELECT locution, locution_key, state FROM tm_locutions where locution like '%".$searchKey."%' order by locution LIMIT 5";
		$result["locutions"] = $dbOp->select($query);
		$result["isSuccess"] = count($result["locutions"]) > 0;
	}
	else if(isset($_GET['key']) && strlen($_GET['key']) > 0) {
		$item = $stringOp->veri_replace($_GET['key']);
		$query = "SELECT d.definition, d.definition_key, d.id, d.state FROM tm_locutions l, tm_definitions d where d.locution_id = l.id and l.locution_key='".$item."' order by d.definition";
		$result["isSuccess"] = true;
		$result["definitions"] = $dbOp->select($query);
		$result['locution'] = $dbOp->select("SELECT locution as name, state FROM tm_locutions where locution_key='".$item."'")[0];
	}
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$_POST = readInput();
	if($_POST['captcha'] != $_SESSION['digits']) {
		$result["isSuccess"] = false;
		$result["message"] = "Güvenlik kodu hatalı.";
	}
	else {
		$locution = $stringOp->veri_replace($_POST['searchKey']);
		$locutionKey = $stringOp->seoFriendlyString($locution);
		$checkByKeySQL = "SELECT id from tm_locutions l where l.locution_key='".$locutionKey."'";
		$checkResult = $dbOp->select($checkByKeySQL);
		$definitounCreatorSQL = "";
		if(sizeof($checkResult) == 0) {
			$insertKeySQL = "INSERT INTO tm_locutions (locution, locution_key, date_created, state) values('". $locution ."', '". $locutionKey ."', '". date('YmdHis') ."', 0)";
			if($dbOp->query($insertKeySQL)) {
				$insertedLocutionId = $dbOp->lastInsertId();
				createDefinitions($_POST['locutions'], $insertedLocutionId);
			}
			else {
				$result['isSuccess'] = false;
				$result['message'] = $locution." eklenirken hata oluştu ";
			}
		}
		else {
			$locutionId = $checkResult[0]["id"];
			createDefinitions($_POST['locutions'], $locutionId);
		}
		//TODO:
		$result["isSuccess"] = true;
		$result["locution_key"] = $locutionKey;
		$result["definitions"] = $_POST['locutions'];
		$result["isAfterSave"] = true;
	}
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { 
	$result = [];
}
else {
	$result = [];
}

header ( 'Content-Type: application/json' );
echo json_encode ( $result );
?>