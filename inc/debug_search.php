<?php
#!# 1.1
require 'global_html.php';
require 'config.php';

if(!is_numeric($_POST['addLineAfter'])){
	$_POST['addLineAfter'] = 0;
}

switch($_REQUEST['act']){
	case 's':
		echo "<form action=\"debug_search.php\" method=\"post\">";
		echo "<input type=\"text\" name=\"sTxt\" id=\"sTxt\" value=\"".$_POST['sTxt']."\" size=20>";
		echo "<input type=\"submit\" name=\"btn\" id=\"btn\" value=\"trouver\"><input type='hidden' name='act' value='l'>";
		echo "</form>";
		//search($_POST['sTxt']);
	break;
	case 'l':
		echo "<form action=\"debug_search.php\" method=\"post\">";
		echo "<input type=\"text\" name=\"sTxt\" id=\"sTxt\" value=\"".$_POST['sTxt']."\" size=20>";
		echo "<input type=\"submit\" name=\"btn\" id=\"btn\" value=\"trouver\"><input type='hidden' name='act' value='l'><br/>";
		echo "Montrer <input type=\"text\" name=\"addLineAfter\" id=\"addLineAfter\" value=\"".$_POST['addLineAfter']."\" size=2> lignes en plus";
		echo "</form>";
		search($_POST['sTxt'], __dir__ ."/../", false, false, $_POST['addLineAfter']);
		//echo $_POST['sTxt']."<br/>";
		//search(htmlentities($_POST['sTxt']), _BasePath);	
	break;
}

function search($txt, $dir, $recursed=false, $debug=false, $addLineAfter=0){
	// Open a known directory, and proceed to read its contents
	$lastLineGrepped = false;
	if (is_dir($dir)) {
	   if ($dh = opendir($dir)){
	       $o=0;
		   if($debug)
				echo $dir . $file."<br/>";
		   
		   # each file
		   while (($file = readdir($dh)) !== false){
				if($debug)
					echo $dir . $file."<br/>";
		       	if (!is_dir($dir . $file) && is_file($dir . $file)){
			       	$ext=substr($file,-3,3);
					if ($ext=="php" || $ext==".js" || $ext=="css"){
			       		$tmpFileLine = file($dir.$file);
			       		
			       		$j=1;
			       		$file1 = "<BR><hr/>".$dir."<br/><b>".htmlLink($file, "#")." (".$addLineAfter.")</B><BR>";
						if(!empty($txt)){
    						$tmpBuf="";
    			       		
							# each line
							foreach($tmpFileLine as $aa){
								# do not search those
								if(!strstr($file, 'editor_') && !strstr($file, 'jquery') && !strstr($file, 'round.corner') && 
									!strstr($file, 'tiny_mce')&& !strstr($file, 'audio-player')){
									$x = analyseLine($aa,$file,$j,$txt);
									# found
									if ($x){
										$tmpBuf .= $x;
										$lastLineGrepped = true;
										$curAddLineAfter = $addLineAfter;
									}elseif($curAddLineAfter > 0 && $lastLineGrepped){
										$tmpBuf .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities($aa)."<br/>";
										$curAddLineAfter --;
										if($curAddLineAfter <= 0)
											$lastLineGrepped = false;
									}else{
										$lastLineGrepped = false;
									}
									$j++;
								}
    		       			}
						}else
							echo "\"$file\" => ".$o++.",<BR>";
		       			if (!empty($tmpBuf))
		       				echo $file1,$tmpBuf;
		       		}
	       		}elseif(is_dir($dir . $file)){
					#####
					#	EXCLUDED SUB-DIR
					#####
					if($file != "audio" && $file != "pictures" && $file != "." && $file != ".."){
						//echo "<b>".$dir . $file."/</b><br />";
						search($txt, $dir . $file."/", true, false);
					}
				}
				//echo "filename: $file : filetype: " . filetype($dir . $file) . "<BR>";
	       }
	    closedir($dh);
	    if(!$recursed) 
			buffer(true);
	   }else
			echo "Cannot open dir";
	}else
		echo $dir." is no a dir";
}

function analyseLine($line, $fileName,$lineNum,$txt){
	$lineX = strtoupper ($line);
	$txt = strtoupper($txt);
	if (strstr($lineX,$txt)){
			buffer(); //Nb de select
			$showResult = htmlentities($line);
			return "&nbsp;&nbsp;&nbsp;&nbsp;($lineNum) ".preg_replace("/(".trim($txt).")/i" ,"<span style='background-color:#FFC79A;'>$1</span>" ,$showResult)."<br>";
	}
	return false;
}

function buffer($show=false){
	static $x=0;
	if ($show){
		echo "<BR><BR>NB DE RESULTAT(S) -> $x";
	}else
		$x++;
}

?>