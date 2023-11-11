<!DOCTYPE html>
<html>
   <head>
    
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <title>Home Choice</title>
      <link rel="shortcut icon" href="./images/thiet-ke-logo-do-gia-dung-hc.jpg">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
      <link href="css/style.css" rel="stylesheet" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
      <link href="css/responsive.css" rel="stylesheet" />
   </head>
   <body class="sub_page">
   <?php
     session_start();
     include("./admin/config.php");
     $accountName="";
     $id="null";
      if (isset($_SESSION["accountName"]) && isset($_SESSION["id"])) {
         $accountName = $_SESSION["accountName"];
         $id = $_SESSION["id"];
      }
      $numberOfProductsPerPage = 9; 
      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
      $posStart = ($currentPage - 1) * $numberOfProductsPerPage;
      $query = "SELECT * FROM products LIMIT $posStart, $numberOfProductsPerPage";
      $products = mysqli_query($conn, $query);
      
      $queryTotal = "SELECT * FROM products";
      $resultTotal = mysqli_query($conn, $queryTotal);
      $numRows = mysqli_num_rows($resultTotal);

     ?>
     <?php 
        $arrItem=[];
        $arrPrice=[];
        $isSubmit=false;
        $result="null";
        $resultPrice="null";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $isSubmit=true;
            if (!empty($_POST["items"]) ) {
               $arrItem=$_POST["items"];
               $result='';
               foreach ($arrItem as $value) {
                  $result .= "'" . $value . "', ";
               }
             
               $result = rtrim($result, ', ');
             
            } else {
              // echo "<p>Bạn chưa chọn bất kỳ mục nào.</p>";
            }
         if(!empty($_POST["prices"])){
            $arrPrice=$_POST["prices"];
            $resultPrice='';
            foreach ($arrPrice as $value) {
               if($value=='0->1m'){
                  $resultPrice=($resultPrice."price<1000000");
               }
               if($value=='1m->2m'){
                  $resultPrice=($resultPrice." OR price BETWEEN 1000000 AND 2000000");
               }
               if($value=='0->5m'){
                  $resultPrice=($resultPrice." OR price<5000000");
               }
               if($value=='>10m'){
                  $resultPrice=($resultPrice." OR price>10000000");
               }
               
            }
            $resultPrice = trim($resultPrice);
            $character = substr($resultPrice,0, 2);
            if($character==="OR"){
               $resultPrice = substr($resultPrice, 2);
            }
         }
         $query="select * from products where classify in($result) AND $resultPrice";
         $products=mysqli_query($conn,$query);
     }
     ?>
       
   <div class="hero_area productDes">
         <header class="header_section">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="index.php"><img style="height:50px" src="./images/thiet-ke-logo-do-gia-dung-hc.png"></img></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav">
                        <li class="nav-item">
                           <a class="nav-link" href="index.php">Trang Chủ<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                           <a class="nav-link" href="product.php">Sản Phẩm</a>
                        </li>
                        <li class="nav-item">
                           <?php if($accountName!=""){  $isNullCart=false; ?>
                              <div class="box-user">
                                 <a class="nav-link" href=""><?php echo $accountName?></a>
                                 <div class="icon-cart">
                                    <i class="fa-solid fa-cart-shopping "></i>
                                    <div class="box-cart">
                                    <?php 
                                           $query="select cart.id,cart.idProduct,cart.img,cart.name,cart.price,cart.quantity from cart,user where user.id=cart.id && user.id=$id";
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
                                     <?php if($isNullCart) echo '<button style="width:100px;margin-left: 250px;margin-bottom: 10px;background-color: #f7444e;"><a style="color:white" href="order.php">Đặt hàng</a></button>'; 
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
      <section class="product_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-md-4 col-lg-3">
                  <form method="post">
                     <h2>Danh mục sản phẩm</h2>
                     <div class="form-group">
                        <input type="checkbox" name="items[]" <?php if (in_array('GDNhaBep', $arrItem)) echo 'checked' ?> value="GDNhaBep" id="ao">
                        <label for="ao">Gia dụng nhà bếp</label>
                     </div>
                    
                     <div class="form-group">
                        <input type="checkbox" name="items[]" <?php if (in_array('NTPhongKhach', $arrItem)) echo 'checked' ?> value="NTPhongKhach" id="quan">
                        <label for="quan">Nội thất phòng khách</label>
                     </div>
                     
                     <div class="form-group">
                        <input type="checkbox" name="items[]" <?php if (in_array('NTPhongNgu', $arrItem)) echo 'checked' ?> value="NTPhongNgu" id="mu">
                        <label for="mu">Nội thất phòng ngủ</label>
                     </div>
                     <div class="form-group">
                        <input type="checkbox" name="items[]" <?php if (in_array('TBGiaDung', $arrItem)) echo 'checked' ?> value="TBGiaDung" id="giay">
                        <label for="giay">Thiết bị gia dụng</label>
                     </div>
                     <h2>Mức giá</h2>


                     <div class="form-group">
                        <input type="checkbox" name="prices[]" <?php if (in_array('0->1m', $arrPrice)) echo 'checked' ?> value="0->1m" id="ao">
                        <label for="ao">Dưới 1 triệu</label>
                     </div>
                    
                     <div class="form-group">
                        <input type="checkbox" name="prices[]" <?php if (in_array('1m->2m', $arrPrice)) echo 'checked' ?> value="1m->2m" id="quan">
                        <label for="quan">Từ 1 - 2 triệu</label>
                     </div>
                     
                     <div class="form-group">
                        <input type="checkbox" name="prices[]" <?php if (in_array('0->5m', $arrPrice)) echo 'checked' ?> value="0->5m" id="mu">
                        <label for="mu">Dưới 5 triệu</label>
                     </div>
                     <div class="form-group">
                        <input type="checkbox" name="prices[]" <?php if (in_array('>10m', $arrPrice)) echo 'checked' ?> value=">10m" id="giay">
                        <label for="giay">Trên 10 triệu</label>
                     </div>

                     <input type="submit" class="submit" value="Áp dụng">
                  </form>

               </div>
               <div class="col-sm-6 col-md-4 col-lg-9">
                  <div class="row">
                     <?php 
                           while($rows = mysqli_fetch_array($products)){
                     ?>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                           <div class="box">
                              <div class="option_container">
                                 <div class="options">
                                    <a href="productDes.php?id=<?php echo($rows["id"])?>" class="option2">
                                    Mua Ngay
                                    </a>
                                 </div>
                              </div>
                              <div class="img-box">
                                 <img src="./images/<?php echo($rows["img"])?>" alt="">
                              </div>
                              <div class="detail-box">
                                 <h5>
                                    <?php echo($rows["name"]) ?>
                                 </h5>
                                 <h6>
                                 <?php echo number_format($rows["pricePromotional"], 0, ',', '.');?>
                                 </h6>
                                 <h5>
                                 <?php echo number_format($rows["price"], 0, ',', '.');?>
                                 </h5>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
                  <div class="btn-box">
             <?php
              if($isSubmit==false) for ($i = 1; $i <= ceil($numRows/$numberOfProductsPerPage); $i++) {?>
                  <a href="?page=<?php echo $i ?>" style="<?php if($currentPage==$i)echo "background-color:white" ?>"><?php echo $i ?></a>
                   
             <?php  }?>
            </div>
               </div>
            
         </div>
      </section>
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
                           <?php if($id!=null) echo '<li><a href="profile.php">Thông tin tài khoản</a></li>'?> 
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