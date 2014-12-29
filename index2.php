<?php

function encrypt($sData, $secretKey){
    $sResult = '';
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1); //cat tung chu cai ra 1
        $sKeyChar = substr($secretKey, ($i % strlen($secretKey)) - 1, 1);
        $sChar    = chr(ord($sChar) + ord($sKeyChar));
        $sResult .= $sChar;

    }
    return $sResult;
} 
function decrypt($sData, $secretKey){
    $sResult = '';
    $sData   = decode_base64($sData);
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1);
        $sKeyChar = substr($secretKey, ($i % strlen($secretKey)) - 1, 1);
        $sChar    = chr(ord($sChar) - ord($sKeyChar));
        $sResult .= $sChar;
    }
    return $sResult;
}
function encode_base64($sData){
	$sBase64 = base64_encode($sData);
	return str_replace('=', '', strtr($sBase64, '+/', '-_'));
}

function decode_base64($sData){
	$sBase64 = strtr($sData, '-_', '+/');
	return base64_decode($sBase64.'==');
}

$secretKey="giang";
$sData = "vu hoang giang";
echo "text ban dau: ".$sData ."</br>"."key ban dau: ".$secretKey ."</br>";
//$textPlaint = encrypt($textPlaint, $key);
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1); //cat tung chu cai ra 1
		echo "Tung chu cai cua text ban dau: ".$sChar . "</br>";
		$a = ord($sChar);
		echo "Ma ASI cua tung chu cai text: ".ord($sChar)."</br>";
        $sKeyChar = substr($secretKey, ($i % strlen($secretKey)) - 1, 1);
		echo "Tung chu cai cua key ban dau: ".$sKeyChar. "</br>";
		echo "Ma ASI cua tung chu cai key: ".ord($sKeyChar)."</br>";
		$b = ord($sKeyChar);
        $sChar    = chr(ord($sChar) + ord($sKeyChar));
        $sResult .= $sChar;
	
	echo "Tong ma ASI cua 1 chu cai text va 1 chu cai key: ".($a + $b)."</br>".
	"Giai ma ASI Tong ma ASI cua 1 chu cai text va 1 chu cai key: ".chr($a + $b)."</br>".
	"String buffer: ".$sResult."</br></br>";
    }
	echo "Chieu dai text: ".strlen($sData)."</br>";
	echo "ket qua cuoi cung: ".$sResult."</br>";
	echo "Chieu dai ket qua cuoi cung: ".strlen($sResult)."</br>";
	echo "Encode base64 ket qua cuoi cung: ".encode_base64($sResult)."</br>";
	echo "Chieu Encode base64 dai ket qua cuoi cung: ".strlen(encode_base64($sResult))."</br>";
?>