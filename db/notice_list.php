<?php

include '../db/db_conn.php';
include '../db/config.php';

?>

<!doctype html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORE BOM</title>
    <!-- 폰트어썸 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>

    <!-- css -->
    <link rel="stylesheet" href="./css/notice_list.css">
  </head>
  <body>
    <header>

      <section class="header">
        <h2>헤더</h2>
      </section>
      <section class="gnb">
        <h2>gnb</h2>
      </section>
    </header>
    <main>
      <div class="right">

      </div>
      <section>
        <h2>공지사항</h2>
        <div class="nl_pg">
          <a href="index.php" title="메인으로 바로가기"><i class="fa-solid fa-house"></i></a>
          <p>&gt;</p>
          <a href="notice_list.php" title="공지사항 리스트">공지사항</a>
        </div>
        <hr>
        <table class="n_list">
          <tr>
            <th>번호</th>
            <th>제목</th>
            <th>첨부</th>
            <th>등록일</th>
            <th>조회수</th>
          </tr>
          
          <tr>
            <?php
              $query = 'select * from notice_list order by num desc limit 0,10'; //가장 최신글을 위로 올라오게 조회하여 변수에 저장

              $result = mysqli_query($conn, $query);
              while($data = mysqli_fetch_array($result)){
            ?>
          </tr>
          <tr>
            <td><?=$data['num']?></td>
            <td><a href="notice.php?id=<?=$data['num']?>"><?=$data['notice_title']?></a></td>
            <td>
              <?php
                if($data['notice_file'] > 0){
                  echo '<a href="./files/'. $data['notice_file'] .'"><i class="fa-solid fa-download"></i></a>';
                } else {
                  echo '-';
                }
              ?>
            </td>
            <td><?=substr($data['notice_date'],0,10)?></td>
            <td><?=$data['notice_views']?></td>
          </tr>
          <?php } ?>


        </table>
        <p>
          <input type="search" placeholder="검색어를 입력해주세요">
          <a href="notice_write.php" title="글 입력을 위한 페이지로이동하기">글쓰기</a>
        </p>

        <?php
        ?>
      </section>
    </main>

  </body>
</html>