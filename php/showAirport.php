<?php
// 展示机场

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';

$sql = "SELECT * FROM Airport";
$rs = mysqli_query($conn, $sql);
$i = 0;

while ($row = mysqli_fetch_array($rs)) {
  $data[$i]["AirportCode"] = $row["AirportCode"];
  $data[$i]["AirportName"] = $row["AirportName"];
  $i++;
}

if (mysqli_num_rows($rs) > 0) {
  $code = 1;
}

// mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>