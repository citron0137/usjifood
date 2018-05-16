<?php

// 요청을 받아 저장
$data = json_decode(file_get_contents('php://input'), true);
 
// 받은 요청에서 content 항목 설정
$content = $data["content"];
//$mecon[0]=$content;
$mecon = explode( ' ' , $content); 

$keyboard = ',
"keyboard": {
  "type": "buttons",
  "buttons": [
	"채팅으로",
	"오늘 밥",
	"내일 밥",
	"날씨",
	"투표",
	"이벤트",
	"도움말"
  ]
}';




// '시작하기' 버튼 처리

if( $mecon[0] == "이벤트" || $mecon[0] == "ㅇㅂㅌ" )
{
	if($mecon[1]=='확인'||$mecon[1]=='ㅎㅇ'){
		$vfile=fopen("event.txt","r");
		$vlist = fread($vfile,filesize("event.txt"));
		$vlist = substr(json_encode($vlist), 1, -1);
		$user_key=$data["user_key"];
		if (date("dH")<1700) 
		{
		echo <<< EOD
			{
				"message": {
					"text": "아직 결과가 발표되지 않았습니다."
				}$keyboard
			}
EOD;
		}
		if ( strpos($vlist,$user_key) !== false) 
		{
		echo <<< EOD
			{
				"message": {
					"text": "축하드립니다! 당첨되셨습니다. 상담원에게 채팅을 보내 상품권을 수령하세요."
				}$keyboard
			}
EOD;
		}
		else
		{
		echo <<< EOD
			{
				"message": {
					"text": "아쉽네요 ㅜㅜ, 앞으로도 제일고 급식봇을 많이 이용해주세요!"
				}$keyboard
			}
EOD;
		}

	}
	$about_event = " '투표'가 끝이 났습니다.\r\n 아쉽게도 투표인원인 200명 보다 작아 당첨인원은 1명입니다.\r\n '이벤트 확인'으로 결과를 확인해 주세요!\r\n";
	$about_event = substr(json_encode($about_event), 1, -1);
echo <<< EOD
{
	"message": {
	  "text": "$about_event",
	  "photo": {
		"url": "http://211.244.210.198/cash.jpg",
		"width": 640,
      "height": 360
	  }
	},
	"keyboard": {
	  "type": "buttons",
	  "buttons": [
		"처음으로",
		"이벤트 확인",
		"투표"
	  ]
	}
}
EOD;
}
else if( $mecon[0] == "채팅으로"){
	$how_chat = "채팅을 보내 명령어를 실행시키세요!\r\n 메뉴(ㅁㄴ)를 보내 메뉴를 열 수 있습니다.";
	$how_chat = substr(json_encode($how_chat), 1, -1);
	echo <<< EOD
	{
		"message": {
		  "text": "$how_chat"
		}
	  }
EOD;
}
else if( $mecon[0] == "메뉴" || $mecon[0] == "ㅁㄴ" ||$mecon[0] == "처음으로"|| $mecon[0] == "홈으로"){
	$how_chat = "아래 버튼을 눌러 명령어를 실행시키세요!";
	$how_chat = substr(json_encode($how_chat), 1, -1);
	echo <<< EOD
	{
		"message": {
		  "text": "$how_chat"
		}$keyboard
	}
EOD;
}
else if( $mecon[0] == "투표"||$mecon[0]=="ㅌㅍ"){
	if ($mecon[1] == "확인" ){
		
		$vfile=fopen("vot_people.txt","r");
		$vlist = fread($vfile,filesize("vot_people.txt"));
		$vlist = substr(json_encode($vlist), 1, -1);
		$user_key=$data["user_key"];
		if ( strpos($vlist,$user_key) !== false) 
		{
		echo <<< EOD
			{
				"message": {
					"text": "이미 투표 했습니다."
				}$keyboard
			}
EOD;
		}
		else{
			echo <<< EOD
			{
				"message": {
					"text": "아직 투표 안했습니다."
				}$keyboard
			}
EOD;
		}
		fclose($vfile);
	}
	if ($mecon[1] == "결과"||$mecon[1] == "ㄱㄱ") {

		$vfile=fopen("vot_people.txt","r");
		$vlist = fread($vfile,filesize("vot_people.txt"));
		$vlist = substr(json_encode($vlist), 1, -1);
		$user_key=$data["user_key"];
		if ( strpos($vlist,$user_key) !== false) {
		$vfile=fopen("vot_result.txt","r");
		$vot_result=explode("|",fread($vfile,filesize("vot_result.txt")));
		fclose($vfile);
		$vot_rst_string = 
"사물놀이 ".$vot_result[3]."표
제일고 합창부 ".$vot_result[4]."표
랩(김윤봉) ".$vot_result[5]."표
노래(김정민) ".$vot_result[6]."표
댄스(홍민기외 13인) ".$vot_result[7]."표
통기타 합주 ".$vot_result[8]."표
제일고 밴드부 ".$vot_result[9]."표
강남고 댄스 팀 ".$vot_result[10]."표
핑거스타일 기타 ".$vot_result[11]."표
랩(박지석) ".$vot_result[12]."표
무거고 댄스팀 ".$vot_result[13]."표
랩(이제성 외 1인) ".$vot_result[14]."표
성광여고 댄스팀 ".$vot_result[15]."표
제일고 학생회 ".$vot_result[16]."표 
총 ".$vot_result[3]+$vot_result[4]+$vot_result[5]+$vot_result[6]+$vot_result[7]+$vot_result[8]+$vot_result[9]+$vot_result[10]+$vot_result[11]+$vot_result[12]+$vot_result[13]+$vot_result[14]+$vot_result[15]+$vot_result[16]."표";
		
		$vot_rst_string = substr(json_encode($vot_rst_string), 1, -1);
		echo <<< EOD
			{"message": {
			  "text": "$vot_rst_string"}$keyboard}
EOD;
			}
		else{
				echo <<< EOD
				{
					"message": {
						"text": "투표 후 결과를 확인할 수 있습니다."
					}$keyboard
				}
EOD;
	}
}
	else {
		$vot_how = "아래의 목록에서 최고의 팀을 골라주세요!\r\n( '선택 <팜플랫 번호>' 로도 투표 가능합니다.)\r\n 투표 후 '투표 결과'로 투표결과를 확인할 수 있습니다.\r\n투표 기간은 16일 12시 부터 자정까지 입니다.\r\n※중복 투표는 불가능하고, 한번 투표하고 되돌릴 수 없기 때문에 신중을 가해서 선택하시기 바랍니다.";
		$vot_how = substr(json_encode($vot_how), 1, -1);
		echo <<< EOD
			{"message": {
		  	"text": "$vot_how"},
			"keyboard": {
	  		"type": "buttons",
	  		"buttons": [
			"처음으로",
			"이벤트",
			"투표 결과",
			"선택 3 사물놀이",
			"선택 4 제일고 합창부",
			"선택 5 랩(김윤봉)",
			"선택 6 노래(김정민)",
			"선택 7 댄스(홍민기외 13인)",
			"선택 8 통기타 합주",
			"선택 9 제일고 밴드부",
			"선택 10 강남고 댄스 팀",
			"선택 11 핑거스타일 기타",
			"선택 12 랩(박지석)",
			"선택 13 무거고 댄스팀",
			"선택 14 랩(이제성 외 1인)",
			"선택 15 성광여고 댄스팀",
			"선택 16 제일고 학생회"
	  		]
			}
 		 	}
EOD;
	}
	
}

////////////////////////////////////////////////////////////

else if( $mecon[0] == "선택"||$mecon[0]=="ㅅㅌ"){
	$vfile=fopen("vot_people.txt","r");
	$vlist = fread($vfile,filesize("vot_people.txt"));
	$vlist = substr(json_encode($vlist), 1, -1);
	$user_key=$data["user_key"];
	if(date("dH")<1612 || date("dH")>1700){
		echo <<< EOD
			{
				"message": {
					"text": "지금은 투표기간(16일 12시 ~ 자정)이 아닙니다."
				}$keyboard
			}
EOD;
	}
	else if ( strpos($vlist,$user_key) !== false){
		echo <<< EOD
			{
				"message": {
					"text": "이미 투표 했습니다."
				}$keyboard
			}
EOD;
	}
	else if (!isset($mecon[1]) || $mecon[1] < 3 || $mecon[1] > 16 ){
		$vot_how = "아래의 목록에서 최고의 팀을 골라주세요!\r\n( '선택 <팜플랫 번호>' 로 투표 가능합니다.)\r\n 투표 후 '투표 확인'으로 확인해주세요";
		$vot_how = substr(json_encode($vot_how), 1, -1);
		echo <<< EOD
			{"message": {
		  	"text": "$vot_how"},
			"keyboard": {
	  		"type": "buttons",
	  		"buttons": [
			"채팅으로",
			"투표 확인",
			"선택 3 사물놀이",
			"선택 4 제일고 합창부",
			"선택 5 랩(김윤봉)",
			"선택 6 노래(김정민)",
			"선택 7 댄스(홍민기외 13인)",
			"선택 8 통기타 합주",
			"선택 9 제일고 밴드부",
			"선택 10 강남고 댄스 팀",
			"선택 11 핑거스타일 기타",
			"선택 12 랩(박지석)",
			"선택 13 무거고 댄스팀",
			"선택 14 랩(이제성 외 1인)",
			"선택 15 성광여고 댄스팀",
			"선택 16 제일고 학생회"
	  		]
			}
 		 	}
EOD;
	}
	else{
		$vfile=fopen("vot_people.txt","a+");
		fwrite($vfile,$data["user_key"]."\r\n");
		fclose($vfile);
		$vfile=fopen("vot_result.txt","r+");
		$vot_result=explode("|",fread($vfile,filesize("vot_result.txt")));
		$vot_result[$mecon[1]]++;
		fseek($vfile,0,SEEK_SET);
		for($i=0;$i<17;$i++){
			fwrite($vfile,$vot_result[$i]."|");
		}
		fclose($vfile);
		$vot_end = "투표 완료!";
		$vot_end = substr(json_encode($vot_end), 1, -1);
		echo <<< EOD
				{"message": {
				  "text": "$vot_end"}$keyboard}
EOD;
	}
}
	


////////////////////////////////////////////////////////////////////////////

else if( $mecon[0] == "날씨"||$mecon[0]=="ㄴㅆ"||$mecon[0]=="현재"||$mecon[0]=="ㅎㅈ"){
    $wfile=fopen("weather_result.txt","r");
    $weather = fread($wfile,filesize("weather_result.txt"));
    fclose($wfile);
    $weather = str_replace("|","",$weather);
    $weather = substr(json_encode($weather), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$weather"
        }$keyboard
    }
EOD;
}
else if($mecon[0]=="ㅅㅂ"||$mecon[0]=="시발"||$mecon[0]=="개새끼"){
	echo <<< EOD
    {
        "message": {
            "text": "뭐 시발"
        }$keyboard
    }
EOD;
}
else if( $mecon[0] == "점심"||$mecon[0]=="저녁"||$mecon[0]=="ㅈㅅ"||$mecon[0]=="ㅈㄴ"){
    $jumsim = substr(json_encode($jumsim), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "밥(ㅂ) 명령어를 사용해주세요!"
        }
    }
EOD;
}
else if( $mecon[0] == "가조쿠"||$mecon[0]=="ㄱㅈㅋ"||$mecon[0]=="ㅂㅇㄹ"||$mecon[0]=="보이루"){
    $jumsim = substr(json_encode($jumsim), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "보이루~!"
        }
    }
EOD;
}

else if( $mecon[0] == "내일"|| $mecon[0] == "ㄴㅇ"){
	
	$today = date("j");
	$thisMonth = date("n");
	$nextMonth = $thisMonth + 1;

	if($today == 30 || $today == 31){
	
	
	$myfile = fopen("sikdan_".$nextMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$nextMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[0].$sikdanarray[1];
	
	}
	else{

	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[$today];
	}
	
	

	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }$keyboard
    }
EOD;
}

else if( $mecon[0] == "어제"|| $mecon[0] == "ㅇㅈ"){


	$today = date("j");
	$thisMonth = date("n");
	$lastMonth = $thisMonth -1;
if($today == 1){
	
	
	$myfile = fopen("sikdan_".$lastMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$lastMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[29].$sikdanarray[30];
	
	}
else{
	
	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[$today - 2 ];
	}
	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }
    }
EOD;
}

else if( $mecon[0] == "모레"|| $mecon[0] == "ㅁㄹ"){
	
		
	
	$today = date("j");
	$thisMonth = date("n");
	$nextMonth = $thisMonth + 1;

if($today == 30 || $today == 31){
	
	
	$myfile = fopen("sikdan_".$nextMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$nextMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[0].$sikdanarray[1];
	
	}
else{

	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	$gubsik = $sikdanarray[$today + 1];
	}
	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }
    }
EOD;
}
else if( $mecon[0] == "오늘"|| $mecon[0] == "ㅇㄴ")
{

	$today = date("j");
	$thisMonth = date("n");
	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);

	$gubsik = $sikdanarray[$today - 1 ];
	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }$keyboard
    }
EOD;
}
else if($mecon[0] == "급식"|| $mecon[0] == "ㄱㅅ" || $mecon[0] == "밥"||$mecon[0] == "ㅂ"){

	$today = date("j");
	$thisMonth = date("n");

	if(!isset($mecon[1])){

	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);

	$gubsik = $sikdanarray[$today - 1 ];
	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }$keyboard
    }
EOD;
}
else{
if($mecon[1]<=31 && $mecon[1]>0) {
	if($mecon[1] <= $today){
	$nextMonth = $thisMonth + 1;					
	$myfile = fopen("sikdan_".$nextMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$nextMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	}
	else{
		
	$myfile = fopen("sikdan_".$thisMonth.".txt", "r");
	$fr = fread($myfile,filesize("sikdan_".$thisMonth.".txt"));
	fclose($myfile);
	$sikdanarray = explode("|",$fr);
	}
	$gubsik = $sikdanarray[$mecon[1] -1 ];
	}
	else $gubsik = "유효한 날짜를 입력해 주세요.";
	$gubsik = substr(json_encode($gubsik), 1, -1);
	echo <<< EOD
    {
	"message": {
            "text": "$gubsik"
        }
    }
EOD;
}
}
else if( $mecon[0] == "방과후"|| $mecon[0] == "ㅂㄱㅎ" || $mecon[0] == "ㅅㄱ" || $mecon[0] == "수강" || $mecon[0] == "수강신청"){
    
	echo <<< EOD
    {
        "message": {
            "text": "http://myulsanjeil.cafe24.com/sugang/regi/login.php"
        }
    }
EOD;
}
// '도움말' 버튼 처리
else if( $mecon[0] == "도움말"|| $mecon[0] == "ㄷㅇㅁ"|| $content == "?"){
	$doum = "	*메뉴를 보내고 아래 버튼을 눌러 명령어를 실행시키세요!	
	*밥(ㅂ)을 보내 식단을 확인하세요!
	*어제(ㅇㅈ)를 보내 어제 급식을 확인할 수 있습니다.
	*내일(ㄴㅇ)을 보내 내일 급식을 확인할 수 있습니다.
	*모레(ㅁㄹ)를 보내 모레 급식을 확인할 수 있습니다.
	*날씨(ㄴㅆ)를 보내 오늘 날씨를 확인할 수 있습니다.
	*수강(ㅅㄱ)을 보내 수강신청 링크를 받을 수 있습니다.
	*도움말('?')을 보내 도움말을 열 수 있습니다.

	+)ㅂ <날짜> -> 해당 날짜의 급식을 알려줍니다.
	해당 날짜가 오늘 보다 작은 경우 다음 달 해당 날짜의 급식을 알려줍니다.";
    $doum = substr(json_encode($doum), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$doum"
        }$keyboard
    }    
EOD;
}
else if( $mecon[0] == "제작자" || $mecon[0] == "제작" ){
    $doum = substr(json_encode("제작자 - 라도훈,\r\n제일고 로보로보 동아리\r\n도움 - 이도곤, 하승갑"), 1, -1);
	echo <<< EOD
    {
        "message": {
            "text": "$doum"
        }$keyboard
    }
EOD;
}
// 그밖의 문장일때 
else{
	echo <<< EOD
    {
        "message": {
            "text": "뭐라고? $content"
        }
    }
EOD;

}
?>
