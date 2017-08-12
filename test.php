<?php
//$text=13694;
$text=$_GET["id"];
$json_string=file_get_contents("/usr/www/piersoft/dovedormirenellemarchebot/db/ricettive.json");

$parsed_json = json_decode($json_string);


$ciclo=0;
$count=0;
/*
foreach ($parsed_json->{'features'} as $i => $value) {
$count++;
}
*/
$textint=intval($text);
foreach ($parsed_json->{'features'} as $i => $value) {


$filter=$parsed_json->{'features'}[$i]->{'properties'}->{'id_struttura'};

$filterint=intval($filter);

	if ($filterint==$textint){
//if (strpos($filterint,13304) !== false ){
  echo $filterint." ".$textint."</br>";
$ciclo++;
$homepage = "Nome: <b>".$parsed_json->{'features'}[$i]->{'properties'}->{'denominazione_struttura'}."</b>\n";
$homepage .= "Tipologia: <b>".utf8_decode($parsed_json->{'features'}[$i]->{'properties'}->{'classificazione'})."</b>\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'attrezzature'}) !=null) $homepage .= "Attrezzature: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'attrezzature'})."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'nome_comune'}) !=null)	$homepage .= "Località: <b>".$parsed_json->{'features'}[$i]->{'properties'}->{'nome_comune'}."</b>\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'indirizzo'}) !=null)	$homepage .= "Indirizzo: ".$parsed_json->{'features'}[$i]->{'properties'}->{'indirizzo'}."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'web'}) !=null) $homepage .= "Website: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'web'})."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'tel'}) !=null) $homepage .= "Tel: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'tel'})."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'email'}) !=null) $homepage .= "E_Mail: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'email'})."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'attrezzature_lingue'}) !=null) $homepage .= "Lingue: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'attrezzature_lingue'})."\n";
if (strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'camere'}) !=null) $homepage .= "Camere: ".strip_tags($parsed_json->{'features'}[$i]->{'properties'}->{'camere'})."\n";

/*
if($parsed_json->{'features'}[$i]->{'geometry'}->{'coordinates'}[0] !=NULL){
$homepagemappa .= "http://www.openstreetmap.org/?mlat=".$parsed_json->{'features'}[$i]->{'geometry'}->{'coordinates'}[1]."&mlon=".$parsed_json->{'features'}[$i]->{'geometry'}->{'coordinates'}[0]."#map=19/".$parsed_json->{'features'}[$i]->{'geometry'}->{'coordinates'}[1]."/".$parsed_json->{'features'}[$i]->{'geometry'}->{'coordinates'}[0];

$option = array( array( $telegram->buildInlineKeyboardButton("MAPPA", $url=$homepagemappa)));
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "<b>Vai alla</b>",'parse_mode'=>"HTML");
$telegram->sendMessage($content);
}
*/
  $homepage .="\n____________";

}
}
echo $homepage;
 ?>
