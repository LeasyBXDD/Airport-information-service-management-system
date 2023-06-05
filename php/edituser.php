<?php
// 引入数据库连接文件
require_once 'conn.php';

// 检查是否提交了表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // 获取表单数据
  $id = $_POST["id"];
  $name = $_POST["name"];
  $email = $_POST["email"];

  // 更新用户信息
  $stmt = $conn->prepare("UPDATE Customer SET Name=?, ContactInfo=? WHERE CustomerID=?");
  $stmt->bind_param("ssi", $name, $email, $id);
  if ($stmt->execute()) {
    echo "用户信息已更新";
  } else {
    echo "更新失败: " . $conn->error;
  }
  $stmt->close();
}

// 关闭连接
$conn->close();
?>