<html>
    <head>
        <title>會員登入</title>
        <meta charset="UTF-8">
        <script>
<?php
    if(isset($_POST["acct"])) {
        $filename="member.csv";
        if(file_exists($filename)) {
            $fp=fopen($filename,"r");
            while(($member=fgetcsv($fp,1000))!==FALSE) {
                if(0==strcmp($member[0],$_POST["acct"]) && password_verify($_POST["pass"],$member[2])) {
                    printf("alert('歡迎登入，%s');",$member[1]);
                    printf("location.href='reg.php';");
                    break;
                }
            }
            fclose($fp);
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