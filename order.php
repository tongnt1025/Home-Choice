<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/register.css">
    <title>Home Choice</title>
    <link rel="shortcut icon" href="./images/thiet-ke-logo-do-gia-dung-hc.jpg">
    <script src="./jQuery.js"></script>
</head>
<body>
  
    <?php 
         session_start();
         include("./admin/config.php");
         $accountName="";
         if (isset($_SESSION["accountName"]) && isset($_SESSION["id"])) {
            $accountName = $_SESSION["accountName"];
            $id = $_SESSION["id"];
         }
         if(isset($_POST["order"])){
            $sql = "insert into orders (id,idProduct,img,name,price,quantity) select id,idProduct,img,name,price,quantity from cart where cart.id=$id";
            $conn->query($sql);
            $sql="delete from cart where cart.id=$id";
            $conn->query($sql);
            echo "<script>alert('Đặt hàng thành công'); window.location.href = 'index.php';</script>";
            exit(); 
         }
    ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Danh sách đơn hàng</h2>
        <br>
        <?php 
        $total=0;
        $query="select cart.id,cart.idProduct,cart.img,cart.name,cart.price,cart.quantity from cart,user where user.id=cart.id";
        $carts=mysqli_query($conn,$query);
        while($cart=mysqli_fetch_array($carts)){?>
                <div style="display:flex;flex-direction: column;">
                    <div class="cart-img">
                        <img style="width:100px" src="./images/<?php echo($cart["img"])?>">
                    </div>
                    <div style="width:90px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo($cart["name"])?></div>
                    <div style="display:flex">
                        <div style="padding-right:10px" id="price"class="price"><?php echo number_format($cart["price"], 0, ',', '.');?></div>X
                        <div id="price-none" class="price-none" style="display:none"><?php echo $cart["price"];?></div>
                        <input style="margin-left: 11px;width: 50px;" type="number" min="1"  value="<?php echo $cart["quantity"];?>" class="quantity"></input>
                    </div>
                    <input name="id" type="hidden" value="<?php echo($cart["idProduct"])?>">
                </div>
               <?php $total+=$cart["price"]*$cart["quantity"]; ?>
         <?php }?>
        <h2>Tổng thanh toán:<input style="border:none;font-size:24px" readonly class="total" name="total" value="<?php echo number_format($total, 0, ',', '.'); ?>" id="total" readonly></input></h2>
        <input type="submit" value="Đặt hàng" name="order">
        <a style="margin-top:20px;text-decoration:none" href="index.php">Trờ về trang chủ</a>
    </form>
    <script>
        $(document).ready(function() {
                $(".quantity").on('input', function(){
                var quantityValue = $(this).val();
                if($.isNumeric(quantityValue)&& parseInt(quantityValue) >=1){
                    let prices=document.querySelectorAll('.price-none');
                    let arrayPrice=[];
                    let quantity=document.querySelectorAll('.quantity');
                    let arrayQuantity=[];
                    for (let i = 0; i < prices.length; i++) {
                        let innerHTML = prices[i].innerHTML;
                        arrayPrice.push(innerHTML);
                    }
                    for (let i = 0; i < quantity.length; i++) {
                        let innerHTML = quantity[i].value;
                        arrayQuantity.push(innerHTML);
                    }
                    console.log(arrayQuantity);
                    $.ajax({
                        url: 'update_total.php',
                        type: 'post',
                        data: { quantity: arrayQuantity,price: arrayPrice},
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
    </script>
    
</body>
</html>
