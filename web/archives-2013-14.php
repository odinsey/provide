<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Collège La Providence - Olivet - Sorties pédagogiques 2013-2014</title>
<!-- InstanceEndEditable -->
<meta name="description" content="collège, catholique, la providence, olivet, enseignement" />
<meta name="language" content="FR" />
<meta name="site-languages" content="French" />
<meta name="Content-Language" content="fr-FR" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="shadowbox/shadowbox.css" />
<link rel="icon" type="image/ico" href="images/favicon.jpg" />
<script src="scripts/veriform.js" type="text/javascript"></script>
<script src="scripts/jquery.1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="scripts/routines.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="scripts/gmap3.js"></script> 
<script type="text/javascript" src="scripts/gmap3-include.js"></script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>
	<div id="papier-gauffre">
    	<div id="wrapper-haut">
        	<div id="bandeau-haut">
				<div id="etablissement-catholique"></div>
	            <div id="bouton-telechargement"><a href="telechargement.php"></a></div>
            </div>
			<div id="header"><!-- InstanceBeginEditable name="Flash" -->
                    <object type="application/x-shockwave-flash" data="swf/header-01.swf" width="1232" height="304">
                    <param name="movie" value="swf/header-01.swf" />
                    <param name="allowFullScreen" value="true" />
                    <param name="wmode" value="transparent" />
                    <img src="images/header.png" width="1232" height="301" alt="Collège La Providence - Olivet" />
                    </object>		
			<!-- InstanceEndEditable -->
			</div>
            <div id="menu">
            	<div id="bouton-presentation"></div>
                <div id="bouton-pastorale"></div>
                <div id="bouton-organisation"></div>
                <div id="bouton-examens"></div>
                <div id="bouton-medias"></div>
			</div>
            <div id="site">                
                <div id="colonne-gauche">
                    <div id="sous-menu-titre"><!-- InstanceBeginEditable name="Titre" -->
                    Archives
                    <!-- InstanceEndEditable -->
                    </div>
                    <div id="sous-menu"><!-- InstanceBeginEditable name="Sous-menu" -->
					<!-- InstanceEndEditable -->
                    </div>
                    <div id="sous-menu-bas"></div>
                    <div id="module-ecole"></div>
                    <div id="module-apel"></div>
                    <div id="module-enseignement"></div>
                    <div id="module-contact"></div>
                </div>   
                <div id="colonne-droite">
                	<div id="titre"><!-- InstanceBeginEditable name="Titre-Contenu" -->
                    	Soties pédagogiques 2013 - 2014 (archives)
					<!-- InstanceEndEditable -->
                  </div>
                  <div id="contenu">
				  <!-- InstanceBeginEditable name="Contenu" -->

<!--D&eacute;but de modèle pour Robin-->
<?php 

include("php/connexion.php");
require_once("php/req_func.php");
	$today=date("m/d/Y");
	$debut=explode("/","08/30/2013");
	$debut=$debut[2].$debut[0].$debut[1];
	$fin=explode("/","07/01/2014");
	$fin=$fin[2].$fin[0].$fin[1];
	
	$liste_voyage=sql_sans_fetch("SELECT * FROM scolaire_valid ORDER BY position");
	while($voyage=mysql_fetch_array($liste_voyage)){
	$fin2=explode("/",$voyage["date_scolaire"]);
	$fin2=$fin2[2].$fin2[0].$fin2[1];

		if($fin2>$debut and $fin2<$fin){
		$liste_actu_voyage=sql_sans_fetch("SELECT * FROM actu_voyage_valid WHERE id_scolaire=".$voyage["id_scolaire"]."");
			$affiche="(Terminé)";

?>
                        <div class="paragrapheOnOff"><?php echo $voyage["titre_scolaire"]." - ".$voyage["date_scolaire"][3].$voyage["date_scolaire"][4].$voyage["date_scolaire"][2].$voyage["date_scolaire"][0].$voyage["date_scolaire"][1]." au ".$voyage["date_fin_scolaire"][3].$voyage["date_fin_scolaire"][4].$voyage["date_fin_scolaire"][2].$voyage["date_fin_scolaire"][0].$voyage["date_fin_scolaire"][1]." ".$affiche; ?></div>
                        <div class="accordeon">
                            <div class="voyage-gauche">
								<?php 
									if($voyage["url_fichier_scolaire"]<>""){ ?>
									<a href="docs/<?php echo $voyage["url_fichier_scolaire"]; ?>" onclick="window.open('docs/<?php echo $voyage["url_fichier_scolaire"]; ?>');return false">
									<img src="images/PDF.png" alt="<?php echo $voyage["titre_scolaire"]; ?>" width="50" height="77" /></a>
								<?php
									};
								?>
                            </div>        
                            <div class="voyage-droite">
                                <p><?php echo $voyage["texte_scolaire"]; ?></p>
                            </div> 
                            <br class="clearer" />   

<?php
		while($actu_voyage=mysql_fetch_array($liste_actu_voyage)){
			$liste_photo_actu=sql_sans_fetch("SELECT * FROM photo_valid WHERE id_actu_voyage=".$actu_voyage["id_actu_voyage"]."");
?>
							<div class="voyage-quotidien">

                                <h2><?php echo $actu_voyage["titre_actu_voyage"]; ?></h2>
								
                                <div class="voyage-vignette">						
								<?php								
								echo "
									<a href='photo/".$actu_voyage["url_photo_actu_voyage"]."' rel='shadowbox[galerie".$actu_voyage["id_actu_voyage"]."]' title='".$actu_voyage["titre_actu_voyage"]."'>
									<img src='photo/mini".$actu_voyage["url_photo_actu_voyage"]."' alt='".$actu_voyage["titre_actu_voyage"]."' width='146' height='82' />
									</a>";

								$i=1;
								while($photo_actu=mysql_fetch_array($liste_photo_actu)){

										echo "<a href='photo/".$photo_actu["url_photo"]."' rel='shadowbox[galerie".$actu_voyage["id_actu_voyage"]."]' title='".$photo_actu["titre_photo"]."<br>".$photo_actu["texte_photo"]."'></a>";
								};
								?>
                                </div>

                                <div class="voyage-compte-rendu">
									<p><?php echo $actu_voyage["texte_actu_voyage"]; ?></p>
                                    <a href="<?php echo $actu_voyage["url_actu_voyage"]; ?>" onclick="window.open('<?php echo $actu_voyage["url_actu_voyage"]; ?>');return false">
                                    <?php echo $actu_voyage["nom_url_actu_voyage"]; ?>
                                    </a>                                
                                    
                                </div>
                                <br class="clearer" />
                            
                            </div>



<!--R&eacute;p&eacute;tion des blocs quotidien (2)-->


<?php

		};
		echo "</div>";
	};
	};
?>

<!--Fin du modèle-->
		  
                  <!-- InstanceEndEditable -->
                  	<br class="clearer" />
                  </div>
                    <div id="footer-contenu"></div>
	            </div>
			</div>   
	    </div>
        <br class="clearer" />
        <div id="wrapper-bas">
            <div id="footer-vague"></div>
            <div id="footer-adresse"></div>
            <div id="footer-mentions"></div>
        </div>
	</div>    
	<div id="w3c">
        <a href="http://validator.w3.org/check?uri=referer" onclick="window.open('http://validator.w3.org/check?uri=referer');return false">
        <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer" onclick="window.open('http://jigsaw.w3.org/css-validator/check/referer');return false">
        <img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="CSS Valide !" />
        </a>
    </div>
</body>
<!-- InstanceEnd --></html>
