<?php
// 引入数据库连接文件
require_once 'conn.php';

// 查询所有用户信息
$sql = "SELECT CustomerID, Name, ContactInfo FROM Customer";
$result = $conn->query($sql);

// 输出查询结果
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "CustomerID: " . $row["CustomerID"]. " - Name: " . $row["Name"]. " - ContactInfo: " . $row["ContactInfo"]. "<br>";
  }
} else {
  echo "0 results";
}

// 关闭连接
$conn->close();
?>