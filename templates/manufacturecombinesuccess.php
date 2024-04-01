<?php
require_once 'mysql.inc.php';
// 讀取 JSON 檔案內容
$jsonData = file_get_contents('C:/Users/88693/Desktop/meow/object_classes.json');

// 解析 JSON 資料
$objectClasses = json_decode($jsonData);

$conbine_ids = array();
foreach ($objectClasses as $objectClass) {
    $sql = "SELECT * FROM info WHERE English_name = '$objectClass'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $conbine_ids[] = $row["c_id"];

            }

        } else {
            echo "找不到商品: " . $objectClass . "<br>";
        }
    } else {
        echo "查詢失敗: " . mysqli_error($conn);
    }
}
$filtered_conbine_ids = array_filter($conbine_ids, function($value) {
    return $value !== null;
});

$all_combine_id = array_count_values($filtered_conbine_ids);
$combine_achieve = array();
foreach ($all_combine_id as $c_id => $count) {
    if ($count >= 2 && !in_array($c_id, $combine_achieve)) {
        $combine_achieve[] = $c_id; // 將元素添加到已存儲陣列中
    }
}

$combine_infos = array();

foreach ($combine_achieve as $c_id) {
    $sql = "SELECT combine.*, 
    info1.English_name AS info1_English_name, info1.price AS info1_price,  info1.image AS info1_image, 
    info2.English_name AS info2_English_name, info2.price AS info2_price,  info2.image AS info2_image
FROM combine
INNER JOIN info AS info1 ON combine.info1_id = info1.id
INNER JOIN info AS info2 ON combine.info2_id = info2.id
WHERE combine.id = '$c_id'
";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $combine_info = array(
                    'id' => $row["id"],
                    'name' => $row["name"],
                    'price' => $row["price"],
                    'info1_id' => $row["info1_id"],
                    'info1_English_name' => $row["info1_English_name"],
                    'info1_image' => $row["info1_image"],
                    'info2_id' => $row["info2_id"],
                    'info2_English_name' => $row["info2_English_name"],
                    'info2_image' => $row["info2_image"]
                );

                $combine_infos[] = $combine_info;


            }

        } else {
            echo "找不到此組合: " . $c_id . "<br>";
        }
    } else {
        echo "查詢失敗: " . mysqli_error($conn);
    }
}

// 將商品資料以 JSON 格式返回給前端
header('Content-Type: application/json');
echo json_encode($combine_infos);

mysqli_close($conn);
?>