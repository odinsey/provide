<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Collège La Providence - Olivet - Espace Téléchargement</title>
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
<link href="css/style-telechargement.css" rel="stylesheet" type="text/css" />
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
                    ESPACE TELECHARGEMENT
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
$sql_categories = 'SELECT * FROM ressource_category as rc ORDER BY rc.position';
$sql_ressources = 'SELECT * FROM ressource as r WHERE r.published = 1 AND r.category_id = :id ORDER BY r.position';
$results = $pdo->query($sql_categories);
while ($row = $results->fetch()) {?>
    <div class="paragrapheOnOff"><?php echo $row['title'] ?></div>
    <div class="accordeon">
        <?php echo $row['description'] ?>
        <?php
        $stmt = $pdo->prepare($sql_ressources);
        $results_resources = $stmt->execute(array('id' => $row['id']));
        $i = 0;
        while ($resources = $stmt->fetch()) { ?>
        <div class="telechargement-bloc">
            <div class="telechargement-gauche">
                <a href="pdf/<?php echo $resources['path'].'.'.$resources['extension'] ?>" onclick="window.open('pdf/<?php echo $resources['path'].'.'.$resources['extension'] ?>');return false">
                    <img src="images/PDF.png" alt="<?php echo $resources['title'] ?>" width="50" height="77" /></a>
            </div>
            <div class="telechargement-droite">
                <h2><?php echo $resources['title'] ?></h2>
                <?php echo $resources['description'] ?>
            </div>
            <br class="clearer" />
        </div>
        <?php }
        if ($stmt->rowCount() > 0) { ?>
        <?php }
        $stmt->closeCursor();
        ?>
    </div>
<?php }
$results->closeCursor();
?><!-- InstanceEndEditable -->
                  </div>
                  <div id="contenu">
				  <!-- InstanceBeginEditable name="Contenu" -->
                  		<p>Page en construction</p>


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
