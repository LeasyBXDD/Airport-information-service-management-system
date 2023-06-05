<?php
// 添加用户

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';

$sql = "SELECT * FROM Customer";
$rs = mysqli_query($conn, $sql);
$i = 0;

while ($row = mysqli_fetch_array($rs)) {
  $data[$i]["CustomerID"] = $row["CustomerID"];
  $data[$i]["Name"] = $row["Name"];
  $data[$i]["ContactInfo"] = $row["ContactInfo"];
  $i++;
}

if (mysqli_num_rows($rs) > 0) {
  $code = 1;
}

// mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>