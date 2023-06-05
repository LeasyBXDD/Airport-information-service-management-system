<?php
// 连接到 MySQL 数据库
$servername = "localhost:3306";
$username = "root";
$password = "Lyz123456";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
  die("连接失败: " . $conn->connect_error);
}
echo "连接成功";

// 关闭连接
$conn->close();
?>