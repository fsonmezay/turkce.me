<?php
class SettingOperations {
	public static $settingsTable = "tm_app_config";
	
	public function getSiteSettingsFromKey($key){
		$dbOp = new DBOperations();
		$query = "SELECT value FROM  ".self::$settingsTable." t WHERE t.key='$key'";
		$sonuc = $dbOp->select($query)[0];
		return $sonuc['value'];
	}
}
?>