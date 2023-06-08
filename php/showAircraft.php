<?php
// 展示飞机

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';

$sql = "SELECT * FROM Aircraft";
$rs = mysqli_query($conn, $sql);
$i = 0;

while ($row = mysqli_fetch_array($rs)) {
  $data[$i]["AircraftID"] = $row["AircraftID"];
  $data[$i]["AircraftType"] = $row["AircraftType"];
  $data[$i]["NumberOfSeats"] = $row["NumberOfSeats"];
  $i++;
}

if (mysqli_num_rows($rs) > 0) {
  $code = 1;
}

// mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>