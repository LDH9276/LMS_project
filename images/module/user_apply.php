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
    <link rel="stylesheet" href="./css/master_apply.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/todo.css" type="text/css" />
    <link rel="stylesheet" href="./css/master_apply.css" type="text/css" />
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

include_once '../db/db_conn.php'; //DB연결
include_once '../db/config.php'; //DB세션
include_once '../header.php'; //메뉴
include_once './right/notice.php'; //우측메뉴


$id = $_SESSION['lms_logon'];

$sql = "SELECT user_num, user_major, user_id, user_name, learn_list FROM user_table WHERE user_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$major = $row['user_major'];
$learn_list = $row['learn_list'];
$learn_list = explode(',', $learn_list);

$learnsql = "SELECT * FROM learn_table where learn_major like '%물마시기학과%' or learn_major like '%교양과목%'";
$learn_result = mysqli_query($conn, $learnsql);

?>

<div class="page-nav">
  <h2>수강신청 페이지</h2>

  <p class="page-nav__desc">
    <i class="fas fa-home"></i>
  </p>
</div>

<div class="module">

<table class="table">
    <tr>
      <th>과목번호</th>
      <th>과목명</th>
      <th>담당교수</th>
      <th>수강현황</th>
      <th>수강신청</th>
    </tr>

    <?php

  while($rows = mysqli_fetch_array($learn_result)){

  // 만약 이미 신청한 과목이라면 신청완료 버튼을 띄워준다.
  $applysql = "SELECT * FROM learn_apply WHERE user_name = '{$row['user_name']}' AND learn_title = '{$rows['learn_title']}'";
  $apply_result = mysqli_query($conn, $applysql);
  $apply_row = mysqli_fetch_array($apply_result);

  echo '<tr>';
  echo '<td>'.$rows['learn_num'].'</td>';
  echo '<td>'.$rows['learn_title'].'</td>';
  echo '<td>'.$rows['teacher_name'].'</td>';
  echo '<td>'.$rows['student_person']. '/' .$rows['student_total'].'</td>';
  echo '<td>';

  if($apply_row) {  // 만약에 존재한다면
    // 신청완료로 표시한다.
    echo '<span class="btn btn-done">신청완료</span>';
  } else { // 존재하지 않는다면
    // 신청버튼을 띄워준다.
    if(!in_array($rows['learn_title'], $learn_list)){?>
      <form action="./user_apply_confirm.php" method="post">
        <input type="hidden" name="user_num" value="<?=$row['user_num']?>">
        <input type="hidden" name="user_name" value="<?=$row['user_name']?>">
        <input type="hidden" name="learn_num" value="<?=$rows['learn_num']?>">
        <input type="hidden" name="learn_title" value="<?=$rows['learn_title']?>">
        <input type="hidden" name="verify" value="ok">
        <button type="submit" name="apply" class="btn btn-apply">신청</button>
      </form>
    <?php }
  }
  echo '</td>';
  echo '</tr>';
} ?>


</table>
</div>
</body>
</html>