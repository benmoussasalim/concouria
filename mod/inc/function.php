<?php

function price_format_lg($price){
	if(!$price)
		$price=0;
	$price = str_replace('$','',str_replace(',',".",$price));
	if($_SESSION[_AUTH_VAR]->lang == "en")
		$price= '$'.number_format($price, 2,'.', '');
	else
		$price= number_format($price, 2,',', '');
	return $price;
}

function encodedCharacters($string) {
	$string = str_replace('&amp;', '&', htmlentities($string));
	return $string;
}