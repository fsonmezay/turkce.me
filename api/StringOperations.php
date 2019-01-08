<?php
class StringOperations{
	
	/* 	this function generates seacrh engine friendly text from a given string
	 *
	* if
	* $string is "Hello World!", the output will be "hello-world"
	* $string is "ƒ∞stanbul ≈û√ºkr√º Sara√ßoƒülu Stadƒ±", then the output will be "istanbul-sukru-saracoglu-stadi"
	*
	*/
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

	// finds the n'th occurrence of a char ($needle) in a given $string
	public function splitForNthOccurrence($string,$needle,$nth){
		$max = strlen($string);
		$n = 0;
		for($i=0;$i<$max;$i++){
			if($string[$i]==$needle){
				$n++;
				if($n>=$nth){
					break;
				}
			}
		}
		return substr($string,$i+1,$max);
	}
	
	// finds the n'th occurrence of a char ($needle) in a given $string
	public function findNthOccurenceIndex($string,$needle,$nth){
		$max = strlen($string);
		$n = 0;
		for($i=0;$i<$max;$i++){
			if($string[$i]==$needle){
				$n++;
				if($n>=$nth){
					break;
				}
			}
		}
		return $i+1;
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
	
	public function replaceEditorContentForDb($content){
		return htmlspecialchars($content, ENT_QUOTES);
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
	

	public function generateHTMLFromStringWithLTGT($string){
		$retVal = str_replace("&lt;", "<", $string);
		$retVal = str_replace("&gt;", ">", $retVal);
		$retVal = str_replace("&quot;", "\"", $retVal);
		return $retVal;
	}
	
	public function generateHTMLFromStringWithLTGT_reverse($string){
		$retVal = str_replace("<", "&lt;", $string);
		$retVal = str_replace(">", "&gt;", $retVal);
		$retVal = str_replace("\"","&quot;", $retVal);
		return $retVal;
	}
	
	function startsWith($haystack, $needle) {
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
	function endsWith($haystack, $needle) {
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
	
	function findFileExtension($fileName){
		//$path = $_FILES['image']['name'];
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		return $ext;
	}
}

?>
