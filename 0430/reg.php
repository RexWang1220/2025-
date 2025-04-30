<?php
$db = new mysqli("localhost", "root", "", "msgboard");
if ($db->connect_error) {
    die("連線失敗: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $acct = trim($_POST["acct"]);
    $name = trim($_POST["name"]);
    $pw = $_POST["pw"];
    $pw2 = $_POST["pw2"];

    if (empty($acct) || empty($name) || empty($pw)) {
        $error = "所有欄位都必須填寫。";
    } elseif ($pw !== $pw2) {
        $error = "兩次輸入的密碼不一致。";
    } else {
        // 檢查帳號是否已存在
        $stmt = $db->prepare("SELECT idno FROM account WHERE acct=?");
        $stmt->bind_param("s", $acct);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "此帳號已被註冊。";
        } else {
            // 建立帳號
            $hashed = password_hash($pw, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO account (acct, name, pass) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $acct, $name, $hashed);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "註冊失敗，請稍後再試。";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>註冊帳號</title></head>
<body>
<h2>註冊新帳號</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    帳號：<input name="acct" required><br>
    顯示名稱：<input name="name" required><br>
    密碼：<input type="password" name="pw" required><br>
    確認密碼：<input type="password" name="pw2" required><br>
    <button type="submit">註冊</button>
    <a href="login.php">回登入頁</a>
</form>
</body>
</html>
