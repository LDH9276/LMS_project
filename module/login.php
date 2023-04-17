<?php
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션 시작
?>

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
    <link rel="stylesheet" href="./css/login.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css" />

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
include_once '../header.php'; // 헤더
include_once './right/user_btn.php'; //우측메뉴
?>
<div class="module">
<div class="login-form-div">

<form name="login" method="post" action="./login_chk.php" class="login-form-form">
        <p class="login-logo-wrap">
          <img src="./img/logo.jpeg" alt="명지대학교 로고" class="login-form-logo">
        </p>
        <h3 class="login-form-h3">통합 로그인</h3>
        <ul class="login-form-ul">
          <li class="login-form-li">
            <input type="text" name="user_id" placeholder="학번 또는 아이디 입력" maxlength="16" id="user_id" class="login-form-input">
          </li>
          <li class="login-form-li">
            <input type="password" name="user_password" placeholder="패스워드 입력" maxlength="16" id="user_password" class="login-form-input">
          </li>
          <li class="login-form-li">
            <input type="checkbox" id="cb1" class="login-form-checkbox">
            <label for="cb1"></label>
            <label for="cb1" class="login-form-save">아이디 저장</label>
            <a href="#none" title="아이디 찾기">ID/PW 찾기</a>
          </li>
          <li class="login-form-li">
            <input type="submit" value="로그인" class="login-login-btn2">
            <a href="./join.php" title="회원가입 이동" class="login-login-btn1">회원가입</a>
          </li>
        </ul>
</form>
</div>
</div>
</body>
</html>