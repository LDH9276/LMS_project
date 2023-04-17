<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>명지대학교 lms</title>
    <!-- 베이스css(리셋 포함) -->
    <link rel="stylesheet" href="./css/base.css" type="text/css">
    <!-- 헤더푸터 -->
    <link rel="stylesheet" href="./css/common.css" type="text/css" />

    <!-- 모듈 CSS -->
    <link rel="stylesheet" href="./css/index.css" type="text/css" />

    <!-- 폰트어썸 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./script/common.js" defer></script>
  </head>
<body>
<?php
// PHP 모듈 
include_once './db/db_conn.php'; // DB 연결
include_once './db/config.php'; // 세션
include_once './header.php'; // 헤더
?>

<?php
if($userType == 1){ // 마스터 계정일 경우 master.php로 이동
  echo'
  <script>
  location.href = "./module/master.php";
  </script>
  ';
}

// 로그인 세션 시작
if(isset($_SESSION['lms_logon'])){ // 로그인이 되어있을 경우
$mySession = $_SESSION['lms_logon'] ?? '';
$userSQL = "SELECT * FROM user_table WHERE user_id = '$mySession'";
$userQuery = mysqli_query($conn, $userSQL);
$userRow = mysqli_fetch_array($userQuery);
} else { // 비로그인은 메인페이지가 로그인
echo'
<script>
location.href = "./module/login.php";
</script>
';
}
if($userRow['learn_list']== null){
  $userRow['learn_list'] = "";
}

$learn_list = explode(',', $userRow['learn_list']);
?>

<div class="page-nav">
  <h2><span class="">환영합니다.</span> <?=$userRow['user_name']?><span class="">님</span></h2>
  <p class="page-nav__desc">
    <span><?=$userRow['user_major']?>, <?=$userRow['user_grade']?>학년</span>
    <span><?php echo date("Y년 m월 d일"); ?></span>
  </p>
</div>

<div class="module">

  <div class="learn_list-wrap">

  <?php
  if($userRow['user_type'] == 0){
    echo '<p>가입대기중인 계정입니다. 관리자의 승인이 필요합니다.</p>';
  }

  if($userRow['learn_list'] == "" && $userRow['user_type'] == 1){
    echo '<p class="learn_list-none">수강중인 강의가 없습니다.</p>';
    echo '<p class="learn_list-none">강의를 수강하려면 <a href="./module/user_apply.php">수강신청</a>에서 수강신청을 해주세요.</p>';
  } else {

  foreach($learn_list as $value){
    $learnSQL = "SELECT * FROM learn_table WHERE learn_title = '$value'";
    $learnQuery = mysqli_query($conn, $learnSQL);
    while($learnRow = mysqli_fetch_array($learnQuery)){
      if($learnRow['learn_major'] == '교양과목'){
        $learnRow['learn_major'] = '교양과목';
      } else {  
        $learnRow['learn_major'] = '전공과목';
      }      
      ?>
      <div class="index-class-wrap">
        <a href="./module/learn.php?id=<?=$learnRow['learn_num']?>" title="<?=$learnRow['learn_title']?>">
        <img src="./module/img/learn_thumb/<?=$learnRow['learn_thumb']?>" alt="<?=$learnRow['learn_title']?>" class="class-thumb">

        
        <div class="title-wrap">
        <h3 class = "class-title">
          <?=$learnRow['learn_title']?>
          <img src="./img/learning/more.svg" alt="더보기" class="more_btn">
        </h3>
        <p class = "class-info">
          <span class="class-major">
            <?=$learnRow['learn_major']?>
          </span>
          <span>
            <?=$learnRow['teacher_name']?>
          </span>
        </p>
        </div>
        </a>
      </div>
    <?php
        }
      }}
    ?>
    </div>
</div>
</body>
</html>