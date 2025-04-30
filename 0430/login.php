<?php
session_start();
$db = new mysqli("localhost", "root", "", "msgboard");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $acct = $_POST["acct"];
    $pw = $_POST["pw"];
    $stmt = $db->prepare("SELECT * FROM account WHERE acct=?");
    $stmt->bind_param("s", $acct);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($pw, $row["pass"])) {
            $_SESSION["admin"] = $row["acct"];
            header("Location: admin.php");
            exit;
        }
    }
    $error = "帳號或密碼錯誤";
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>登入</title></head>
<body>
<h2>管理登入</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    帳號：<input name="acct"><br>
    密碼：<input type="password" name="pw"><br>
    <button type="submit">登入</button>
</form>
<br>
<form action="reg.php">
    <button type="submit">我要註冊</button>
</form>
</body>
</html>
