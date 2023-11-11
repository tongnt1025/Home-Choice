<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../css/admin.css">
  <title>Home Choice</title>
  <link rel="shortcut icon" href="../images/thiet-ke-logo-do-gia-dung-hc.jpg">
</head>
<body>
  <?php
      include("./config.php");
      $query = "SELECT * FROM products";
      $products = mysqli_query($conn, $query);
   ?>
  <header>
    <h1>Quản lý sản phẩm</h1>
  </header>
  <a style="text-align: center;font-size:20px; margin:15px 0px;display:block" href="./home.php">Trở về trang trước</a>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên sản phẩm</th>
          <th>Giá</th>
          <th>Giá khuyến mãi</th>
          <th>Ảnh</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
      <?php 
          while($rows = mysqli_fetch_array($products)){
          
      ?>
        <tr>
          <td><?php echo($rows["id"])?></td>
          <td><?php echo($rows["name"]) ?></td>
          <td><?php echo number_format($rows["price"], 0, ',', '.'); ?></td>
          <td><?php  echo number_format($rows["pricePromotional"], 0, ',', '.'); ?></td>
          <td>
            <div class="img-box">
                <img src="../images/<?php echo $rows["img"]?>" alt="" style="width:50px">
            </div></td>
          <td>
            <a href="#" class="button">Xóa</a>
          </td>
        </tr>
       <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>