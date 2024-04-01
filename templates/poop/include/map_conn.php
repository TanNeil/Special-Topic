<?php
//資料庫設定
$dbServer = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "shoppingmull3";

//連線資料庫伺服器
$connection = @mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);

if (!$connection)
  die("無法連線資料庫伺服器");

//設定連線的字元集為 UTF8 編碼
mysqli_set_charset($connection, "utf8");

$CombineId = $_GET['id'];

$query = "SELECT * FROM combine WHERE id = $CombineId";
$result = mysqli_query($connection, $query);
$newQuery = "SELECT info.*
            FROM combine
            INNER JOIN info ON combine.id = info.c_id
            WHERE info.c_id = $CombineId";
$newResult = mysqli_query($connection, $newQuery);
$nnQ = "SELECT info.*, combine.*
        FROM info
        INNER JOIN combine ON info.c_id = combine.id
        WHERE info.c_id = $CombineId";
$nnR = mysqli_query($connection, $nnQ);
$zzz = "SELECT area.name,area.number FROM area
        INNER JOIN info ON area.id = info.a_id
        WHERE info.c_id = $CombineId";
$zzR = mysqli_query($connection, $zzz);

// 檢查是否找到資料
if (mysqli_num_rows($result) == 0) {
  echo "找不到該商品";
  exit;
}
if (mysqli_num_rows($newResult) == 0) {
  echo "找不到新資料表的資料";
  exit;
}
if (mysqli_num_rows($nnR) == 0) {
  echo "找不到nn資料表的資料";
  exit;
}
if (mysqli_num_rows($zzR) == 0) {
  echo "找不到nn資料表的資料";
  exit;
}
