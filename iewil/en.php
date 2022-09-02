<?php
function cleanTxt($string){
    return str_replace(['<?php','<?','?>'], "", $string);
}
function encode($string){
	$text = str_rot13(base64_encode($string));
	return $text;
}
function strToHex($string){
	$text = bin2hex($string);
	$text = chunk_split($text,2,"\x");
	$text = "\x" . substr($text,0,-2);
	return $text;
}
function genStr($x=10){
	$string = "qwertyuiopasdfghjklzxcvbnm";
	$output = "";
	for ($i=0; $i < $x; $i++) {
        $output .= $string[rand(0,strlen($string) - 1)];
    }
    return $output;
}
function execute($string){
	$content = "";
	$content = cleanTxt($string);
	$content = encode($content);
	$content = strToHex($content);
	//print $content;exit;
	$var1 = genStr(10);
	$var2 = genStr(15);
	$output = '$'.$var1.'= base64_decode("\x59\x6d\x46\x7a\x5a\x54\x59\x30\x58\x32\x52\x6c\x59\x32\x39\x6b\x5a\x51\x3d\x3d");$'.$var2.'=base64_decode("\x63\x33\x52\x79\x58\x33\x4a\x76\x64\x44\x45\x7a");eval($'.$var1.'($'.$var2.'("'.$content.'")));';
	for($i=10;$i>0;$i--){
		$output =  base64_encode($output);
		$output = '$'.$var1.'= base64_decode("\x59\x6d\x46\x7a\x5a\x54\x59\x30\x58\x32\x52\x6c\x59\x32\x39\x6b\x5a\x51\x3d\x3d");eval($'.$var1.'("'.$output.'"));';
	}
	return $output;
}
function ssl($string,$password){
	$var2 = genStr(15);
	$content = openssl_encrypt($string,"AES-128-ECB",md5($password));
	$output = '$'.$var2.'=base64_decode("\x62\x33\x42\x6c\x62\x6e\x4e\x7a\x62\x46\x39\x6b\x5a\x57\x4e\x79\x65\x58\x42\x30");eval($'.$var2.'("'.$content.'",base64_decode("\x51\x55\x56\x54\x4c\x54\x45\x79\x4f\x43\x31\x46\x51\x30\x49\x3d"),"'.md5($password).'"));';
	return $output;
}
function encrip($content){
	$var1 = genStr(10);
	$var2 = genStr(15);
	$compressed = gzcompress($content, 9);
	$compressed = base64_encode($compressed);
	$output = '$'.$var2.'=base64_decode("\x59\x6d\x46\x7a\x5a\x54\x59\x30\x58\x32\x52\x6c\x59\x32\x39\x6b\x5a\x51\x3d\x3d");';
	$output .= '$'.$var1.'=base64_decode("\x5a\x33\x70\x31\x62\x6d\x4e\x76\x62\x58\x42\x79\x5a\x58\x4e\x7a");'.cek();
	$output .= "eval($".$var1."($".$var2."('".$compressed."')));";
	return $output;
}
function cek(){
	$var1 = genStr(10);
	return '$'.$var1.'="\x65\x78\x70\x6c\x6f\x64\x65"("\x2f",__FILE__);"\x65\x72\x72\x6f\x72\x5f\x72\x65\x70\x6f\x72\x74\x69\x6e\x67"("\x30");("\x66\x69\x6c\x65"($'.$var1.'["\x63\x6f\x75\x6e\x74"($'.$var1.')-1])["\x36"])? exit("\x45\x52\x52\x4f\x52\x21"):"\x66\x61\x6c\x73\x65";(!"\x65\x78\x70\x6c\x6f\x64\x65"("\x65\x76\x61\x6c","\x66\x69\x6c\x65\x5f\x67\x65\x74\x5f\x63\x6f\x6e\x74\x65\x6e\x74\x73"($'.$var1.'["\x63\x6f\x75\x6e\x74"($'.$var1.')-1]))["\x31"])? exit("\x45\x52\x52\x4f\x52\x21"):"\x66\x61\x6c\x73\x65";';
}
//print strToHex("1");Exit;

if(!$argv[1]){
	print "usage: php ".$argv[0]." input.php \n";
	exit;
}

$x = file_get_contents($argv[1]);
$key = "iewil";
$output = ssl(execute($x),$key);
$en = encrip($output);
$string = '<?php
/*
Encrypt by iewil
[ '.date("H:i:s").' ]------>'.date("D-m-Y").'
*/
define("•®Ûö", "\x5a\x33\x70\x31\x62\x6d\x4e\x76\x62\x58\x42\x79\x5a\x58\x4e\x7a");define("Å[dïr", "\x63\x33\x52\x79\x58\x33\x4a\x76\x64\x44\x45\x7a");'.$en.'?>';
file_put_contents("encript-".$argv[1],$string);
(file_get_contents("encript-".$argv[1]))? print "Success ~> encript-".$argv[1]."\n":print "Error!\n";
