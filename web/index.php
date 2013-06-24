<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template-actualites.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Collège La Providence - Olivet - Actualités</title>
<!-- InstanceEndEditable -->
<meta name="description" content="collège, catholique, la providence, olivet, enseignement" />
<meta name="language" content="FR" />
<meta name="site-languages" content="French" />
<meta name="Content-Language" content="fr-FR" />
<link href="css/style-actualites.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="shadowbox/shadowbox.css" />
<link rel="shortcut icon" type="image/jpg" href="favicon.jpg" />
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
                    ACTUALITES
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
                        <div id="titre">
						<!-- InstanceBeginEditable name="Titre-Contenu" -->
                    COLLEGE LA PROVIDENCE
					<!-- InstanceEndEditable -->
                        </div>
                        <div id="contenu">
                        <!-- InstanceBeginEditable name="Contenu" -->
<?php
include dirname(__DIR__) . '/app/autoload.php';
use Symfony\Component\Yaml\Parser;
$yaml = new Parser();
$value = $yaml->parse(file_get_contents(dirname(__DIR__) . '/app/config/parameters.yml'));
$parameters = $value['parameters'];
/* Connect to an ODBC database using driver invocation */
$dsn = 'mysql:dbname=' . $parameters['database_name'] . ';host=' . $parameters['database_host'];
try {
    $pdo = new \PDO($dsn, $parameters['database_user'], $parameters['database_password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
if( !empty($_GET['newspreview']) ){
    $sql_news = 'SELECT * FROM news as n WHERE n.id = '.$_GET['newspreview'].' ORDER BY n.position DESC';
}else{
    $sql_news = 'SELECT * FROM news as n WHERE n.published = 1 ORDER BY n.position DESC';
}
$sql_pictures = 'SELECT p.* FROM news_picture as np, picture as p WHERE p.id = np.picture_id AND np.news_id = :id ORDER BY p.position';
$results = $pdo->query($sql_news);
if( $results ){
    while ($row = $results->fetch()) {?>
        <div class="actualite">
            <div class="titre-actualites"><?php echo $row['title'] ?></div>
            <div class="vignette-actualites">
            <?php
            $stmt = $pdo->prepare($sql_pictures);
            $results_img = $stmt->execute(array(':id' => $row['id']));
            $i = 0;
            if($results_img){
            while ($picture = $stmt->fetch()) { ?>
                <?php if ($i == 0) { ?>
                <a href="<?php echo strtolower(str_replace('##TYPE##','big',$picture['path'])) ?>" title="<?php echo $picture['title'] ?>" rel="shadowbox[<?php echo $row['title'] ?>]">
                <img src="<?php echo strtolower(str_replace('##TYPE##','thumb2',$picture['path'])) ?>" alt="<?php echo $picture['title'] ?>" /></a><?php $i++;
                }else{ ?>
                    <a href="<?php echo strtolower(str_replace('##TYPE##','big',$picture['path'])) ?>" title="<?php echo $picture['title'] ?>" rel="shadowbox[<?php echo $row['title'] ?>]" style="display:none"></a>
                <?php }
            }
            if ($stmt->rowCount() > 0) { ?>
            <?php }
            $stmt->closeCursor();
            }
            ?>
            </div>
        <div class="actualites-gauche">
            <?php echo substr($row['description'], 0, strpos($row['description'],'</p>')+4) ?>
            <br class="clearer" />
	    <?php if (strlen($row['description']) > strpos($row['description'],'</p>')+4){ ?>
            <div class="lire-suite"></div>
            <div class="suite-actualite">
                <?php echo substr($row['description'], strpos($row['description'],'</p>')+4) ?>
            </div>
	    <?php }else{ ?>
	    <div class="actu-vide"></div>
	    <?php } ?>
            <br class="clearer" />
        </div>
        <br class="clearer" />
    </div>
    <?php }
    $results->closeCursor();
}
?>
                  <!-- InstanceEndEditable -->
                        </div>
					<div id="footer-contenu"></div>
				  <!-- InstanceBeginEditable name="Promos" -->
                  <a href="organisation-foot.php"><img src="images/actualites/promo-foot.png" alt="Section Sportif Foot" width="383" height="86" class="vignettes-pormo" /></a>
                  <a href="organisation-clavier.php"><img src="images/actualites/promo-clavier.png" alt="Classe Clavier" width="361" height="86" class="vignettes-pormo" /></a>
                  <a href="organisation-enseignement-anglais.php"><img src="images/actualites/promo-anglais.png" alt="Conversation Anglais" width="383" height="84" class="vignettes-pormo" /></a>
                  <a href="organisation-enseignement-anglais.php#Cambrige"><img src="images/actualites/promo-cambridge.png" alt="University Of Cambridge" width="361" height="84" class="vignettes-pormo" /></a>

				  <!-- InstanceEndEditable -->
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
