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
    <link rel="stylesheet" href="../css/user_apply.css" type="text/css" />
    <link rel="stylesheet" href="./right/css/notice.css" type="text/css" />

    <!-- 폰트어썸 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- 제이쿼리 -->
    <script src="../script/jquery.js"></script>
    <script src="../script/common.js" defer></script>

    <!-- join -->
    <link rel='stylesheet' href='./css/join.css' type='text/css'>
<body>

<?php
// PHP 모듈 
include_once '../db/db_conn.php'; // DB 연결
include_once '../db/config.php'; // 세션
include_once '../header.php'; // 헤더
include_once './right/user_btn.php'; //우측메뉴
?>

<div class="module">
<!--여기에 내용 삽입-->
      <!-- 메인 -->
      <main>
<!-- 할일
    1. 글자 최소값 넣기(아이디, 학번, 이메일, 연락처)
    2. 아이디 숫자, 영문 필수 넣기?
-->
<link rel='stylesheet' href='./css/join.css' type='text/css'>
<script>
  
      // 회원가입 입력양식에 대한 유효성 검사
      $(document).ready(function(){

        $('#user_id').blur(function(){
          if($(this).val()==''){
            $('#id_check_msg').html('아이디를 입력해주세요.').css('color','#f00').attr('data-check','0');
          }else{
            checkIdAjax();
          }
        });
        $('#user_info').blur(function(){
          if($(this).val()==''){
            $('#info_check_msg').html('학번을 입력해주세요.').css('color','#f00').attr('data-check','0');
          }else{
            checkInfoAjax();
          }
        });
        //비밀번호 확인
        $('#user_password').blur(function(){
          let reg =  /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
          let txt = $('#user_password').val();
          if($(this).val()==''){
            // console.log('비밀번호체크1');
            $('#pass_check_msg').html('비밀번호를 입력해주세요.').css('color','#f00').attr('data-check','0');
          }else if( !reg.test(txt) ) {
            console.log(txt);
            $("#pass_check_msg").html("대문자, 소문자, 숫자, 특수문자 포함 8자리이상 입력해주세요.").css('color','#f00').attr('data-check','0');
            
        }else{
          // console.log('비밀번호체크3');
          // console.log(txt+"3번체크");
          $("#pass_check_msg").html("&nbsp;").css('color','#f00').attr('data-check','1');
        }
        });
      // id값을 post로 전송하여 서버와 통신을 통해 중복결과 json형태로 받아오기 위한 함수
        function checkIdAjax(){
          $.ajax({
            async : false,
            url:'./ajax/check_id.php',
            type:'post',
            dataType:'JSON',
            data:{
              'user_id':$('#user_id').val(),
              'user_info':$('#user_info').val()
            },
            success:function(data){
              if(data.check){
                $('#id_check_msg').html('사용 가능한 아이디입니다.').css('color','#00f').attr('data-check','1');
              }else{
                $('#id_check_msg').html('중복된 아이디입니다.').css('color','#f00').attr('data-check','0');
              }
            }
          });
        }

        function checkInfoAjax(){
          $.ajax({
            async : false,
            url:'./ajax/check_c_num.php',
            type:'post',
            dataType:'JSON',
            data:{
              'user_info':$('#user_info').val()
            },
            success:function(data){
              console.log(data);
              if(data.check){
                $('#info_check_msg').html('OK').css('color','#00f').attr('data-check','1');
              }else{
                $('#info_check_msg').html('이미 등록된 학번입니다.').css('color','#f00').attr('data-check','0');
              }
            }
          });
        }
        // 체크박스 스크립트
        // 전체 동의 클릭시 모두 체크
        $('#j-form_agreeall').click(function(){
          let checked = $(this).is(":checked");
          if(checked){
            $("#join_agree01").prop("checked", true);
            $("#join_agree02").prop("checked", true);
          }else{
            $("#join_agree01").prop("checked", false);
            $("#join_agree02").prop("checked", false);
          }
        });

        // 미체크된게 있으면 전체동의 해제되고 모두 체크되면 전체동의도 체크
      $('.join_agree').click(function(){
        let checked = $(this).is(":checked");
        if(!checked){
          $("#j-form_agreeall").prop("checked", false);
        }else{
          $("#j-form_agreeall").prop("checked", true);
        }
      });
      //체크박스 체크된 갯수 확인해서 전체동의 체크/해제
      $('.join_agree').click(function(){
        let total = $(".join_agree").length;//전체 체크박스수
        let checked = $(".join_agree-label:checked").length;//체크된 체크박스 수
        // 
        if(total != checked){
          // console.log(total);
          // console.log(checked);
          $("#j-form_agreeall").prop("checked", false);
        }else{
          $("#j-form_agreeall").prop("checked", true);
        }
      });
        // 폼 
        $('#save_frm').click(function(){
          if(!$('#user_id').val()){//아이디값을 입력하지 않은 경우
          alert('아이디를 입력해주세요');
          $('#user_id').focus(); //초점을 아이디 입력박스에 만든다
          return false;
        }

        if($('#id_check_msg').attr('data-check') != '1'){
          alert('아이디가 존재합니다. 다시입력하세요.');
          $('#id').focus();
          return false;
        }

        if(!$('#user_password').val()){
          alert('비밀번호를 입력해주세요');
          $('#user_password').focus();
          return false;
        }

        if($('#pass_check_msg').attr('data-check') != '1'){
          $('#user_password').focus();
          return false;
        }

        if(!$('#user_password2').val()){
          alert('비밀번호를 확인해주세요');
          $('#user_password2').focus();
          return false;
        }

        if(!$('#user_name').val()){
          alert('이름을 입력해주세요');
          $('#user_name').focus();
          return false;
        }

        if(!$('#user_info').val()){
          alert('학번을 입력해주세요');
          $('#user_info').focus();
          return false;
        }
        if($('#info_check_msg').attr('data-check') != '1'){
          alert('동일 학번이 존재합니다. 다시입력하세요.');
          $('#user_info').focus();
          return false;
        }
        if(!$('#user_email').val()){
          alert('이메일주소를 입력해주세요');
          $('#user_email').focus();
          return false;
        }
        if (f.mb_email.value.length > 0) { // 이메일 형식 검사
          var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/;
          if (f.mb_email.value.match(regExp) == null) {
            alert("이메일 주소가 형식에 맞지 않습니다.");
            f.mb_email.focus();
            return false;
          }
        }
        
        if(!$('#user_phone').val()){
          alert('연락처를 입력해주세요');
          $('#phone').focus();
          return false;
        }

        if($('#user_password').val()!=$('#user_password2').val()){
          alert('비밀번호가 일치하지 않습니다. \n 다시 입력하여 주세요.');
          $('#user_password').focus();
          return false;
        }
        if$('.join_agree').click(function(){
        let total = $(".join_agree").length;//전체 체크박스수
        let checked = $(".join_agree-label:checked").length;//체크된 체크박스 수
        // 
        if(total != checked){
          // console.log(total);
          // console.log(checked);
        }
        return false;
      });

        $('#member_form').submit();
    });
  });
    </script>
<!-- 회원가입 -->
<form name="회원가입" id="member_form" method="post" action="member_insert.php">
  <h2 class="j-form-h2">회원가입  <span class="j-form-span j-form-h2_span">* 는 필수 입력 사항입니다.</span></h2>

  <div class="j-form-agree">
  <!-- 이용약관동의 -->
  <div class="j-form-t_area">
    <p class="j-form-p">이용약관동의 <span class="j-form-span">*</span></p>
    <textarea name="이용약관" cols="45" rows="20" readonly="" title="이용약관동의">
제1장 총칙



제1조
(목적)        



이 약관은 명지대학교(이하 명지대학교)가 운영하는 “MJ-MOOC 통합
플랫폼” (이하
‘당 사이트’)가 제공하는 모든 회원정보 서비스(이하 '서비스')를 이용하는 고객(이하 ‘회원’)과 ‘당 사이트’가
‘서비스’의 이용에 관한 조건 및 절차와 기타 필요한 사항을 규정하는 것을 목적으로 합니다.



제2조
(약관의 효력과 변경)



1. 이 약관은 "이용약관 및 개인정보 처리방침에 동의합니다."라는 문장을 보고 '회원'이 동의를 하시면 체크 박스를 클릭함으로써 효력이 발생됩니다.

2. ‘당 사이트’는 이 약관을 임의로 변경할 수 있으며, 변경된 약관은 적용일 전
7일간
'회원'에게 공지되고 적용일에 효력이 발생 됩니다.

3. ‘회원’은 변경된 약관에 동의하지 않을 경우, '서비스' 이용을 중단하고 탈퇴할 수 있습니다. 약관이 변경된 이후에도 계속적으로 ‘서비스’를 이용하는 경우에는 '회원'이 약관의 변경 사항에 동의한 것으로 봅니다.



제3조
(약관 외 준칙)

이 약관에 명시되지 않은 사항이 관계 법령에 규정되어 있을 경우에는 그 규정에 따릅니다.



제2장 회원 가입과 서비스 이용



제4조
(이용계약)

'서비스'
이용은
'당 사이트'가 허락하고 '회원'이 약관 내용에 대해 동의하면 됩니다.






제5조
(이용신청)



1. 본 서비스를 이용하기 위해서는 '당 사이트'가 정한 소정의 양식에 이용자 정보를 기록해야 합니다.

2. 가입신청 양식에 기재된 이용자 정보는 실제 데이터로 간주됩니다. 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없습니다.



제6조
(이용신청의 승낙)



1. '당 사이트'는 '회원'이 모든 사항을 정확히 기재하여 신청할 경우 '서비스' 이용을 승낙합니다. 다만, 아래의 경우는 예외로 합니다.

① 다른 사람의 명의를 사용하여 신청한 경우

② 회원가입 신청서의 내용을 허위로 기재하였거나 신청하였을 경우

③ 사회의 안녕 질서 또는 미풍양속을 저해할 목적으로 신청한 경우

④ 다른 사람의 당 사이트 서비스 이용을 방해하거나 그 정보를 도용하는 등의 행위를 하였을 경우

⑤ 당 사이트를 이용하여 법령과 본 약관이 금지하는 행위를 하는 경우

⑥ 기타 당 사이트가 정한 회원가입 요건이 미비할 경우

2. 회원이 입력하는 정보는 아래와 같습니다. 아래의 정보 외에 '당 사이트'는
'회원'에게 추가 정보의 입력을 요구할 수 있습니다.

- 필수항목 : 이메일, 이름, 아이디, 비밀번호



제7조
(계약 사항의 변경 및 정보 보유'신용정보의 이용 및 보호에 관한 법률'에 따른 PC통신 및 인터넷 서비스의 신용불량자로 등록되는 경우



제4장 책임



제11조
('당 사이트'의 의무)



1. '당 사이트'와 제휴를 맺은 사이트를 편리하게 이용할 수 있도록 하기 위해
'당 사이트'는 '회원' 의 정보를 제휴 사이트들과 공유할 수 있으며, 공유를 위해
'당 사이트'는 '회원'의 컴퓨터에 쿠키를 전송 할 수 있습니다.

2. '당 사이트'는 '서비스' 제공으로 알게 된 '회원'의 신상정보를 본인의 승낙 없이 제3자에게 누설, 배포하지 않습니다. 다만, 다음 각 호에 해당하는 경우에는 예외로 합니다.

① 금융실명거래 및 비밀보장에 관한 법률, 신용정보의 이용 및 보호에 관한 법률,
전기통신기본법, 전기통신 사업법,
지방세법, 소비자보호법, 한국은행법, 형사소송법 등 법령에 특별한 규정이 있는 경우

② 통계작성/학술연구 또는 시장조사를 위하여 필요한 경우로서 특정 개인을 식별할 수 없는 형태로 제공하는 경우

③
'당 사이트'는 '회원'의 전체 또는 일부 정보를 업무와 관련된 통계 자료로 사용할 수 있습니다.

④
'당 사이트'는 '서비스'가 계속적이고 안정적으로 운영될 수 있도록 노력하며, 부득이한 이유로
'서비스'가 중단되면 지체없이 이를 수리 복구하는 데 최선을 다해 노력합니다. 다만, 천재지변, 비상사태, 시스템 정기점검 및 '명지대학교'가 필요한 경우에는 그 서비스를 일시 중단하거나 중지할 수 있습니다.



제
12조(`회원`
정보 사용에 대한 동의)



1. OOO대학교는 당 사이트 이외에 각종 사이트를 운영하고 있는 바,
명지대학교가 운영하는 메인 사이트 및 각종 서브사이트의 서비스 제공을 목적으로 회원의 정보를 수집하며, 수집된 회원의 정보를 사용할 수 있습니다.

2. '당 사이트'는 양질의 서비스를 위해 여러 교육 관련 유관 단체 및 비즈니스 사업자와 제휴를 맺어 회원정보를 공유할 수 있습니다. 그럴 경우
'당 사이트'는 본 조에 제휴업체 및 목적,
내용을 약관에 밝혀
`회원`의 동의를 받은 뒤 제휴업체에 제공합니다.

3. 본 조의 규정에 의한 '회원'의 동의는 본 약관 및 회원가입정보 입력화면에서 제공하는 정보서비스 이용신청 버튼을 클릭함으로써 그 효력을 발생합니다.



제13조
(회원의 의무)



1. 아이디와 비밀번호의 관리에 대한 책임은
'회원'에게 있습니다.

2. '회원'은 자신의 아이디를 타인에게 양도,
증여,
대여하거나 타인으로 하여금 사용하게 하여서는 아니됩니다.

3. 자신의 아이디(ID)가 부정하게 사용된 경우,
'회원'은 반드시 ‘명지대학교'에 그 사실을 통보해야 합니다.

4. '회원'은 게시물에 등록된 데이터를 이용한 영업활동을 할 수 없습니다.

5. '회원'은
'당 사이트'가 보내는 공지 메일을 수신해야 합니다.



제14조
(회원의 게시물)



1. 게시물이라 함은 '당 사이트'의 각종 게시판에 회원이 올린 글 전체를 포함합니다.

2. 회원이 게시하는 정보 및 질문과 대답 등으로 인해 발생하는 손실이나 문제는 전적으로 회원 개인의 판단에 따른 책임이며, '당 사이트'의 고의가 아닌 한 '당 사이트'는 이에 대하여 책임지지 않습니다.

3. 회원의 게시물로 인하여 제3자의 '당 사이트'에 대한 청구,
소송,
기타 일체의 분쟁이 발생한 경우 회원은 그 해결에 소요되는 비용을 부담하고 '당 사이트'를 위하여 분쟁을 처리하여야 하며,
'당 사이트'가 제3자에게 배상하거나 '당 사이트'에 손해가 발생한 경우 회원은
'당 사이트'에 배상하여야 합니다.

4. ‘당 사이트’는 '회원'의 게시물이 다음 각 항에 해당되는 경우에는 사전통지 없이 삭제합니다. 그러나 '당 사이트'가 게시물을 검사 또는 검열할 의무를 부담하는 것은 아닙니다.

① 제3자를 비방하거나 중상 모략하여 명예를 손상시키는 경우

② 공공질서, 미풍양속에 저해되는 내용인 경우

③
'당 사이트'의 저작권,
제3자의 저작권등 기타 권리를 침해하는 내용인 경우

④
'당 사이트'에서 규정한 게시기간을 초과한 경우

⑤ 상업성이 있는 게시물이나 돈벌이 광고, 행운의 편지 등을 게시한 경우

⑥ 사이트의 개설취지에 맞지 않을 경우

⑦ 기타 관계 법령을 위반한다고 판단되는 경우

5. '당 사이트'는 '회원'이 등록한 게시물을 활용해 가공, 판매, 출판 등을 할 수 있습니다.



제5장 정보제공



제15조
(정보의 제공)

'당 사이트'는 '회원'에게 필요한 정보나 광고를 전자메일이나 서신우편 등의 방법으로 전달할 수 있으며, '회원'은 이를 원하지 않을 경우 가입신청 메뉴와 회원정보수정 메뉴에서 정보수신거부를 할 수 있습니다. 단, 정보 수신 거부한 `회원`에게도 제13조5항의
'당 사이트' 공지 메일을 보낼 수 있습니다.



제6장 손해배상 및 면책



제16조
(책임)



1. '당 사이트'는 '서비스' 이용과 관련하여 '당 사이트'의 고의 또는 중과실이 없는 한 '회원'에게 발생한 어떠한 손해에 대해서도 책임을 지지 않습니다.

2. '당 사이트'는 '서비스' 이용과 관련한 정보, 제품, 서비스, 소프트웨어, 그래픽, 음성, 동영상의 적합성,
정확성,
시의성,
신빙성에 관한 보증 또는 담보책임을 부담하지 않습니다.



제17조
(면책)

'명지대학교'가 천재지변 또는 불가피한 사정으로 '서비스'를 중단할 경우, '회원'에게 발생되는 문제에 대해 책임을 지지 않습니다.



제18조
(관할법원)

'서비스'
이용과 관련하여 소송이 제기될 경우
'명지대학교'의 소재지를 관할하는 법원 또는 대한민국의 민사소송법에 따른 법원을 관할법원으로 합니다.

본 약관의 해석과 적용 및 본 약관과 관련한 분쟁의 해결에는 대한민국법이 적용됩니다.


    </textarea>
    <p>
      <label for="join_agree01" class="join_agree">
      <input type="checkbox" name="join_agree01" id="join_agree01" class="join_agree-label" value="Y" required> 이용약관 내용을 확인했으며 약관에 동의합니다.</label>
    </p>
  </div>
  <!-- 개인정보수집 및 이용동의 -->
  <div class="j-form-t_area">
    <p class="j-form-p">개인정보수집 및 이용동의 <span class="j-form-span">*</span></p>
    <textarea name="개인정보수집및이용동의" cols="45" rows="20" readonly="" title="개인정보수집및이용동의">
    개인정보 수집 및 이용 동의 (필수)



(시행 2022.03.02)



1. 개인정보의 수집 및 이용 목적



명지대학교는 다음의 목적을 위하여 개인정보를 처리합니다. 처리하고 있는 개인정보는 다음의 목적 이외의 용도로는 이용되지 않으며, 이용 목적이 변경되는 경우에는 개인정보 보호법 제18조에 따라 별도의 동의를 받는 등 필요한 조치를 이행할 예정입니다.



가. MJ-MOOC 플랫폼 회원 가입 및 관리



회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 확인, 회원자격 유지·관리, 서비스 부정이용 방지, 만 14세 미만 아동의 개인정보 수집 시 법정대리인의 동의 여부 확인, 분쟁 조정을 위한 기록 보존, (유료 과정 수강 시)결제 내역 관리, (이수증 발급 과정 수강 시) 이수증
발급, (동문 인증 시) 나이스평가정보 본인확인서비스 이용,
각종 고지·통지 등을 목적으로 개인정보를 처리합니다.



나. 민원사무 처리



민원인의 신원 확인, 민원사항 확인, 사실조사를 위한 연락·통지, 처리결과 통보, 서비스 개선 및 제공 등의 목적으로 개인정보를 처리합니다.




  
순번


  	
  
개인정보파일명


  	
  
운영근거


  	
  
처리목적


  

  
1


  	
  
명지대학교 ‘MJ-MOOC 통합 플랫폼’ 회원정보


  	
  
정보주체 동의


  	
  
홈페이지 회원 및 게시판 관리


  


 



﻿







 



2. 수집하는 개인정보의 항목



홈페이지는 서비스 제공을 위해 필요한 최소한의 범위 내에서 다음과 같은 개인정보를 수집하고 있습니다. 수집하는 개인정보의 항목 중 '선택항목'은 회원에게 더 나은 서비스를 제공하기 위해 추가로 수집하는 정보입니다. 회원이 원하지 않을 경우 해당 추가정보는 수집하지 않으며, 이로 인한 서비스 이용 상의 제한은 없습니다.



﻿



가. 회원가입 시



- 개인정보파일명 : 명지대학교 ‘MJ-MOOC 통합 플랫폼’ 회원정보



- 필수항목 : 이메일, 실명, 아이디, 비밀번호, 



﻿



나. 서비스 이용과정에서 아래와 같은 정보들이 자동으로 생성되어 수집될 수 있습니다.



- IP주소, 쿠키, 서비스 이용기록, 방문기록 등



위와 같이 자동 수집·저장되는 정보는 강좌 운영 및 보다 나은 서비스를 제공하기 위해 홈페이지의 개선과 보완을 위한 통계분석 등을 위해 이용될 것입니다.



 



다. 동문 인증 진행 시에는 아래와 같은 정보를 추가로 요구할 수 있습니다.



- 졸업년도, 생년월일,
휴대전화번호, 기타 나이스평가정보㈜에서 제공하는 본인확인서비스 이용을 위한 정보



﻿



라. 유료 강좌 및 이수증 발급 과정 수강 시에는 아래와 같은 정보를
추가로 요구할 수 있습니다.



-
휴대전화번호, 생년월일, 기타 KG이니시스㈜에서 제공하는 온라인 결제 서비스를 이용하기 위한 정보



 







 



3. 개인정보의 처리 및 보유기간



회원의 개인정보는 원칙적으로 개인정보의 처리목적이 달성되거나 해당 서비스가 폐지되면 지체없이 파기합니다.



﻿



가. 개인정보파일명 : 명지대학교 ‘MJ-MOOC 통합 플랫폼’ 회원정보



- 보유기간 : 회원 탈퇴 시까지



﻿







 



4. 동의를 거부할 권리가 있다는 사실과 동의 거부에 따른 불이익 내용



이용자는 명지대학교 ‘MJ-MOOC 통합 플랫폼’에서 필수로 수집하는 개인정보에 대해 동의를 거부할 권리가 있으며 필수항목에 대한 동의 거부 시에는 회원가입이 제한됩니다.



﻿







 



5.
개인정보의 제3자 제공



가. 명지대학교는 정보주체의 동의, 법률의 특별한 규정 등 개인정보 보호법 제17조 및 제18조에 해당하는 경우에만 개인정보를 제3자에게
제공합니다.



나. 수도권 대학원격교육지원센터는 다음과 같이 개인정보를 제3자에게 제공하고 있습니다.



- 개인정보를 제공받는 자 : (주)자이닉스



- 제공받는 자의 개인정보 이용목적 : 홈페이지 관리 및 유지보수



- 제공하는 개인정보 항목 : 성명, 아이디, 비밀번호, 이메일 주소



- 제공받는 자의 보유․이용기간 : 위탁 계약 종료 시 까지



- 위탁 관리부서: 교육혁신단 교육혁신팀



다. 명지대학교는 위탁계약 체결 시 개인정보 보호법 제25조에 따라 위탁업무 수행목적 외 개인정보 처리금지, 기술적·관리적 보호조치, 재 위탁 제한, 수탁자에 대한 관리·감독, 손해배상 등
책임에 관한 사항을 계약서 등 문서에 명시하고, 수탁자가 개인정보를 안전하게 처리하는지를 감독하고 있습니다.



라. 위탁업무의 내용이나 수탁자가 변경될 경우에는 지체 없이
본 개인정보 처리방침을 통하여 공개하도록 하겠습니다.







 



6. 정보주체의 권리·의무 및 행사방법



가. 정보주체는 수도권 대학원격교육지원센터에 대해 언제든지
개인정보 열람․정정․삭제․처리정지 요구 등의 권리를 행사할 수 있습니다.



 



나. 제1항에 따른 권리
행사는 명지대학교에 대해 개인정보 보호법 시행령 제41조제1항에 따라
서면, 전자우편, 모사전송(FAX) 등을 통해 하실 수 있으며 명지대학교는 이에 대해 지체 없이 조치하겠습니다.



 



다. 제1항에 따른 권리
행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 개인정보
보호법 시행규칙 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.



 



라 개인정보 열람 및
처리정지 요구는 개인정보보호법 제35조 제5항, 제37조 제2항에 의하여 정보주체의 권리가 제한 될 수 있습니다.



 



마. 개인정보의 정정 및 삭제 요구는 다른 법령에서 그 개인정보가
수집 대상으로 명시되어 있는 경우에는 그 삭제를 요구할 수 없습니다.



 



바. 명지대학교는 정보주체 권리에 따른 열람의 요구,
정정·삭제의 요구, 처리정지의 요구 시 열람 등 요구를 한 자가 본인이거나 정당한
대리인인지를 확인합니다.



 







 



7. 개인정보 파기



가. 명지대학교는 개인정보 보유기간의 경과, 처리목적 달성, 사업의 종료 등 개인정보가 불필요하게 되었을 때에는 지체 없이 해당 개인정보를
파기합니다.



 



나. 정보주체로부터 동의받은 개인정보 보유기간이 경과하거나
처리목적이 달성되었음에도 불구하고 다른 법령에 따라 개인정보를 계속 보존하여야 하는 경우에는, 해당 개인정보(또는 개인정보파일)을 별도의 데이터베이스(DB)로 옮기거나
보관장소를 달리하여 보존합니다.



 



다. 개인정보 파기의 절차 및 방법은 다음과 같습니다.



① 파기 절차



명지대학교는 기하여야
하는 개인정보(또는 개인정보파일)에 대해 개인정보 파기계획을 수립하여 파기합니다. 명지대학교는 파기 사유가 발생한 개인정보(또는 개인정보파일)을 선정하고, 수도권 대학원격교육지원센터의 개인정보 보호책임자의 승인을 받아 개인정보(또는 개인정보파일)을 파기합니다.



② 파기방법



명지대학교는 전자적
파일 형태로 기록․저장된 개인정보는 기록을 재생할 수 없도록 파기하며, 종이 문서에 기록․저장된 개인정보는 분쇄기로 분쇄하거나 소각하여 파기합니다.



 







 



8. 개인정보의 안전성 확보조치



수도권 대학원격교육지원센터는
개인정보의 안전성 확보를 위해 다음과 같은 조치를 취하고 있습니다.



가. 관리적 조치 : 내부관리계획 수립․시행, 정기적 직원 교육 등



나. 기술적 조치 : 개인정보처리시스템 등의 접근권한 관리, 접근통제시스템 설치, 고유식별 정보 등의 암호화, 보안프로그램 설치



다. 물리적 조치 : 전산실, 자료보관실 등의 접근통제



 







 



9. 개인정보 자동 수집 장치의 설치, 운영 및 거부에 관한 사항



가. 명지대학교는 이용자에게 개별적인 맞춤서비스를 제공하기
위해 이용 정보를 저장하고 수시로 불러오는 ‘쿠기(cookie)’를 사용합니다.



 



나. 쿠키는 웹사이트를 운영하는데 이용되는 서버(http)가 이용자의 컴퓨터 브라우저에게 보내는 소량의 정보이며 이용자의 PC 컴퓨터내의 하드디스크에
저장되기도 합니다.



① 쿠키의 사용목적: 이용자가 방문한 각 서비스와 웹 사이트들에 대한 방문
및 이용형태, 인기 검색어, 보안접속 여부, 등을 파악하여 이용자에게 최적화된 정보 제공을 위해 사용됩니다.



②쿠키의 설치, 운영 및 거부 : 웹브라우저 상단의 도구>인터넷 옵션>개인정보
메뉴의 옵션 설정을 통해 쿠키 저장을 거부 할 수 있습니다.



③쿠키 저장을 거부할
경우 맞춤형 서비스 이용에 어려움이 발생할 수 있습니다.



 







 



10 개인정보보호책임자 및 담당자



가. 수도권 대학원격교육지원센터는 개인정보 처리에 관한 업무를
총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보
보호책임자를 지정하고 있습니다.




  
부서명


  	
  
책임자


  	
  
문의처


  

  
명지대학교(서울)


  
교육혁신단 교육혁신팀


  	
  
최진우 교육혁신단장


  
양주성 교육혁신팀장


  	
  
02-2220-1403,1404,2047


  


나. 정보주체께서는 명지대학교 ‘MJ-MOOC
통합 플랫폼’의 서비스(또는 사업)을 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호 책임자 및 담당부서로 문의하실 수 있습니다. 명지대학교는
정보주체의 문의에 대해 지체 없이 답변 및 처리해드릴 것입니다.



 







 



11. 개인정보 열람청구



1. 정보주체는 개인정보 보호법 제35조에 따른 개인정보의 열람 청구를 아래의 부서에 할 수 있습니다.
수도권 대학원격지원센터는 정보주체의 개인정보 열람청구가 신속하게 처리되도록 노력하겠습니다.



- 개인정보 열람청구 접수, 처리부서: 명지대학교(서울) 교육혁신단 교육혁신팀



- 이메일: myongji@myongji.ac.kr



 







 



12. 권익침해 구제방법



가. 정보주체는 개인정보를 침해당했을 시에는 수도권 대학원격교육지원센터의
아래와 같이 민원접수를 할 수 있습니다.



① 개인정보 침해관련
민원 접수·처리부서



- 부서명 : 명지대학교(서울) 교육혁신단 교육혁신팀 



- 이메일 : myongji@myongji.ac.kr



 



나. 정보주체는 명지대학교의 자체적인 개인정보 불만처리,
피해구제 결과에 만족하지 못하시거나 보다 자세한 도움이 필요하시면 아래의 기관에 대해 문의하실 수 있습니다.



① 개인정보 침해신고센터 (한국인터넷진흥원 운영)



소관업무 : 개인정보 침해사실 신고, 상담 신청



홈페이지 : privacy.kisa.or.kr



전화 : (국번없이) 118



주소 : (58324) 전남 나주시 진흥길 9
(빛가람동 301-2) 3층 개인정보침해신고센터



② 개인정보 분쟁조정위원회



소관업무 : 개인정보 분쟁조정신청, 집단분쟁조정 (민사적 해결)



홈페이지 : www.kopico.go.kr



전화 : (국번 없이) 1833-6972



주소 : (03171) 서울특별시 종로구 세종대로
209 정부서울청사 4층



③ 대검찰청 사이버범죄수사과 : (국번없이)1301
(www.spo.go.kr)



④ 경찰청 사이버안전국 : (국번없이) 182 (http://cyberbureau.police.go.kr)



 







 



13. 개인정보 처리방침 변경



가. 이 개인정보 처리방침은 2022.3.2부터 적용됩니다.
    </textarea>
    <p>
      <label for="join_agree02" class="join_agree">
      <input type="checkbox" name="join_agree02" id="join_agree02" class="join_agree-label" value="Y" required> 개인정보 수집 및 이용에 동의합니다.</label>
    </p>
  </div>
  <p class="j-form_a_a_p">
  <label for="j-form_agreeall" class="j-form_agreeall">
      <input type="checkbox" name="j-form_agreeall" id="j-form_agreeall" value="Y" required> 전체 동의</label>
</p>
    </div>

  <!-- 회원가입 폼 -->
  <div class="j-form">
  <div class="j-form-f">
    <label class="j-form-label" for="user_id">아이디 <span class="j-form-span">*</span></label>
    <input type="text" class="j-form-input" id="user_id" maxlength="16" name="user_id" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/gi, '');" placeholder="영문, 숫자만 입력가능합니다." required>
  </div>
  <div>
    <span id="id_check_msg" data-check="0">&nbsp;</span>
  </div>
  <div class="j-form-f">
    <label class="j-form-label" for="user_password">비밀번호 <span class="j-form-span">*</span></label>
    <input type="password" class="j-form-input" id="user_password" maxlength="16"  name="user_password" placeholder="대문자, 소문자, 숫자, 특수문자를 포함하여야 합니다(8자리 이상)." required>
  </div>
  <div>
    <span id="pass_check_msg" data-check="0">&nbsp;</span>
  </div>
  <div class="j-form-f">
    <label class="j-form-label" for="user_password2">비밀번호 확인 <span class="j-form-span">*</span></label>
    <input type="password" class="j-form-input" id="user_password2" maxlength="16" required>
  </div>
  &nbsp;
  <div class="j-form-f">
    <label class="j-form-label" for="user_name">이름 <span class="j-form-span">*</span></label>
    <input type="text" class="j-form-input" id="user_name" name="user_name" maxlength="16" required>
  </div>
  &nbsp;
  <div class="j-form-f">
    <label class="j-form-label" for="user_info">학번 <span class="j-form-span">*</span></label>
    <input type="text" class="j-form-input" id="user_info" name="user_info" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="숫자만 입력가능합니다." required>
  </div>
  <div>
    <span id="info_check_msg" data-check="0">&nbsp;</span>
</div>
  <div class="j-form-f">
    <label class="j-form-label" for="user_email">이메일 <span class="j-form-span">*</span></label>
    <input type="email" class="j-form-input" id="user_email" name="user_email"  maxlength="16" placeholder="ex) abcd@domain.com"required >
  </div>
  &nbsp;
  <div class="j-form-f">
    <label class="j-form-label" for="user_phone">연락처 <span class="j-form-span">*</span></label>
    <input type="text" class="j-form-input" id="user_phone" name="user_phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="숫자만 입력해주세요(11자리)." maxlength="11" required>
  </div>
  &nbsp;
  <div class="j-form-b_group">
    <button class="j-form-btn j-form-btn01" type="reset">초기화</button>
    <button class="j-form-btn j-form-btn02" type="submit" id="save_frm">확인</button>
  </div>
</div>
    </form>
    </main>
</body>
</html>