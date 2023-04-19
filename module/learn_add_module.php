<?php

if($userType == 0){
  echo '<script>alert("관리자만 접근 가능합니다."); location.href = "../index.php";</script>';
  exit;
}

$sql = "SELECT * FROM user_table where user_type = 2";
$result = mysqli_query($conn, $sql);
?>

<form action="./learn_insert.php" method="post" enctype="multipart/form-data">

<p>
  <label for="learn_title">강의명</label>
  <input type="text" name="learn_title" id="learn_title" placeholder="강의명">
</p>

<p>
  <span>강의 썸네일</span>
  <input type="file" name="learn_thumbnail" id="learn_thumbnail">
  <label for="learn_thumbnail">파일 추가</label>
</p>

<p>
  <label for="teacher_name"></label>
  <select name="teacher_name" id="teacher_name">
  <option value="">--- 담당교수 ---</option>

  <!-- 교수이름 출력 -->
  <?php
  while($teacher = mysqli_fetch_array($result)){
    echo '<option value="'.$teacher['user_name'].'">'.$teacher['user_name']. '(' . $teacher['user_major'] . ')</option>';
  }
  ?>
  </select>
</p>
<p>
  <label for="learn_start">강의 시작일</label>
  <input type="date" name="learn_start" id="learn_start">
  <span>~</span>
  <label for="learn_end">강의 종료일</label>
  <input type="date" name="learn_end" id="learn_end">
</p>
<p>
  <label for="learn_major">강의 전공</label>
  <input type="radio" name="learn_major" id="major1" value="1">
  <label for="major1">전공 전용</label>
  <input type="radio" name="learn_major" id="major2" value="2">
  <label for="major2">교양 전용</label>
  <input type="radio" name="learn_major" id="major3" value="3">
  <label for="major3">전공 &middot; 교양</label>
</p>

<p>
  <label for="learn_limit">강의정원</label>
  <input type="number" name="learn_limit" id="learn_limit" placeholder="강의정원">
</p>

<p>
  강의내용 입력 
</p>

<!-- 강의 주차별 -->
<ul class="learn_weekly-wrap">
  <li>
    <label for="learn_weekly1" class="learn_weekly-title">1주차</label>
    <textarea name="learn_weekly1" id="learn_weekly1" cols="30" rows="10" class="learn_weekly" placeholder="1주차"></textarea>
  </li>
  <li>
    <label for="learn_weekly2" class="learn_weekly-title">2주차</label>
    <textarea name="learn_weekly2" id="learn_weekly2" cols="30" rows="10" class="learn_weekly" placeholder="2주차"></textarea>
  </li>
  <li>
    <label for="learn_weekly3" class="learn_weekly-title">3주차</label>
    <textarea name="learn_weekly3" id="learn_weekly3" cols="30" rows="10" class="learn_weekly" placeholder="3주차"></textarea>
  </li>
  <li>
    <label for="learn_weekly4" class="learn_weekly-title">4주차</label>
    <textarea name="learn_weekly4" id="learn_weekly4" cols="30" rows="10" class="learn_weekly" placeholder="4주차"></textarea>
  </li>
  <li>
    <label for="learn_weekly5" class="learn_weekly-title">5주차</label>
    <textarea name="learn_weekly5" id="learn_weekly5" cols="30" rows="10" class="learn_weekly" placeholder="5주차"></textarea>
  </li>
  <li>
    <label for="learn_weekly6" class="learn_weekly-title">6주차</label>
    <textarea name="learn_weekly6" id="learn_weekly6" cols="30" rows="10" class="learn_weekly" placeholder="6주차"></textarea>
  </li>
</ul>

<p class="learn_add-btn_wrap">
  <input type="reset" value="다시 작성하기" class="btn btn-reset">
  <input type="submit" value="강의 추가" class="btn btn-apply">
</p>

</form>