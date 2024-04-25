<?php
	session_start();
	
	$random = rand(1, 9).rand(1, 9).rand(1, 9);
	
	$_SESSION['captcha'] = $random;
	
	$captcha = imagecreatefromjpeg("img/captcha.jpg");
	$color = imagecolorallocate($captcha, 0, 0, 0);
	$font = 'font/code.otf'; 
	imagettftext($captcha, 20, 0, rand(30, 200), rand(20, 70), $color, $font, $random );
	imagepng($captcha);
	imagedestroy($captcha);
?>