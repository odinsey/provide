<?php
	function sql($requete){
		$requete=$requete;
		$resultat_requete=mysql_query($requete)or die('requete =>'.$requete.'<br> error ->'.mysql_error());
		$liste=mysql_fetch_array($resultat_requete);
		
		return($liste);
	};
	
		function sql_sans_fetch($requete){
		$requete=$requete;
		$resultat_requete=mysql_query($requete)or die('requete =>'.$requete.'<br> error ->'.mysql_error());
		
		return($resultat_requete);
	};
	
	function query($requete){
		$requete=$requete;
		mysql_query($requete)or die('requete =>'.$requete.'<br> error ->'.mysql_error());
		
	};
	
	function VerifierAdresseMail($adresse)
{
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($Syntaxe,$adresse))
      return true;
   else
     return false;
}

function filter2($in) {
	$search = array ('@[&eacute;èêëÊË]@i','@[&agrave;âäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[.&€\#|°^<>=+*!?;:,$¨%µ]@i','@[^a-zA-Z0-9_]@');
	$replace = array ('e','a','i','u','o','c','_','');
	return preg_replace($search, $replace, $in);
};

	function cleanuserinput($dirty){
	$dirty=nl2br($dirty);
	if (get_magic_quotes_gpc()) {
	$clean = mysql_real_escape_string(stripslashes($dirty));
	}else{
	$clean = mysql_real_escape_string($dirty);
	}
			$ar='^"^';
			$r="'";
			$clean=preg_replace($ar,$r,$clean);
	
	return $clean;
	}	

	function envoi_mail($message,$mail,$smtp,$sujet,$from){
			$entete = 'From: '.$from.''."\n";
			$entete .='Content-Type: text/html; charset="iso-8859-1"'."\n";
			$entete .='Content-Transfer-Encoding: 8bit'; 
			ini_set('SMTP', $smtp); 					
			mail($mail, $sujet, $message,$entete); 
	};	
	
?>