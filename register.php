<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/register.css">
    <title>Home Choice</title>
    <link rel="shortcut icon" href="./images/thiet-ke-logo-do-gia-dung-hc.jpg">
</head>
<body>
  
    <?php
        include('./admin/config.php');
        $errors = array();
        $errors["accountName"]="";
        $errors["userName"]="";
        $errors["email"] = "";
        $errors["phone"] = "";
        $errors["address"] = "";
        $errors["password"] = "";
        $accountName="";
        $username="";
        $email ="";
        $phone="";
        $address="";
        $password="";
        $confirmPassword ="";
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = array();
        $accountName = $_POST["account_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        if (empty($accountName)) {
            $errors["accountName"] = "Vui lòng nhập tên tài khoản.";
        }
        else{
            $errors["accountName"] = "";
        }

        if (empty($username)) {
            $errors["userName"] = "Vui lòng nhập tên đăng nhập.";
        }
        else{
            $errors["userName"] = "";
        }

        if (empty($email)) {
            $errors["email"] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Email không hợp lệ.";
        }
        else{
            $errors["email"] = "";
        }

        if (empty($phone)) {
            $errors["phone"] = "Vui lòng nhập số điện thoại.";
        }
        else{
            $errors["phone"] = "";
        }

        if (empty($address)) {
            $errors["address"] = "Vui lòng nhập địa chỉ.";
        }
        else{
            $errors["address"] = "";
        }

        if (empty($password)) {
            $errors["password"] = "Vui lòng nhập mật khẩu.";
        } elseif ($password !== $confirmPassword) {
            $errors["password"] = "Mật khẩu nhập lại không khớp.";
        }
        else{
            $errors["password"] = "";
        }
        $isSubmit=true;
        foreach($errors as $key => $value){
            if($value!=""){
                $isSubmit=false;
            }
        }
        if($isSubmit){
            $sql = "INSERT INTO user (accountName,userName,email,phone,address,password) VALUES ('$accountName','$username','$email','$phone','$address','$password')";
            mysqli_query($conn, $sql);
            echo "<script>alert('Đăng ký thành công');</script>";
        }
        
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Đăng kí</h2>
        <label for="account_name">Tên tài khoản:</label>
        <input type="text" name="account_name" id="account_name" value="<?php echo $accountName ?> ">
        <p class="error"><?php echo $errors["accountName"];?></p>
        <br>

        <label for="username">Tên người dùng:</label>
        <input type="text" name="username" id="username" value="<?php echo $username ?>">
        <p class="error"><?php echo $errors["userName"];?></p>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email ?>">
        <p class="error"><?php echo $errors["email"];?></p>
        <br>

        <label for="phone">Số điện thoại:</label>
        <input type="tel" name="phone" id="phone" value="<?php echo $phone ?>">
         <p class="error"><?php echo $errors["phone"];?></p>
        <br>

        <label for="address">Địa chỉ:</label>
        <input type="text" name="address" id="address" value="<?php echo $address ?>">
        <p class="error"><?php echo $errors["address"];?></p>
        <br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" value="<?php echo $password ?>">
        <p class="error"><?php echo $errors["password"];?></p>
        <br>

        <label for="confirm_password">Nhập lại mật khẩu:</label>
        <input type="password" name="confirm_password" id="confirm_password" value="<?php echo $confirmPassword ?>">
        <br>
        <input type="submit" value="Đăng kí">
        <a style="margin-top:20px;text-decoration:none" href="login.php">Trờ về trang đăng nhập</a>
    </form>
</body>
</html>