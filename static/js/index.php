<?php
require_once 'mysql.inc.php';
include("mysql.inc.php");

// 获取来自 Flask 的 JSON 数据
$data = $_POST['data'][0];

// 使用接收到的数据进行查询
$sql = "SELECT * FROM info WHERE English_name = '$data'";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $products = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $product = array(
                'image' => $row["image"],
                'name' => $row["name"],
                'price' => $row["price"],
                'sale' => $row["sale"],
                'many_sale' => $row["many_sale"]
            );

            $products[] = $product;
        }
        $result = json_encode($products); // 将搜索结果转换为 JSON 格式
        echo $result;
    } else {
        echo json_encode([]); // 返回空数组的 JSON 响应
    }
} else {
    echo json_encode([]); // 返回空数组的 JSON 响应
}
?>
