<?php

//변수선언
$mysql_host = 'localhost';
$mysql_user="leedh9276";
$mysql_password="vmfhsxmdpsem#1";
$mysql_db="leedh9276";

// 데이터베이스에 연결하는 함수
$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);

if(!$conn){ //연결오류가 발생되면 메세지 띄우고 스크립트를 종료한다. 
  die('연결실패 : ' . mysqli_connect_error());
}
foreach($_REQUEST AS $request_key => $request_value) {
  ${$request_key} = $request_value;
}

?>

