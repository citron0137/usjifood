<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>

<body>


<?php

include "Snoopy.class.php";
	$month = date("n");
	$thisMonth = date("n")-1;
//	$month = date("m")+1;
//	$thisMonth = date("n");

	$snoopy = new Snoopy;
	$myfile = fopen("/var/www/html/usjifood/sikdan_".$month.".txt", "w");
	$snoopy->submit("http://ulsanjeil.hs.kr/index.jsp?year=2018&month=".$thisMonth."&mnu=M001007003&SCODE=S0000000404&cmd=cal&frame=");
	$snoopy->results = iconv("euc-kr","UTF-8",$snoopy->results);
	$sikdanstart = strpos($snoopy->results, "schedule-list")-12;
	$sikdanend = strpos($snoopy->results,"alignCenter p10")-12;
	$sikdanstring = substr($snoopy->results, $sikdanstart,$sikdanend-$sikdanstart);
	$dayssikdan = explode('day_',$sikdanstring);
	
	for($sikdanday = 1 ; $sikdanday <=31 ; $sikdanday++){
		$sikdanend = strpos($dayssikdan[$sikdanday], "day_")-4;
		$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday],0,$sikdanend);
		$sikdanprs = strpos($dayssikdan[$sikdanday], "cbox");
		if( $sikdanprs === false ) $dayssikdan[$sikdanday]="없습니다.<br>|<br>";
		else{
			$sikdanstart = strpos($dayssikdan[$sikdanday], "content")+9;
			$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday], $sikdanstart);
			$sikdanend = strpos($dayssikdan[$sikdanday], "</div>");
			$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday],0,$sikdanend);
			$dayssikdan[$sikdanday] = "<br>".$dayssikdan[$sikdanday]."<br>입니다.<br>|<br>";
			$dayssikdan[$sikdanday] = str_replace("\r", "", $dayssikdan[$sikdanday]);
		}
		print $month."월 ".$sikdanday."일의 식단은 ";
		print $dayssikdan[$sikdanday];
		$dayssikdan[$sikdanday] = str_replace("<br>", "\r\n", $dayssikdan[$sikdanday]);
		$dayssikdan[$sikdanday] = str_replace("<br />", "\r\n", $dayssikdan[$sikdanday]);
			
		$dayssikdan[$sikdanday] = str_replace("&quot;", "\"", $dayssikdan[$sikdanday]);
		fwrite($myfile,$month."월 ".$sikdanday."일의 식단은 ".$dayssikdan[$sikdanday]);
	}
	fclose($myfile);
	
	$month = date("n")+1;
	$thisMonth = date("n");

	$snoopy = new Snoopy;
	$myfile = fopen("/var/www/html/usjifood/sikdan_".$month.".txt", "w");
	$snoopy->submit("http://ulsanjeil.hs.kr/index.jsp?year=2018&month=".$thisMonth."&mnu=M001007003&SCODE=S0000000404&cmd=cal&frame=");
	$snoopy->results = iconv("euc-kr","UTF-8",$snoopy->results);
	$sikdanstart = strpos($snoopy->results, "schedule-list")-12;
	$sikdanend = strpos($snoopy->results,"alignCenter p10")-12;
	$sikdanstring = substr($snoopy->results, $sikdanstart,$sikdanend-$sikdanstart);
	$dayssikdan = explode('day_',$sikdanstring);
	
	for($sikdanday = 1 ; $sikdanday <=31 ; $sikdanday++){
		$sikdanend = strpos($dayssikdan[$sikdanday], "day_")-4;
		$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday],0,$sikdanend);
		$sikdanprs = strpos($dayssikdan[$sikdanday], "cbox");
		if( $sikdanprs === false ) $dayssikdan[$sikdanday]="없습니다.<br>|<br>";
		else{
			$sikdanstart = strpos($dayssikdan[$sikdanday], "content")+9;
			$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday], $sikdanstart);
			$sikdanend = strpos($dayssikdan[$sikdanday], "</div>");
			$dayssikdan[$sikdanday] = substr($dayssikdan[$sikdanday],0,$sikdanend);
			$dayssikdan[$sikdanday] = "<br>".$dayssikdan[$sikdanday]."<br>입니다.<br>|<br>";
			$dayssikdan[$sikdanday] = str_replace("\r", "", $dayssikdan[$sikdanday]);
		}
		print $sikdanday."일의 식단은 ";
		print $dayssikdan[$sikdanday];
		$dayssikdan[$sikdanday] = str_replace("<br>", "\r\n", $dayssikdan[$sikdanday]);
		$dayssikdan[$sikdanday] = str_replace("<br />", "\r\n", $dayssikdan[$sikdanday]);
			
		$dayssikdan[$sikdanday] = str_replace("&quot;", "\"", $dayssikdan[$sikdanday]);
		fwrite($myfile,$month."월 ".$sikdanday."일의 식단은 ".$dayssikdan[$sikdanday]);
	}
	fclose($myfile);
?>

</body>

</html>
