<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Choice</title>
    <link rel="shortcut icon" href="./images/thiet-ke-logo-do-gia-dung-hc.jpg">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <?php 
        include("./admin/config.php");
        $accountInput="";
        $passwordInput="";
        if(isset($_POST["submit"])){
            $accountInput=$_POST["account_name"];
            $passwordInput=$_POST["password"];
            $query="select * from user";
            $users=mysqli_query($conn,$query);
            while($user=mysqli_fetch_array($users)){
                if($user["accountName"]==$accountInput && $user["password"]==$passwordInput){
                    session_start();
                    $_SESSION["accountName"] =$accountInput;
                    $_SESSION["id"] = $user["id"];
                    header("Location: ./index.php");
                    exit();
                }
            }
        }
       
    ?>
<form method="POST" action="" style="margin-top:80px">
        <label for="account_name">Tên tài khoản:</label>
        <input type="text" name="account_name" id="account_name" value="<?php echo $accountInput ?>">
        <br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" value="<?php echo $passwordInput ?>">
        <br>
        <input type="submit" value="Đăng nhập" name="submit" id="submit">
        <p>Bạn chưa có tài khoản?</p>
        <a style="font-size:20px;text-decoration:none" href="register.php">Đăng ký</a><br>
        <a style="font-size:20px;text-decoration:none" href="index.php">Quay về trang chủ</a>
    </form>
    <div>
        <img src="./images/phaohoa.gif">
        <img src="./images/phaohoa.gif">
        <img src="./images/phaohoa.gif">
    </div>
</body>
</html>