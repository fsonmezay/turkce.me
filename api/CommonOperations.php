<?php
class CommonOperations {

	public function prepareRandCode(){
		$random_id_length = 7;
		$rnd_id = crypt(uniqid(rand(),1));
		$rnd_id = strip_tags(stripslashes($rnd_id));
		$rnd_id = str_replace(".","",$rnd_id);
		$rnd_id = strrev(str_replace("/","",$rnd_id));
		$rnd_id = substr($rnd_id,0,$random_id_length);
		return strtoupper($rnd_id);
	}

	//Herhangi bir durumda sayfayi yonlendirmek icin kullanilacak fonksiyon
	public function yonlendir($url){
		echo ("
			<meta http-equiv=\"refresh\" content=\"0; url=$url\" />
			<script language=\"JavaScript\">
			<!--
			 eval(\"location='".$url."'\");
			//-->
			</script>
			");
		header('Location: '.$url);
	}

	public function insertCharAtPosition($currentString, $stringToBeInserted, $position){
		return substr($currentString, 0, $position).$stringToBeInserted.substr($currentString, $position);
	}
	
	//print easily
	public function printArray($array, $header = ""){
		echo "<pre>".$header."<hr>";
		print_r($array);
		echo "</pre>";
	}

	public function seoFriendlyString($string){
		$curChar = array("ç", "Ç", "ğ", "Ğ", "ı", "I", "İ", "ö", "Ö", "ş", "Ş", "ü", "Ü", " ");
		$newChar = array("c", "c", "g", "g", "i", "i", "i", "o", "o", "s", "s", "u", "u", "-");
		$myString = $string;
		for($i=0;$i<sizeof($curChar);$i++){
			$myString = str_replace($curChar[$i],$newChar[$i],$myString);
		}
		$myString = strtolower($myString);
		$myString = preg_replace("[^A-Za-z0-9-]", "", $myString);
		while(true){
			$myNewString = str_replace("--", "-", $myString);
			if(!strcmp($myNewString, $myString)){
				break;
			}
			$myString = $myNewString;
		}
		return $myString;
	}

	public function convertArrayToDelimiteredText($array, $delimiter = ","){
		$returnText="";
		$i=0;
		foreach ($array as $key => $val){
			if($i++ > 0){
				$virgul = "$delimiter ";
			}
			else{
				$virgul = "";
			}
			$returnText .= $virgul.$val;
		}
		return $returnText;
	}


	//replaces posted data
	public function veri_replace($deger){
		$son_deger=str_replace("'","&apos;",$deger);
		$son_deger=str_replace('"','&quot;',$son_deger);
		$son_deger=str_replace("<","&lt;",$son_deger);
		$son_deger=str_replace(">","&gt;",$son_deger);
		$son_deger=str_replace("\n", "<br>", $son_deger);
		return $son_deger;
	}

	//Bu fonksiyon Replace edilmis veriyi ters eski haline geritiyor.
	public function TERS_veri_replace($deger){
		$son_deger=str_replace("&apos;","'",$deger);
		$son_deger=str_replace('&quot;','"',$son_deger);
		$son_deger=str_replace("&lt;","<",$son_deger);
		$son_deger=str_replace("&gt;",">",$son_deger);
		$son_deger=str_replace("<br/>","\n",$son_deger);
		$son_deger=str_replace("<br>","\n",$son_deger);
		return $son_deger;
	}

	//display Alert
	public  function displayAlert($alertTitle, $message, $style){
		$alertMessage= "
		<div class=\"alert $style\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>";
			if(!is_null($alertTitle)){
				$alertMessage .= "<strong>".$alertTitle."</strong>";
			}
			$alertMessage .="<p>$message</p>
		</div>";
		echo $alertMessage;
	}

	public function prepareSessionMessage($sessionKey, $messageTitle, $message, $messageType, $displayed = false){
		$_SESSION[$sessionKey]['messageTitle'] = $messageTitle;
		$_SESSION[$sessionKey]['message'] = $message;
		$_SESSION[$sessionKey]['messageType'] = $messageType;
		$_SESSION[$sessionKey]['isDisplayed'] = $displayed;
		return $_SESSION[$sessionKey];
	}

}
?>
