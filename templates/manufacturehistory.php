<?php
require_once 'mysql.inc.php';
include("mysql.inc.php");
// 讀取 JSON 檔案內容
$jsonData = file_get_contents('C:/Users/88693/Desktop/meow/object_classes.json');

// 解析 JSON 資料
$objectClasses = json_decode($jsonData);

$products = array();
foreach ($objectClasses as $objectClass) {
    $sql = "SELECT * FROM info WHERE English_name = '$objectClass'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = array(
                    'id'=>$row["id"],
                    'image' => $row["image"],
                    'name' => $row["name"],
                    'price' => $row["price"],
                    'sale' => $row["sale"],
                    'many_sale' => $row["many_sale"],
                    'English_name' => $row["English_name"],

                );

                $products[] = $product;

            }

        } else {
            echo "找不到商品: " . $objectClass . "<br>";
        }
    } else {
        echo "查詢失敗: " . mysqli_error($conn);
    }
}



// 將商品資料以 JSON 格式返回給前端
header('Content-Type: application/json');
echo json_encode($products);

mysqli_close($conn);
?>