<?php
include '../db/db_conn.php';
include '../db/config.php';

$mod = $_POST['id'] ?? '';
$num = (int)$_POST['num'] ?? 0;
$prev_file = $_POST['prev_file'] ?? '';
$notice_title=$_POST['notice_title'] ?? '';
$notice_text=$_POST['notice_text'] ?? '';
$notice_date = date('Y-m-d') ?? '';

// 1. 파일업로드 부터 확인한다.
if(isset($_FILES['notice_file'])) {
  $file_name = $_FILES['notice_file']['name']; //파일명
  $file_size = $_FILES['notice_file']['size']; //파일크기
  $file_tmp = $_FILES['notice_file']['tmp_name']; //파일명
  $file_type = $_FILES['notice_file']['type']; //파일유형

  $ext = explode('.',$file_name); 
  $ext = strtolower(array_pop($ext));
  //file.hwp -> [file] [hwp]

  $expensions = array("jpeg", "jpg", "png", "pdf", "hwp", "docx", "pptx", "ppt", "txt", null); //올라갈 파일 지정
  //SWF나 EXE같은 악성코드 배포방지
  
  if(in_array($ext, $expensions) === false){ //해당 확장자가 아니라면
    $errors[] = "올바른 확장자가 아닙니다.";
  } //경고

  if($file_size > 2097152) { //2MB이상 올라가면
    $errors[] = '파일 사이즈는 2MB 이상 초과할 수 없습니다.';
  } //경고

  if(empty($errors) == true) { //에러가 없다면
    move_uploaded_file($file_tmp, "./files/".$file_name); //경로에 저장
    $files = $file_name; // 변수에 파일명을 담는다
  } else { //경고가 있다면
    print_r($errors); //경고출력
  }
} else { // 만약 이미지 업로드가 아니라면
  $files = null; //null로 반환한다.
}

if($mod == 'mod'){ // 수정사항 확인 시

  if($files == null){
    $files = $prev_file;
  }
  $stmt = mysqli_prepare($conn, "UPDATE notice_list SET notice_title = ?, notice_text = ?, notice_file = ?, notice_date = ? WHERE num = ?");
  if (!$stmt) {
  // 오류 발생시 오류 출력
  die(mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, "ssssi", $notice_title, $notice_text, $files, $notice_date, $num);
  mysqli_stmt_execute($stmt);

  if ($stmt->affected_rows == 1) {
    echo('
    <script>
      alert("글이 수정되었습니다.");
      location.href = "./notice_list.php";
    </script>
    ');
  } else {
    echo('
    <script>
      alert("글 수정에 실패하였습니다.");
      location.href = "./notice_list.php";
    </script>
    ');
  }

} else { // 새로운 글 작성 시

  $stmt = mysqli_prepare($conn, "INSERT INTO notice_list (notice_title, notice_text, notice_file, notice_date) VALUES (?, ?, ?, ?)");
  if (!$stmt) {
    // 오류 발생시 오류 출력
    die(mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, "ssss", $notice_title, $notice_text, $files, $notice_date);
  mysqli_stmt_execute($stmt);
  
  if ($stmt->affected_rows == 1) {
    echo('
    <script>
      alert("글이 작성되었습니다.");
      location.href = "./notice_list.php";
    </script>
    ');
  } else {
    echo('
    <script>
      alert("글 작성에 실패하였습니다.");
      location.href = "./notice_list.php";
    </script>
    ');
  }  
}
mysqli_stmt_close($stmt);

