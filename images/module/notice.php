<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>명지대학교 lms</title>
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css" />

    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/notice.css" type="text/css" />

    <!-- 폰트어썸 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="../script/common.js" defer></script>
  </head>
<body>
<?php
// PHP 모듈 
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션
include_once '../header.php'; // 헤더

$id = $_GET['id']; // 주소창에서 받아오는 값
$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id); // SQL 인젝션 방지용
$query = "select * from notice_list where num= $id "; // 쿼리문
$result = mysqli_query($conn, $query); // DB에 쿼리문을 실행하게 한다
$data = mysqli_fetch_array($result); // 결과값을 불러온다

$title = $data['notice_title'];
?>

<div class="page-nav">
  <h2>공지사항</h2>
  <p class="page-nav__desc">
    <i class="fas fa-home"></i> > 공지사항
  </p>
</div>

<div class="module">
<?php include_once './notice_module.php'?>
</div>
</body>
</html>