<?php
// 引入数据库连接文件
require_once 'conn.php';

// 检查是否传递了用户 ID
if (isset($_GET["id"])) {
  $id = $_GET["id"];

  // 删除用户信息
  $stmt = $conn->prepare("DELETE FROM Customer WHERE CustomerID=?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    echo "用户信息已删除";
  } else {
    echo "删除失败: " . $conn->error;
  }
  $stmt->close();
}

// 关闭连接
$conn->close();
?>