<?php
// 展示预定

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';

$sql = "SELECT * FROM Reservation";
$rs = mysqli_query($conn, $sql);
$i = 0;

while ($row = mysqli_fetch_array($rs)) {
  $data[$i]["ReservationID"] = $row["ReservationID"];
  $data[$i]["CustomerID"] = $row["CustomerID"];
  $data[$i]["FlightID"] = $row["FlightID"];
  $data[$i]["ReservationDate"] = $row["ReservationDate"];
  $i++;
}

if (mysqli_num_rows($rs) > 0) {
  $code = 1;
}

// mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>