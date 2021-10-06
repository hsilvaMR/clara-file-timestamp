<?php
	//LIBRARIA PHPSECLIB
	include('../phpseclib/Crypt/RSA.php');

	//CHAVE PRIMARIA
	$rsa = new Crypt_RSA();
	$rsa->setPrivateKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);
	$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);	
	$result = $rsa->createKey(8096);
	echo $result['privatekey'];

	//DATE - TIME 
	$dateTime = new DateTime();
	$timestamp = $dateTime->getTimestamp();
	date_default_timezone_set('UTC');
	echo '<br><br> HORA NO MOMENTO UTC: '. date('Y-m-d H:i:s', $timestamp);
	
	//LOG FINGERPRINT
	$impressao_digital = str_random(32);
	echo '<br><br> IMPRESSAO DIGITAL: '.$impressao_digital;

	//DIGITAL TSA TOKEN
	//$code_file = chunk_split(base64_encode(file_get_contents('../public_html/img/pdf/255_bonfim.pdf')));
	//echo '<br><br> DOCUMENTO EM CODIGO: <DIV style>'.$code_file.'</DIV>';
?>