<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$db = new mysqli("localhost", "root", "", "msgboard");
if ($db->connect_error) {
    die("連線失敗: " . $db->connect_error);
}

// 登出處理
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// 處理動作
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["act"]) && isset($_POST["id"])) {
        $id = intval($_POST["id"]);

        if ($_POST["act"] === "del") {
            $stmt = $db->prepare("DELETE FROM account WHERE idno = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($_POST["act"] === "chpw" && isset($_POST["pw"])) {
            $hashed = password_hash($_POST["pw"], PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE account SET pass = ? WHERE idno = ?");
            $stmt->bind_param("si", $hashed, $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>帳號管理</title>
    <script>
    function confirmDel(id) {
        if (confirm("你確定要刪除該帳號嗎？資料不可回復喔！")) {
            document.getElementById(`del-form-${id}`).submit();
        }
    }
    function confirmChpw(id) {
        if (confirm("你確定要修改密碼嗎？")) {
            let pw = prompt("請輸入新密碼：");
            if (pw !== null && pw.trim() !== "") {
                let form = document.getElementById(`chpw-form-${id}`);
                form.elements["pw"].value = pw;
                form.submit();
            }
        }
    }
    </script>
</head>
<body>
    <h2>帳號管理</h2>
    <form method="post" style="float:right;">
        <button type="submit" name="logout">登出</button>
    </form>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>帳號</th>
            <th>名稱</th>
            <th>功能</th>
        </tr>
        <?php
        $res = $db->query("SELECT * FROM account ORDER BY acct ASC");
        while ($row = $res->fetch_assoc()) {
            $id = $row["idno"];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["acct"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>
                    <form id='del-form-{$id}' method='POST' style='display:inline;'>
                        <input type='hidden' name='act' value='del'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='button' onclick='confirmDel({$id})'>刪除</button>
                    </form>
                    <form id='chpw-form-{$id}' method='POST' style='display:inline;'>
                        <input type='hidden' name='act' value='chpw'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='hidden' name='pw'>
                        <button type='button' onclick='confirmChpw({$id})'>修改密碼</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
