<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Home Choice</title>
      <link rel="shortcut icon" href="./images/thiet-ke-logo-do-gia-dung-hc.jpg">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
      <link href="css/style.css" rel="stylesheet" />
      <link href="css/responsive.css" rel="stylesheet" />
      <script src="./jQuery.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <?php
     session_start();
     include("./admin/config.php");
     $product;
     $quantity=1;
     $accountName="";
     $idUser="";
      if (isset($_SESSION["accountName"]) && isset($_SESSION["id"])) {
         $accountName = $_SESSION["accountName"];
         $idUser = $_SESSION["id"];
      }
     if (isset($_GET['id'])) {
        $id = $_GET['id'];
       
        $query = "SELECT * FROM products where id ='$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_row($result);
        } else {
            echo "Không có kết quả.";
        }
      }
       if(isset($_POST['order'])){
         if($accountName==""){
            echo "<script>alert('Bạn cần đăng nhập');</script>";
         }
         else{
         $quantity=$_POST['quantityProductDes'];
         $sql = "INSERT INTO cart (
            id,
            idProduct,	
            img,
            name,	
            price,	
            quantity	) VALUES ('$idUser',$product[0],'$product[6]','$product[1]','$product[3]','$quantity')";
            mysqli_query($conn, $sql);
       }
      }
     ?>
     <div class="hero_area productDes">
         <header class="header_section">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="index.php"><img style="height:50px" src="./images/thiet-ke-logo-do-gia-dung-hc-shortcut-icon.jpg"></img></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav">
                        <li class="nav-item active">
                           <a class="nav-link" href="index.php">Trang Chủ<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="product.php">Sản Phẩm</a>
                        </li>
                        <li class="nav-item">
                           <?php if($accountName!=""){  $isNullCart=false;?>
                              <div class="box-user">
                                 <a class="nav-link" href=""><?php echo $accountName?></a>
                                 <div class="icon-cart">
                                    <i class="fa-solid fa-cart-shopping "></i>
                                    <div class="box-cart">
                                    <?php 
                                           $query="select cart.id,cart.idProduct,cart.img,cart.name,cart.price,cart.quantity from cart,user where user.id=cart.id && user.id=$idUser";
                                           $carts=mysqli_query($conn,$query);
                                           while($cart=mysqli_fetch_array($carts)){  $isNullCart=true;?>
                                             <form action="" method="post">
                                                <div class="list-item-cart">
                                                   <div class="cart-img">
                                                       <img src="./images/<?php echo($cart["img"])?>">
                                                   </div>
                                                   <div style="width:90px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo($cart["name"])?></div>
                                                   <div><?php echo number_format($cart["price"], 0, ',', '.');?> X</div>
                                                   <div style="margin-left:2px"><?php echo($cart["quantity"])?></div>
                                                   <input name="id" type="hidden" value="<?php echo($cart["idProduct"])?>">
                                                   <button name="delete" class="delete" type="submit">Xóa</button>
                                                </div>
                                             </form>
                                             <?php 
                                                    if(isset($_POST["delete"])){
                                                       $idDelete = $_POST["id"];
                                                       $query = "DELETE FROM cart where idProduct ='$idDelete'";
                                                       $result = mysqli_query($conn, $query);
                                                       header("Refresh:0");
                                                    }
                                                    
                                                 ?>
                                        <?php }
                                     ?>
                                     <?php if($isNullCart) echo  '<button style="width:100px;margin-left: 250px;margin-bottom: 10px;background-color: #f7444e;"><a style="color:white" href="order.php">Đặt hàng</a></button>'; 
                                           else   echo '<div>
                                           <img style="width:100px;display:block;margin:auto" src="./images/giohang.png">
                                           <h2 style="text-align: center; padding:10px">Giỏ hàng trống</h2>
                                        </div>'
                                     ?>
                                    </div>
                                 </div>
                              </div>
                          <?php }?>
                           <?php if($accountName==""){ ?>
                              <a class="nav-link" href="login.php">Đăng Nhập</a>
                          <?php }?>
                           </a>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </header>
      </div>
   
     <div class="container">
         <div class="row">
            <div class="col-lg-5">
                    <div class="img-box productDes">
                        <img src="./images/<?php echo($product[6])?>" alt="">
                    </div>
            </div>
            <div class="col-lg-7">
                    <form action="" method="POST">
                       <div class="detail-box productDes">
                           <h5>
                           <?php echo($product[1])?>
                           </h5>
                           <h6 style="text-decoration: line-through;">
                           <?php echo number_format($product[2], 0, ',', '.');?>
                           </h6>
                           <h5 class="price" style="display:none">
                             <?php echo $product[3];?>
                           </h5>
                           <h5 class="pricePromotional">
                             <?php echo number_format($product[3], 0, ',', '.');?>
                           </h5>
                       <div>
                           <input class="quantityProductDes" style="width: 50px;font-size: 20px;"name="quantityProductDes" type="number" min="1" value="<?php echo $quantity?>" ></input>
                       </div>
                              <div class="total-box" style="font-size:20px">
                                  Thành tiền
                                  <input class="total" id="total" value="<?php echo $quantity*$product[3];?>"></input>
                              </div>
                           <p>
                              <?php echo($product[5])?>
                           </p>
                          <button name="order" type="submit" id="order" class="order">Thêm vào giỏ hàng</button>
                       </div>
                    </form>
                    <script>
                           $(document).ready(function() {
                                    $(".quantityProductDes").on('input', function(){
                                     var quantityValue = $(this).val();
                                    let price =document.querySelector(".price").innerHTML;
                                    if($.isNumeric(quantityValue) && parseInt(quantityValue) >=1){
                                       $.ajax({
                                             url: 'update_total.php',
                                             type: 'post',
                                             data: { quantityProductDes: quantityValue,priceProductDes: price},
                                             success: function(response){
                                                $("#total").val(response);
                                                console.log(response);
                                             }
                                       });
                                    }
                                    if($.isNumeric(quantityValue)&& parseInt(quantityValue) < 1){
                                       alert("Vui lòng nhập số lượng lớn hơn 0");
                                    }
                                 });
                           });
                           document.getElementById("order").addEventListener("click", function() {
                              alert("Thêm sản phẩm thành công");
                           });
                     </script>
            </div>
        </div>
     </div>
     <footer>
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                   <div class="full">
                      <div class="logo_footer">
                        <a href="index.php"><img style="height:50px" src="./images/thiet-ke-logo-do-gia-dung-hc.png"></img></a>
                      </div>
                      <div class="information_f">
                        <p><strong>Địa chỉ:</strong> 218 Lĩnh Nam, Hoàng Mai, Hà Nội</p>
                        <p><strong>Điện thoại:</strong> +84 987 654 3210</p>
                        <p><strong>EMAIL:</strong>nguyentong1025@gmail.com</p>
                      </div>
                   </div>
               </div>
               <div class="col-md-8">
                  <div class="row">
                  <div class="col-md-7">
                     <div class="row">
                        <div class="col-md-6">
                     <div class="widget_menu">
                        <h3>Menu</h3>
                        <ul>
                           <li><a href="index.php">Trang chủ</a></li>
                           <li><a href="product.php">Sản phẩm</a></li>
                           <li><a href="./admin/home.php">Admin</a></li>
                           <?php if($idUser!=null) echo '<li><a href="profile.php">Thông tin tài khoản</a></li>'?> 
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="widget_menu">
                        <h3>Tài khoản</h3>
                        <ul>
                           <li><a href="login.php">Đăng nhập</a></li>
                           <li><a href="register.php">Đăng ký</a></li>
                           <?php
                              if(isset($_POST["logOut"])){
                                 session_start();
                                 $_SESSION["accountName"]="";
                                 $_SESSION["id"] ="";
                                 echo '<script>';
                                 echo 'window.location.href = window.location.href;';
                                 echo '</script>';
                              }
                            ?>
                           <form action="" method="post"><button name="logOut" class="log-out">Đăng xuất</button></form>
                        </ul>
                     </div>
                  </div>
                     </div>
                  </div>     
                  <div class="col-md-5">
                     <div class="widget_menu">
                        <h3>Mạng xã hội</h3>
                        <ul>
                           <li><a href="https://www.facebook.com/">Facebook</a></li>
                           <li><a href="https://www.tiktok.com/">Tiktok</a></li>
                           <li><a href="https://www.instagram.com/">Instagram</a></li>
                        </ul>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <div class="cpy_">
         <p>Nguyễn Thanh Tòng - 25/10/2002</p>
         <p>Nguyễn Thanh Tòng - 25/10/2002</p>
         <p>Nguyễn Thanh Tòng - 25/10/2002</p>
      </div>
</body>
</html>