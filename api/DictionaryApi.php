<?php

include './DBOperations.php';
include './SettingOperations.php';
include './StringOperations.php';

$dbOp = new DBOperations ();
$settingsOp = new SettingOperations ();
$stringOp = new StringOperations ();

date_default_timezone_set ( $settingsOp->getSiteSettingsFromKey ( "default_timezone" ) );
//$result = array();
/*$result[] = $settingsOp->getSiteSettingsFromKey ( "default_timezone" );
$result[] = $settingsOp->getSiteSettingsFromKey ( "uygulama_aktif_mi" );
$result[] = "Software Developer";
$result[] = "Insert Etmek";
$result[] = "Software";
$result[] = "Software Engieer";
$result[] = "Persist Etmek";*/

//$result = $dbOp->select($query);

if(isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    $_POST = array_merge($_POST, (array) json_decode(trim(file_get_contents('php://input')), true));
}
if(isset($_POST['query']) && strlen($_POST['query']) > 0) {
	$searchKey = $stringOp->veri_replace($_POST['query']);
	$query = "SELECT locution, locution_key FROM locutions where state = 1 and locution like '%".$searchKey."%' order by locution";
	$result = $dbOp->select($query);
}
else {
	$result = [];
}

header ( 'Content-Type: application/json' );
echo json_encode ( $result );
?>
