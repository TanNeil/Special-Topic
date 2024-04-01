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

$id_list = [1, 2, 3, 4, 5, 6]; // 這裡可以包含所有你需要查詢的 id 值

// 用迴圈處理不同的 id 值
foreach ($id_list as $id) {
    echo "<div class=\"card\"><div class=\"card-body\">";
    // 查詢指定 id 的所有 info.image 和 combine.price
    $sql = "SELECT info.image, combine.price
            FROM info
            JOIN combine ON info.c_id = combine.id
            WHERE combine.id = '$id'";

    $result = $connection->query($sql);

    // 處理查詢結果並存儲到陣列中
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    foreach ($data as $item) {
        $image = $item['image'];
        echo "<a href=\"map_combine.php?id=$id\"><img src=\"$image\" width=\"100\" />";
        
    }
    // 查詢指定 id 的 combine.price
    $sql = "SELECT combine.*
            FROM combine
            WHERE combine.id = '$id'";

    $result = $connection->query($sql);
    // 處理查詢結果並輸出 combine.price
    echo '<div style="display: inline-block;">';
    while ($row = $result->fetch_assoc()) {
        echo '<span style="font-weight: bold;">' .$row['name'].'<br>'. $row['price'] . '</span><br>';
        echo "<a href=\"map_combine.php?id=$id\"><img src=\"area/pin.png\" width=\"35\" />";
    }
    echo "</div></div></div><br>";
}



// 關閉資料庫連結
mysqli_close($connection);
?>