<html>
    <head>
        <title>會員登入</title>
        <meta charest="UTF-8">
        <script>
<?php
    if(isset($_POST["acct"])) {
        $filename="member.json";
        if(file_exists($filename)) {
            $all=file_get_contents($filename);
            $member=json_decode($all,true);
            foreach($member as $m) {
                if(0==strcmp($_POST["acct"],$m["id"]) && password_verify($_POST["pass"],$m["pw"])) {
                    printf("alert('歡迎登入，%s');",$m["name"]);
                    printf("location.href='json_reg.php';");
                    break;
                }
            }
        } else {
            printf("alert('無會員資料，請通知管理員！');");
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
            <p><input type="submit" value="登入"></p>
        </form>
    </body>
</html>