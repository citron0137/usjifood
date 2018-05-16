<?php

function weather_decode($weather,$val)
{
    global $sky, $ptv, $t1h, $h_t1h,$mintem,$maxtem,$rain;
    if( $weather["category"] == 'POP') return '강수확률 : '.$weather[$val];
    if( $weather["category"] == 'PTY') {
        $rain=1;
        if($weather[$val] == 0) {$ptv = "없음";$rain=0;}
        else if($weather[$val] == 1) $ptv = "비가 내리고 있습니다.";
        else if($weather[$val] == 2) $ptv = "비와 눈이 내리고 있습니다.";
        else if($weather[$val] == 3) $ptv = "눈이 내리고 있습니다.";
        return '강수형태 : '.$ptv;
    }
    if( $weather["category"] == 'R06') return '6시간 강수량 : '.$weather[$val];
    if( $weather["category"] == 'REH') return '습도 : '.$weather[$val].'%';
    if( $weather["category"] == 'S06') return '6시간 신적설 : '.$weather[$val];
    if( $weather["category"] == 'SKY'){
        if($weather[$val] == 1) $sky = "맑습니다.";
        else if($weather[$val] == 2) $sky = "구름이 조금 있습니다.";
        else if($weather[$val] == 3) $sky = "구름이 많이 있습니다.";
        else if($weather[$val] == 4) $sky = "흐립니다.";
        return '하늘상태 : '.$sky;
    } 
    if( $weather["category"] == 'T3H') return '3시간 기온 : '.$weather[$val];
    if( $weather["category"] == 'TMN') return '아침 최저기온 : '.$mintem=$weather[$val];
    if( $weather["category"] == 'TMX') return '낮 최고기온 : '.$maxtem=$weather[$val];
    if( $weather["category"] == 'WAV') return '파고 : '.$weather[$val];
    if( $weather["category"] == 'VEC') return '풍향 : '.$weather[$val];
    if( $weather["category"] == 'WSD') return '풍속 : '.$weather[$val];
    if( $weather["category"] == 'LGT') return '낙뢰 : '.$weather[$val];
    if( $weather["category"] == 'RN1') return '1시간 강수량 : '.$weather[$val].'mm';
    if( $weather["category"] == 'T1H') {
        
        $t1h = $weather[$val].'℃';
        if($weather[$val] > 27) $h_t1h = '많이 덥습니다.';
        else if($weather[$val] > 23) $h_t1h = '덥습니다';
        else if($weather[$val] > 20) $h_t1h = '따뜻합니다';
        else if($weather[$val] > 17) $h_t1h = '비교적 시원합니다.';
        else if($weather[$val] > 12) $h_t1h = '시원합니다.';
        else if($weather[$val] > 10) $h_t1h = '조금 춥습니다.';
        else if($weather[$val] > 6) $h_t1h = '춥습니다.';
        else $h_t1h = '아주 춥습니다.';
        return '기온 : '.$t1h;
    }
    if( $weather["category"] == 'UUU') return '풍속(동서성분) : '.$weather[$val];
    if( $weather["category"] == 'VVV') return '풍속(남북성분) : '.$weather[$val];
    else return $weather["category"].' : '.$weather[$val] ;
}
$filename = 'weather_rawstring.txt';
///////////////////////////////////////////////////////////////////////// 초단기 실황

$day_today=date("Ymd");
$key = 'waLANTBbnbodSBFOjntX8MfhFW2dX7oN8f1Ecn7tbS9Bs4oiClRZN9KEiczGvQQjBCQY7NYC6kAlzJMUIiPZNQ%3D%3D';
$nx = '101';
$ny = '84';
$url = 'http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService2/ForecastGrib?serviceKey='.$key.'&base_date='.$day_today.'&base_time='.DATE("Hi",time()).'&nx=101&ny=84&numOfRows=14&pageSize=14&pageNo=1&startPage=1&_type=json';
$rawstring = file_get_contents($url);
if( strpos($rawstring, "T1H")){
    $myfile = fopen($filename, "w");
    fwrite($myfile,$rawstring);
    fclose($myfile);
}
else{
    $myfile = fopen($filename, "r");
    echo $rawstring = fread($myfile,filesize($filename));
    fclose($myfile);
}
$weather = json_decode($rawstring, true)["response"]["body"]["items"]["item"];
for ($i = 0; $weather[$i]; $i++) {
    echo weather_decode($weather[$i],'obsrValue').'<br>';
}
if($ptv =='없음') echo $write_string ='현재'/*.'('.$weather[1]["baseDate"].$weather[1]["baseTime"].')'*/.' 날씨는 '.$sky.' <br>기온은 '.$t1h.'로 '.$h_t1h;
else echo $write_string ='현재'/*.'('.$weather[1]["baseDate"].$weather[1]["baseTime"].')'*/.' '.$ptv.'기온은 '.$t1h.'로 '.$h_t1h;





echo '<br><br><br>';
$fileprefcst =fopen("weather_result.txt","r");
echo $rawprefcst = fread($fileprefcst,filesize("weather_result.txt"));
$prefcst = explode("|",$rawprefcst);
//for($i=0;$prefcst[$i];$i++) echo $prefcst[$i].'<br>';
fclose($fileprefcst);

$resultfile = fopen("weather_result.txt","w");
fwrite($resultfile, str_replace("<br>", "\r\n", $write_string."\r\n"));



/////////////////////////////////////////////////////////////////////////
//echo '<br><br><br>prefcst : '.$prefcst[1];
//echo '<br><br><br>prefcst : '.$prefcst[1]='aaaaa';
///////////////////////////////////////////////////////////////////////// 초단기 예보
/*

$url = 'http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService2/ForecastGrib?serviceKey='.$key.'&base_date='.'20180512'.'&base_time='.DATE("Hi",time()).'&nx=101&ny=81&numOfRows=14&pageSize=14&pageNo=1&startPage=1&_type=json';
$rawstring = file_get_contents($url);
$weather = json_decode($rawstring, true)["response"]["body"]["items"]["item"];
/*
for ($i = 0; $i < 100; $i++) {
    echo '['.$today_forcast[$i]["fcstDate"].' '.$today_forcast[$i]["fcstTime"].'] '.fcstcate($today_forcast[$i]["category"]).' : '.$today_forcast[$i]["fcstValue"];

    echo '<br>';
}

/*
echo $forcast_today;
*/

/////////////////////////////////////////////////////////////////////// 동네 예보


//echo '<br><br><br>prefcst : '.$prefcst[1];


$filename = 'weather_fcstrawstring.txt';
$nurl = 'http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService2/ForecastSpaceData?serviceKey='.$key.'&base_date='.$day_today.'&base_time='.DATE("Hi",time()).'&nx=101&ny=84&numOfRows=1000&pageNo=1&startPage=1&_type=json';
$fcstrawstring = file_get_contents($nurl);

if( strpos($fcstrawstring, "T3H")){
    $myfile = fopen($filename, "w");
    fwrite($myfile,$fcstrawstring);
    fclose($myfile);
}
else{
    $myfile = fopen($filename, "r");
    $fcstrawstring = fread($myfile,filesize($filename));
    fclose($myfile);
}
$fcstweather = json_decode($fcstrawstring, true)["response"]["body"]["items"]["item"];
//echo json_encode($fcstweather);
global $fcstwhen;
$maxtem='알 수 없음';
$mintem='알 수 없음';
$fcstwhen ='-1';

//echo '<br><br><br>prefcst : '.$prefcst[1];
$fcstwrite_string=$prefcst[1];

for ($i = 0; $fcstweather[$i]; $i++) {
    if($i == 0 || $fcsttime != $fcstweather[$i]["fcstTime"]){
        echo'<br>';
        if($i == 0 || $fcstdate != $fcstweather[$i]["fcstDate"]) {
            if($fcstdate == $day_today) 
            {
		if($maxtem != '알 수 없음'&& $mintem != '알 수 없음')	
			$fcstwrite_string='<br>오늘'/*.'('.$fcstdate.')'*/.'의 최고기온은 '.$maxtem.'℃이고, <br>최저기온은 '.$mintem.'℃으로 예상됩니다.<br>';
               /* else {
			
			//echo '<br><br><br>prefcst : '.$prefcst[1];
			//echo $fcstwrite_string=$prefcst[1];
		}*/
		if( $rain == 1 ) {
                    echo '오늘은 비가 올 것으로 예상됩니다.<br>';
                    $fcstwrite_string = $fcstwrite_string.'오늘은 비가 올 것으로 예상됩니다.<br>';
                }
            }
            if($fcstdate == $day_today+1) 
            {
                $fcst1write_string='<br>내일'/*.'('.$fcstdate.')'*/.'의 최고기온은 '.$maxtem.'℃이고, <br>최저기온은 '.$mintem.'℃으로 예상됩니다.<br>';
                if( $rain == 1 ) {
                    echo '내일은 비가 올 것으로 예상됩니다.<br>';
                    $fcst1write_string = $fcst1write_string.'내일은 비가 올 것으로 예상됩니다.<br>';
                }
            }

	    if($fcstdate == $day_today+2)
            {
                $fcst2write_string='<br>모래'/*.'('.$fcstdate.')'*/.'의 최고기온은 '.$maxtem.'℃이고, <br>최저기온은 '.$mintem.'℃으로 예상됩니다.<br>';
                if( $rain == 1 ) {
                    echo '모래는  비가 올 것으로 예상됩니다.<br>';
                    $fcst2write_string = $fcst2write_string.'모래는 비가 올 것으로 예상됩니다.<br>';
                }
            }

	    $fcstwhen = $fcstwhen+1;
            $fcstdate = $fcstweather[$i]["fcstDate"];
            //echo '('.$fcstwhen.')';
            
        }
        $fcsttime = $fcstweather[$i]["fcstTime"];
       // echo '<br>';
    }
    weather_decode($fcstweather[$i],"fcstValue");
    //echo '<br>';
    
}
echo '|'.$fcstwrite_string.'<br>|'.$fcst1write_string.'<br>|'.$fcst2write_string;
fwrite($resultfile, str_replace("<br>", "\r\n", '|'.$fcstwrite_string.'|'.$fcst1write_string.'|'.$fcst2write_string));
    //fclose($resultfile);

?>
