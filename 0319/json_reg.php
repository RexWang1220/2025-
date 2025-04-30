<html>
    <head>
        <title>註冊會員</title>
        <meta charset="UTF-8">
        <script>
<?php
    if(isset($_POST["acct"])) {
        if(strcmp($_POST["pass1"],$_POST["pass2"])) {
            print("alert('密碼不一致');");
        } else {
            $filename="member.json";
            $newmember=true;
            $member=[];
            if(file_exists($filename)) {
                $all=file_get_contents($filename);
                $member=json_decode($all,true);
                foreach($member as $m) {
                    if(0==strcmp($m["id"],$_POST["acct"])) {
                        printf("alert('會員已存在');");
                        $newmember=false;
                        break;
                    }
                }
            }
            if($newmember) {
                array_push($member,[
                "id"=>$_POST["acct"],
                "name"=>$_POST["name"],
                "pw"=>password_hash($_POST["pass1"],PASSWORD_DEFAULT)]);
            $json=json_encode($member);
            file_put_contents($filename,$json);
            printf("location.href='json_login.php';");
            }
        }
    }
?>
        </script>
    </head>
    <body>
        <H1>註冊會員</H1>
        <form method="post">
            <p>帳號：<input type="text" name="acct" placeholder="登入用的帳號"></p>
            <p>顯示名稱：<input type="text" name="name" placeholder="登入後的顯示名稱"></p>
            <p>密碼：<input type="password" name="pass1" placeholder="登入用的密碼"></p>
            <p>確認密碼：<input type="password" name="pass2" placeholder="確認兩次密碼要相同"></p>
            <p>
                <input type="submit" value="我要註冊">
                <input type="button" value="點我註冊" onclick="location.href='json_reg.php';">
            </p>
        </form>
    </body>
</html>