<html>
    <head>
        <title>註冊會員</title>
        <meta charset="UTF-8">
        <script>
<?php
    if(isset($_POST["acct"])) {
        $db = new mysqli("localhost", "root", "", "msgboard");
        $sql = sprintf("SELECT * FROM account WHERE acc='%s'",$_POST["acct"]);
        $res = $db->query($sql);
        if($res->num_rows<=0) {
            printf("alert('無會員資料，請通知管理員！');");
        } else {
            $rows = $res->fetch_assoc();
            if(password_verify($_POST["pass"],$row["pass"])) {
                printf("alert('歡迎登入，%s');",$row["name"]);
                printf("location.href='mysql_reg.php';");
            }
        }
    }
?>
        </script>
    </head>
    <body>
        <H1>會員登入</H1>
        <form method="post">
            <p>帳號：<input type="text" name="acct"></p>
            <p>密碼：<input type="password" name="pass"></p>
            <p>
                <input type="submit" value="登入">
                <input type="button" value="點我註冊" onclick="location.href='mysql_reg.php';">
            </p>
        </form>
    </body>
</html>