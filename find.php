<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>


<?php
function find($nalzza)
{
	$genal =explode('.' , $nalzza);
	$month = (string)((int)$genal[0]-1);
	include "Snoopy.class.php";
	$snoopy = new Snoopy;
	$snoopy->submit("http://ulsanjeil.hs.kr/index.jsp?mnu=M001007003&SCODE=S000i0000404&frame=&cmd=cal&year=2017&month=".$month);
	$snoopy->results = iconv("euc-kr","UTF-8",$snoopy->results);
	$sikdanstart = strpos($snoopy->results, "schedule-list")-12;
	$sikdanend = strpos($snoopy->results,"alignCenter p10")-12;
	$sikdanstring = substr($snoopy->results, $sikdanstart,$sikdanend-$sikdanstart);
//	fwrite($myfile,$sikdanstring);	
	////////////////////////////////////////////////////////////////////////////////////
	$sikdantoday = strpos($sikdanstring,"day_".$genal[1]);
	$sikdanstring = substr($sikdanstring, $sikdantoday);
//	fwrite($myfile,$sikdanstring);
	////////////////////////////////////////////////////////////////////////////////////
	$sikdantomarrow = strpos($sikdanstring,"m_wrap day")-21;
	$sikdanstring = substr($sikdanstring, 0 ,$sikdantomarrow);
	$sikdantomarrow = strpos($sikdanstring,"m_wrap today")-21;
        $sikdanstring = substr($sikdanstring, 0 ,$sikdantomarrow);
//	fwrite($myfile,$sikdanstring);
	if(strpos($sikdanstring,"content") !== false){

		$sikdanstart = strpos($sikdanstring, "content")+9;
//		$sikdanend = strpos($sikdanstring,"&quot;</div>");
		$sikdanstring = substr($sikdanstring, $sikdanstart);
		$sikdanend = strpos($sikdanstring,"</div");
		$sikdanstring = substr($sikdanstring,0,$sikdanend);
//		fwrite($myfile, $sikdanstring);	
		$sikdanstring = str_replace("<br />", "\n", $sikdanstring);
		//$sikdanstring = str_replace("br />", "", $sikdanstring);
//		fwrite($myfile, $sikdanstring);
//		print $sikdanstring."<br><br>";
		$quotJumsimStart = strpos($sikdanstring, "&quot;",0)+6;
		$quotJumsimEnd = strpos($sikdanstring, "&quot;", $quotJumsimStart);
		$jumsim = substr($sikdanstring, $quotJumsimStart, $quotJumsimEnd-$quotJumsimStart);
//		print $jumsim."<br><br>";
		$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJumsimEnd)+6;
		$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJunukStart)+6; 
		$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJunukStart)+6; 
		$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJunukStart)+6;
		if($quotJunukStart === false+6)  $junuk = "저녁 없음!!";
		else {
			$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJunukStart)+6;
			$quotJunukStart = strpos($sikdanstring, "&quot;",$quotJunukStart)+6;
//			print $quotJunukStart;
        	        $quotJunukEnd = strpos($sikdanstring, "&quot;", $quotJunukStart);
//			print $quotJunukEnd;
        	        $junuk = substr($sikdanstring, $quotJunukStart, $quotJunukEnd-$quotJunukStart);
		}
//                print $junuk;
	}
	else {
		$jumsim="점심 없음!! 아니면 학교 홈페이지에 안올라옴!";
		$junuk="저녁 없음!!";
	}
 	return $jumsim."<br>".$junuk;
}
?>
</body>

</html>
