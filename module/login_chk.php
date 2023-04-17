<?php

include_once('../db/db_conn.php');
include_once('../db/config.php');

  $id = $_POST['user_id'] ?? '';
  $pw = $_POST['user_password'] ?? '';


  $sql = "SELECT * FROM user_table WHERE user_id = '$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  if($row['user_id'] == $id){
    if(password_verify($pw, $row['user_password'])){
      $_SESSION['lms_logon'] = $row['user_id'];
      echo('
      <script>
        alert("로그인 되었습니다.");
        location.href = "../index.php";
      </script>
      ');
  } else {
    echo('
    <script>
      alert("비밀번호가 틀렸습니다.");
      location.href = "./login.php";
    </script>
    ');
  }
  } else {
    echo('
    <script>
      alert("아이디가 틀렸습니다.");
      location.href = "./login.php";
    </script>
    ');
  }
?>