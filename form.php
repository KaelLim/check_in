<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看報到資料</title>
    <link href="form.css" rel="stylesheet">
</head>
<body>
    <h1>報到資料</h1>
    <form method="get">
        <input type="text" name="search" placeholder="搜尋..." />
        <input type="submit" value="搜尋" />
        <input type="hidden" name="mode" value="<?php echo isset($_GET['mode']) ? $_GET['mode'] : 'data'; ?>" /> <!-- 保持模式 -->
    </form>
    <button onclick="location.href='?mode=data'">報到資料</button>
    <button onclick="location.href='?mode=heXin'">合心統計</button>

    <?php
    require_once __DIR__ . '/vendor/autoload.php';

    // 載入環境變數
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // 從環境變數或默認值獲取資料名稱
    $filename = $_ENV['MY_APP_FILENAME'] ?? 'default_filename';

    // 構造完整的文件路徑
    $filePath = __DIR__ . "/" . $filename . ".json";

    if (!file_exists($filePath)) {
        die("文件不存在: " . $filePath);
    }

    $jsonData = file_get_contents($filePath);
    $dataArray = json_decode($jsonData, true);

    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    $mode = isset($_GET['mode']) ? $_GET['mode'] : 'data';

    $heXinCounts = [];

    if ($mode == 'data') {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>姓名</th><th>Email</th><th>手機號碼</th><th>合心</th><th>和氣</th></tr>";

        // 遍歷數組並顯示數據
        foreach ($dataArray as $item) {
            // 如果設定了搜尋關鍵字，則進行搜尋過濾
            if ($searchKeyword !== '' && !preg_match("/$searchKeyword/i", implode('|', $item))) {
                continue;
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['id']) . "</td>";
            echo "<td>" . htmlspecialchars($item['name']) . "</td>";
            echo "<td>" . htmlspecialchars($item['email']) . "</td>";
            echo "<td>" . htmlspecialchars($item['phone']) . "</td>";
            echo "<td>" . htmlspecialchars($item['heXin']) . "</td>";
            echo "<td>" . htmlspecialchars($item['heQi']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } elseif ($mode == 'heXin') {
        // 統計合心
        foreach ($dataArray as $item) {
            if (isset($item['heXin'])) {
                if (!isset($heXinCounts[$item['heXin']])) {
                    $heXinCounts[$item['heXin']] = 0;
                }
                $heXinCounts[$item['heXin']]++;
            }
        }
        // 顯示合心統計結果
        echo "<h2>合心統計</h2>";
        echo "<ul>";
        foreach ($heXinCounts as $heXin => $count) {
            echo "<li>" . htmlspecialchars($heXin) . ": " . $count . "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
