<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 接收 POST 請求的 JSON 數據
    $json = file_get_contents('php://input');

    // 解析 JSON 數據
    $data = json_decode($json);

    if ($data) {
        // 儲存數據為 JSON 文件
        $jsonFileName = 'save_data.json';
        file_put_contents($jsonFileName, json_encode($data));

        // 返回成功響應
        http_response_code(200);
        echo '數據已成功儲存為 JSON';
    } else {
        // 返回錯誤響應
        http_response_code(400);
        echo '無效的 JSON 數據';
    }
} else {
    // 返回錯誤響應
    http_response_code(405);
    echo '不允許的請求方法';
}
?>
