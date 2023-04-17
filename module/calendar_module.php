<?php
// 현재 서버의 시간을 가져옵니다.
$today = getdate();
$month = $today['mon'];
$year = $today['year'];

// 이번 달의 첫째 날을 가져옵니다.
$first_day = mktime(0, 0, 0, $month, 1, $year);

// 이번 달의 마지막 날을 가져옵니다.
$last_day = mktime(0, 0, 0, $month + 1, 0, $year);

// 이번 달의 날짜 수를 구합니다.
$num_days = date('t', $first_day);

// 이번 달의 첫째 날의 요일을 구합니다.
$first_day_of_week = date('D', $first_day);

// 달력을 출력합니다.
echo "<h2>" . date('F Y', $first_day) . "</h2>";
echo "<table>";
echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
echo "<tr>";

// 이번 달의 첫째 날의 위치까지 공백으로 채웁니다.
for ($i = 0; $i < date('w', $first_day); $i++) {
  echo "<td></td>";
}

// 날짜를 출력합니다.
$day = 1;
while ($day <= $num_days) {
  // 요일이 일요일이면 새로운 행을 추가합니다.
  if (date('D', mktime(0, 0, 0, $month, $day, $year)) == 'Sun') {
    echo "</tr><tr>";
  }
  echo "<td>$day</td>";
  $day++;
}

// 이번 달의 마지막 날의 위치 이후 공백으로 채웁니다.
for ($i = date('w', $last_day) + 1; $i < 7; $i++) {
  echo "<td></td>";
}

echo "</tr>";
echo "</table>";
?>