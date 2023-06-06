<?php
$code = 0;
$data = [];
$msg = ['修改失败', '修改成功'];

include 'conn.php';
include 'functions.php';

$CustomerID = $_POST["CustomerID"];
// echo $CustomerID;
$name = $_POST["Name"];
$email = $_POST["ContactInfo"];

$sql = "UPDATE Customer SET Name=?, ContactInfo=? WHERE CustomerID=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $CustomerID);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
  $code = 1;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo getApiResult($code, $data, $msg);
// 检查是否提交了表单
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // 获取表单数据
//   $id = $_POST["CustomerID"];
//   $name = $_POST["Name"];
//   $email = $_POST["ContactInfo"];

//   // 更新用户信息
//   $stmt = $conn->prepare("UPDATE Customer SET Name=?, ContactInfo=? WHERE CustomerID=?");
//   $stmt->bind_param("ssi", $name, $email, $id);
//   if ($stmt->execute()) {
//     echo "用户信息已更新";
//   } else {
//     echo "更新失败: " . $stmt->error;
//   }
//   $stmt->close();
// }
?>