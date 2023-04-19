<?php

$num = $_GET['id'] ?? '0';
$id = $_GET['modify']?? '0'; //php 7.4 이상 반드시 넣어야한다.

if($userType != 1){ //권한
  echo '
  <script>
    alert("잘못된 접근입니다.");
    location.href = "notice_list.php";
    </script>
  ';
  die;
}

if($id == 'mod') {
  $sql = "SELECT * FROM notice_list WHERE num = '$num'";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_array($result);
  } else {
  $data = [
    'notice_title' => '',
    'notice_text' => '',
    'notice_file' => ''
  ];
}
?>

    <form name='write' method="post" action="writePost.php" enctype="multipart/form-data">
        <input type="hidden" name="num" value="<?=$num?>">
        <input type="hidden" name="id" value="<?=$id?>">
      <div>

        <p class="write-title">
          <label for="notice_title">
            제목
          </label>
          <input type="text" name="notice_title" value="<?=$data['notice_title']?>" id="notice_title">
        </p>

        <p class="write-text">
          <label for="notice_text">
            내용
          </label>
          <textarea name="notice_text" id="notice_text"><?=$data['notice_text']?></textarea>
        </p>

        <p class="write-file">
          <?php if($data['notice_file']) {?>
            <input type="hidden" name="prev_file" value="<?=$data['notice_file']?>">
          <?php }?>
          <label for="notice_file">
            첨부파일
          </label>

          <?php if($data['notice_file']) {?>
            <span><?=$data['notice_file']?></span>
          <?php } else {?>
            <span id="file_name"></span>
          <?php }?>

          <input type="file" name="notice_file" id="notice_file" onchange="displayFileName()">
          <label for="notice_file" class="btn-file">
            첨부파일
          </label>        
        </p>
        <p class="submit_btn-wrap">
          <input type="submit" value="등록">
          <button type="button" id="n_btn" onclick="document.location.href='notice_list.php'">목록</button>
        </p>
      </div>
    </form>

    <script>
      function displayFileName() {
        // Get the file input element
        var fileInput = document.getElementById("notice_file");

        // Get the file name from the file input element
        var fileName = fileInput.files[0].name;

        // Display the file name in the file name element
        document.getElementById("file_name").innerHTML = fileName;
      }
    </script>
