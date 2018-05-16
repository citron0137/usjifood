<?php

// 요청을 받아 저장
$data = json_decode(file_get_contents('php://input'), true);
 
// 받은 요청에서 content 항목 설정
$content = $data["content"];
//$mecon[0]=$content;
$mecon = explode( ' ' , $content); 
$myfile = fopen("sikdan.txt", "r");
$fr = fread($myfile,filesize("sikdan.txt"));
fclose($myfile);
$sikdanarray = explode("|",$fr);
$today = date("j");
// 그밖의 문장일때 i
$sikdanstring = $sikdanarray[$today -1 ];
{
echo <<< EOD
    {
        "message": {
            "text": "$sikdanstring"
        }
    }    
EOD;
}
?>
