# Circle - 線上訂餐與商店管理系統 (Web Application)

## 1. 專案簡介 (Project Overview)
**Circle** 是一個基於 PHP 與 MySQL 開發的 Web 應用程式，旨在提供使用者一個線上瀏覽商店、下單訂購以及管理個人錢包的平台。系統整合了會員註冊登入、商店列表展示、訂單管理與虛擬錢包功能，並採用 Bootstrap 進行響應式網頁設計。

## 2. 技術棧 (Tech Stack)
* **前端 (Frontend):** HTML5, CSS3 (Sass/SCSS), JavaScript (jQuery), Bootstrap (Responsive UI)
* **後端 (Backend):** PHP (Native)
* **資料庫 (Database):** MySQL (SQL)
* **其他 (Others):** Animate.css (動畫效果), Icomoon (圖標字體)

---

## 3. 系統架構概念 (System Architecture)

本系統採用標準的 LAMP/WAMP 架構邏輯。以下為系統的整體架構與概念示意：

### 3.1 系統主架構圖
![System Architecture](6.jpg)
*(系統架構與運作邏輯總覽)*

### 3.2 資料庫與流程設計
![ER Diagram or Flow](5.png)
*(資料庫實體關聯或使用者操作流程示意)*

---

## 4. 功能模組說明 (Functional Modules)

系統主要分為以下幾個核心模組，滿足使用者從註冊到下單的完整流程。

### A. 會員管理模組 (User Authentication)
使用者可以註冊帳戶並登入系統，進行個人資料的維護。
* **相關檔案:** `login.php`, `register.php`, `sign-up.html`, `logout.php`
* **功能:** 使用者註冊、登入驗證、Session 管理。

### B. 商店與商品模組 (Shop & Product)
提供商店的建立、搜尋與列表展示，讓使用者能瀏覽不同店家的資訊。
* **相關檔案:** `shoplist.php`, `shopadd.php`, `shopregister.php`, `search.php`, `showm.php`
* **功能:** 商店列表展示、新增商店申請、關鍵字搜尋。

### C. 訂單處理系統 (Order System)
核心交易功能，支援下單、查看訂單詳情與取消訂單。
* **相關檔案:** `order.php`, `myorder.php`, `o_detail.php`, `o_cancel.php`
* **功能:** 建立訂單、查看歷史訂單、訂單詳情與取消功能。

### D. 錢包與支付 (Wallet & Payment)
模擬電子錢包功能，使用者可管理帳戶餘額以進行支付。
* **相關檔案:** `wallet.php`
* **功能:** 餘額查詢、儲值與扣款邏輯 (`action.php`)。

---

## 5. 系統介面展示 (UI Showcase)

以下依序展示系統實際運行之操作介面與功能畫面：

### 5.1 核心功能介面
| 介面一 | 介面二 |
| :---: | :---: |
| ![UI Screenshot 1](4.jpg) | ![UI Screenshot 2](3.png) |
| *主要功能或首頁畫面* | *列表或選單畫面* |

### 5.2 詳細操作介面
| 介面三 | 介面四 |
| :---: | :---: |
| ![UI Screenshot 3](2.jpg) | ![UI Screenshot 4](1.png) |
| *訂單或詳細資訊畫面* | *個人中心或錢包畫面* |

---

## 6. 檔案結構說明 (File Structure)

專案目錄 `circle/` 下的主要檔案功能對照：

```bash
circle/
├── index.html          # 系統入口首頁 (Landing Page)
├── menu.php            # 選單功能
├── nav.php             # 頂部導覽列 (Navigation Bar)
├── action.php          # 後端邏輯處理 (Action Handler)
├── result.php          # 處理結果顯示
├── find.php            # 查詢邏輯
├── edit.php            # 編輯資料邏輯
├── css/                # 樣式表 (Bootstrap, Custom Style)
├── js/                 # JavaScript 腳本 (Main logic, Plugins)
├── fonts/              # 字型圖標資源
└── images/             # 圖片資源
