<?php 
session_start();
	include dirname(__FILE__).'/scripts/captcha.class.php';
		$capt = new captcha();	
		$capt->cryptsecure = "md5";
		$capt->bgR = 255;     // Couleur du fond au format RGB: Red (0->255)
		$capt->bgG = 255;     // Couleur du fond au format RGB: Green (0->255)
		$capt->bgB = 255;     // Couleur du fond au format RGB: Blue (0->255)
		$capt->charR = 60;    // Couleur des caract�res au format RGB: Red (0->255)
		$capt->charG = 79;    // Couleur des caract�res au format RGB: Green (0->255)
		$capt->charB = 0;     // Couleur des caract�res au format RGB: Blue (0->255)
		
		$capt->captcha();
		
?>