// JavaScript Document

$(document).ready(function(){
						   
	Shadowbox.init({
		animate: "false",
		continuous: "true",
		counterType: "skip",
		enableKeys: "false",
		overlayColor: "#000000",
		slideshowDelay:"4",
		overlayOpacity: 0.9,
		players: ["img", "swf" , "html" , "php"],
		flashParams: { bgcolor: '#ffffff' }
	});
	
// Lire la suite

	$(".lire-suite").addClass("actu-masquee");
	$(".actu-masquee").next().hide();
	
	$(".lire-suite").each(function(){
		$(this).click(function(){
			
			if ($(this).hasClass("actu-masquee")){			
				$(this).removeClass("actu-masquee").addClass("actu-visible");
				$(".lire-suite").not(this).removeClass("actu-visible").addClass("actu-masquee");
			}
			else{
				$(this).removeClass("actu-visible").addClass("actu-masquee");
			}
			
			$(".actu-masquee").next().hide("slow");
			$(".actu-visible").next().show("slow");
			
		});	
	});

	
// Galeries Photos

	$(".galerie-photo-intro").addClass("galerie-masquee");
	$(".galerie-masquee").next().hide();
	
	$(".galerie-photo-intro").each(function(){
		$(this).click(function(){
			
			if ($(this).hasClass("galerie-masquee")){			
				$(this).removeClass("galerie-masquee").addClass("galerie-visible");
				$(".galerie-photo-intro").not(this).removeClass("galerie-visible").addClass("galerie-masquee");
			}
			else{
				$(this).removeClass("galerie-visible").addClass("galerie-masquee");
			}
			
			$(".galerie-masquee").next().hide("slow");
			$(".galerie-visible").next().show("slow");
			
		});	
	});


// Paragraphe-On-Off

	$(".paragrapheOnOff").addClass("close");
	$(".close").next().hide();
	
	$(".paragrapheOnOff").each(function(){
		$(this).click(function(){
			
			if ($(this).hasClass("close")){			
				$(this).removeClass("close").addClass("open");
				$(".paragrapheOnOff").not(this).removeClass("open").addClass("close");
			}
			else{
				$(this).removeClass("open").addClass("close");
			}
			
			$(".close").next().hide("slow");
			$(".open").next().show("slow");
			
		});	
	});



	$("#etablissement-catholique").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('index.php','_self');
		});	
	});

	$("#bouton-telechargement").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('espace-telechargement.php','_self');
		});	
	});

	$("#header").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('index.php','_self');
		});	
	});

	$("#bouton-presentation").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('presentation-historique.php','_self');
		});	
	});

	$("#bouton-pastorale").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('pastorale-presentation.php','_self');
		});	
	});

	$("#bouton-organisation").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('organisation-enseignement-anglais.php','_self');
		});	
	});

	$("#bouton-examens").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('examen-dnb.php','_self');
		});	
	});

	$("#bouton-medias").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('medias-photos.php','_self');
		});	
	});

	$("#module-ecole").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('http://www.olivet-providence.info','_blank');
		});	
	});

	$("#module-apel").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('presentation-apel.php','_self');
		});	
	});

	$("#module-enseignement").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('http://www.ec-berryloiret.fr/regioncentre/','_blank');
		});	
	});

	$("#module-contact").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('contacts-acces.php','_self');
		});	
	});

	$("#footer-adresse").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('contacts-acces.php','_self');
		});	
	});

	$("#footer-mentions").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('mentions-legales.php','_self');
		});	
	});

}); //ready

