<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>명지대학교 lms</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./img/pavicon.ico" type="image/x-icon" sizes="16x16">
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="../css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="../css/common.css" type="text/css">
    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/master_apply.css" type="text/css">
    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="../script/common.js" defer></script>
  </head>
<body>
<?php

include_once '../db/db_conn.php'; //DB연결
include_once '../db/config.php'; //DB세션
include_once '../header.php'; //메뉴
include_once './right/master_btn-user.php'; //우측메뉴

$id = $_SESSION['lms_logon'];

$verify_sql = "SELECT user_type FROM user_table WHERE user_id = '$id'";
$result = mysqli_query($conn, $verify_sql);
$row = mysqli_fetch_array($result);
$master = $row['user_type'];

// 관리자가 아닐 경우
if($master != 3){
  echo('
  <script>
    alert("관리자만 접근할 수 있습니다.");
    location.href = "./index.php";
  </script>
  ');
} else

$sql = "SELECT * FROM user_table WHERE user_type = 1 or user_type =2 or user_type = 0 order by user_type asc";
$result = mysqli_query($conn, $sql);
?>

<div class="page-nav">
  <h2>유저관리 페이지</h2>

  <p class="page-nav__desc">
    <a href="http://leedh9276.dothome.co.kr/lms/module/master.php" title="메인페이지 이동"><i class="fas fa-home"></i></a>
  </p>
</div>

<div class="module">

<table class = "table">
  <tr>
    <th>아이디</th>
    <th>이름</th>
    <th>학번</th>
    <th>전공</th>
    <th>이메일</th>
    <th>등급</th>
    <th>승인</th>
  </tr>

  <?php
  while($rows = mysqli_fetch_array($result)){
    echo '<tr>';
    echo '<td>'.$rows['user_id'].'</td>';
    echo '<td>'.$rows['user_name'].'</td>';
    echo '<td>'.$rows['user_info'].'</td>';
    echo '<td>'.$rows['user_major'].'</td>';
    echo '<td>'.$rows['user_email'].'</td>';
    if($rows['user_type'] == 0){
      echo '<td>가입대기</td>';
    } else if($rows['user_type'] == 1){
      echo '<td>학생</td>';
    } else if($rows['user_type'] == 2){
      echo '<td>교직원</td>';
    }
    if($rows['user_type'] == 0){ ?>
      <td class="apply-tab">
        <form action="./user_confirm.php" method="post" name="confirm" id="confirm">
        <input type="hidden" name="user_id" value="<?=$rows['user_id']?>">
        <input type="hidden" name="verify" value="ok">
        <select name="major" id="major">
          <option value="0">전공선택</option>
          <option value="0">--학생--</option>
          <option value="1">컴퓨터공학과</option>
          <option value="2">전자공학과</option>
          <option value="3">정보통신공학과</option>
          <option value="4">소프트웨어학과</option>
          <option value="0">--교직원--</option>
          <option value="5">컴퓨터공학과</option>
          <option value="6">전자공학과</option>
          <option value="7">정보통신공학과</option>
          <option value="8">소프트웨어학과</option>
        </select>
        <button type="submit" name="approve" id="btn-apply" class = "btn-sub btn-confirm">승인</button>
        </form>
        <form action="./user_confirm.php" method="post" name="reject">
        <input type="hidden" name="user_id" value="<?=$rows['user_id']?>">
        <input type="hidden" name="verify" value="no">
        <button type="submit" name="reject" class = "btn-sub btn-reject">거부</button>
        </form>
      </td>
    <?php }else {
  ?>
      <td class="apply-tab">
        <form action="./user_confirm.php" method="post" name="reject">
        <input type="hidden" name="user_id" value="<?=$rows['user_id']?>">
        <input type="hidden" name="verify" value="no">
        <p class = "brn-wrap">
          <span class="btn btn-apply">승인됨</span>
          <button type="submit" name="reject" class = "btn btn-reject">탈퇴</button>
        </p>
        </form>
      </td>
  <?php
  }
  echo '</tr>';
  }

  ?>

</table>
</div>
</body>
</html>