<?php
// 添加用户

$code = 0;
$data = [];
$msg = ['获取失败', '获取成功'];

include 'conn.php';
include 'functions.php';
$CustomerID = $_POST["CustomerID"];
$Name = $_POST["Name"];
$ContactInfo = $_POST["ContactInfo"];



$sql = "INSERT INTO Customer (CustomerID, Name, ContactInfo) VALUES ('$CustomerID', '$Name', '$ContactInfo')";
$rs = mysqli_query($conn, $sql);

if ($rs) {
  $code = 1;
}

echo getApiResult($code, $data, $msg);
?>