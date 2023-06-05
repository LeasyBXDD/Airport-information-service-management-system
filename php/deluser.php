<?php
// 删除用户

$code = 0;
$data = [];
$msg = ['删除失败', '删除成功'];

include 'conn.php';
include 'functions.php';

$CustomerID = $_GET["CustomerID"];
echo $CustomerID;

$sql = "DELETE FROM Customer WHERE CustomerID = '$CustomerID'";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $CustomerID);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
  $code = 1;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
?>