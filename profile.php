<!DOCTYPE html>
<html>
<head>
  <title>Home Choice</title>
  <link rel="shortcut icon" href="../images/thiet-ke-logo-do-gia-dung-hc.jpg">
  <link href="./css/admin.css" rel="stylesheet"/>
</head>
<body>
  <?php
    session_start();
    include("./admin/config.php");
    $id="null";
    if (isset($_SESSION["accountName"]) && isset($_SESSION["id"])) {
        $accountName = $_SESSION["accountName"];
        $id = $_SESSION["id"];
    }
   ?>
   
  <header>
    <h1>Thông tin khách hàng</h1>
  </header>
  <a style="text-align: center;font-size:20px; margin:15px 0px;display:block" href="./index.php">Trở về trang trước</a>
  <div class="container">
        <?php 
        $query = "SELECT * FROM user where id=$id";
        $user = mysqli_query($conn, $query);
          while($rows = mysqli_fetch_array($user)){
          $idUser = $rows['id'];
        ?>
          <p>ID: <?php echo $idUser?></p>
          <p>Tên tài khoản: <?php echo($rows["accountName"]) ?></p>
          <p>Tên người dùng: <?php echo($rows["userName"]) ?></p>
          <p>Email: <?php echo($rows["email"]) ?></p>
          <p>Điện thoại: <?php echo($rows["phone"]) ?></p>
          <p>Địa chỉ: <?php echo($rows["address"]) ?></p>
          <p>Mật khẩu: <?php echo($rows["password"]) ?></p>
          <h2>Danh sách giỏ hàng</h2>
          <table style="margin-bottom:50px">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
            <tbody>
                <?php 
                      include("./admin/config.php");
                    $query = "SELECT cart.img,cart.name,cart.price,cart.quantity FROM cart,user where cart.id=user.id && cart.id=$idUser";
                    $carts = mysqli_query($conn, $query);
                ?>
                <?php while($rows = mysqli_fetch_array($carts)){?>
                    <tr>
                        <td><p><?php echo($rows["name"]) ?></p></td> 
                        <td><p><?php echo($rows["price"]) ?></p></td> 
                        <td><p><?php echo($rows["quantity"]) ?></p></td> 
                    </tr>
                <?php } ?>
            </tbody>
           </table>
           <h2>Danh sách đặt hàng</h2>
          <table style="margin-bottom:50px">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
            <tbody>
                <?php 
                     include("./admin/config.php");
                    $query = "SELECT orders.name,orders.price,orders.quantity FROM orders,user where orders.id=user.id && orders.id=$idUser";
                    $carts = mysqli_query($conn, $query);
                ?>
                <?php while($rows = mysqli_fetch_array($carts)){?>
                    <tr>
                        <td><p><?php echo($rows["name"]) ?></p></td> 
                        <td><p><?php echo($rows["price"]) ?></p></td> 
                        <td><p><?php echo($rows["quantity"]) ?></p></td> 
                    </tr>
                <?php } ?>
            </tbody>
           </table>
        <?php } ?>
  </div>
  
</body>
</html>