<?php
// 展示航班

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';

$sql = "SELECT * FROM Flight";
$rs = mysqli_query($conn, $sql);
$i = 0;

while ($row = mysqli_fetch_array($rs)) {
  $data[$i]["FlightID"] = $row["FlightID"];
  $data[$i]["FlightNumber"] = $row["FlightNumber"];
  $data[$i]["DepartureTime"] = $row["DepartureTime"];
  $data[$i]["ArrivalTime"] = $row["ArrivalTime"];
  $data[$i]["FlightStatus"] = $row["FlightStatus"];
  $data[$i]["AircraftID"] = $row["AircraftID"];
  $data[$i]["DepartureAirportCode"] = $row["DepartureAirportCode"];
  $data[$i]["ArrivalAirportCode"] = $row["ArrivalAirportCode"];
  $i++;
}

if (mysqli_num_rows($rs) > 0) {
  $code = 1;
}

// mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>