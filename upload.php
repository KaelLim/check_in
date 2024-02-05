<?php
require_once __DIR__ . '/vendor/autoload.php';
header("Content-Type: application/json; charset=UTF-8");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 接收輸入數據
$content = file_get_contents("php://input");
$requestData = json_decode($content, true);

// 從環境變量或默認值獲取文件名
$filename = $_ENV['MY_APP_FILENAME'] ?? 'default_filename';

// 構造完整的文件路徑
$filePath = __DIR__ . "/" . $filename . ".json";

// 如果文件存在，則讀取現有數據，否則初始化數據數組
if (file_exists($filePath)) {
    $existingData = json_decode(file_get_contents($filePath), true);
    $lastItem = end($existingData);
    $id = isset($lastItem['id']) ? $lastItem['id'] + 1 : 1;
} else {
    $id = 1;
    $existingData = []; // 初始化數據數組
}

$uuid = uniqid('', true);

// 將ID和UUID添加到數據中
$data = $requestData['data']; // 實際的數據
$data['id'] = $id;
$data['uuid'] = $uuid;
$existingData[] = $data; // 將新數據添加為數組的新元素

// 嘗試將數據寫入文件
if (file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT))) {
    $response = array(
        'status' => 'success',
        'message' => '數據保存成功。',
        'id' => $id,
        'uuid' => $uuid
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => '數據保存失敗。'
    );
}
echo json_encode($response);
?>
