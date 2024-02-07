# 文宣營報到系統

## 簡介
本專案包括 `index.php` 和 `upload.php`，用於實作一個線上報到系統。 `index.php` 提供表單填寫和提交介面，`upload.php` 負責處理提交的資料並將其儲存到 JSON 檔案。

## 功能描述
- `index.php`: 顯示使用者報到表單，使用者可以填寫姓名、信箱、手機號碼，並從動態載入的清單中選擇合心和和氣。
- `upload.php`: 接收來自 `index.php` 的表單數據，產生唯一識別並儲存到伺服器上的 JSON 檔案。

## 安裝要求
- PHP 伺服器（如 Apache, Nginx）
- PHP 版本 7.0 或更高
- Composer 用於管理 PHP 依賴
- `vlucas/phpdotenv` 用於處理環境變量

## 安裝步驟
1. 複製或下載本項目到您的伺服器目錄。
2. 在專案根目錄下執行 `composer install` 安裝所需依賴。
3. 確保 `community.json` 文件存在，並包含合心和和氣的資料。
4. 設定您的 web 伺服器指向專案目錄。

## 設定指南
1. 複製 `.env.example` 檔案為 `.env`。
2. 在 `.env` 檔案中設定 `MY_APP_FILENAME` 變量，指定資料保存的檔案名稱（不包含 `.json` 副檔名）。
3. 確保 web 伺服器有權限寫入專案目錄，以便 `upload.php` 能夠建立和寫入 JSON 檔案。

## 使用說明
1. 造訪 `index.php`，填寫表單。
2. 提交表單後，資料將透過 AJAX 傳送至 `upload.php`。
3. `upload.php` 處理資料並傳回操作結果。
4. 根據回傳結果，使用者可能會被重新導向到特定頁面或顯示錯誤訊息。

## 常見問題/故障排除
1. 確保伺服器有足夠權限寫入檔案。
2. 如果 `upload.php` 顯示“資料保存失敗”，請檢查目錄權限和磁碟空間。
3. 確保所有依賴項已透過 Composer 安裝。
