<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Choice</title>
    <link rel="shortcut icon" href="../images/thiet-ke-logo-do-gia-dung-hc.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>
<body>

    <?php
      include('./config.php');
            $name="";
            $price="";
            $pricePromotional="";
            $classify="";
            $description="";
            $filename="";
            if(isset($_POST["submit"])){
               
                $filename = $_FILES["uploadFile"]["name"];
                $tempname = $_FILES["uploadFile"]["tmp_name"];
                $folder = "../images/" . $filename;

                $name=$_POST["name"];
                $price=$_POST["price"];
                $pricePromotional=$_POST["pricePromotional"];
                $classify=$_POST["classify"];
                $description=$_POST["description"];
               
               
                $sql = "INSERT INTO products (name,price,pricePromotional,classify,description,img) VALUES ('$name','$price','$pricePromotional','$classify','$description','$filename')";
                mysqli_query($conn, $sql);
                if (move_uploaded_file($tempname, $folder)) {
                    echo "<h3>  Image uploaded successfully!</h3>";
                } else {
                    echo "<h3>  Failed to upload image!</h3>";
                }
             
            }
    ?>
    <div class="container">
        <a style="text-align: center;font-size:20px; margin:15px 0px;display:block" href="./home.php">Trở về trang trước</a>
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="input-wrap">
                <label>Nhập tên</label>
                <input type="text" name="name" value="<?php echo $name?>">
            </div>
            <div class="input-wrap">
                <label>Nhập giá khuyến mãi</label>
                <input type="text" name="price" value="<?php echo $price ?>">
            </div>
            <div class="input-wrap">
                <label>Nhập giá</label>
                <input type="text" name="pricePromotional" value="<?php echo $pricePromotional ?>">
            </div>
            <div class="input-wrap">
                <label>Chọn phân loại</label>
                <input type="radio" name="classify" value="NTPhongKhach">Nội thất phòng khách<br>
                <input type="radio" name="classify" value="NTPhongNgu">Nội thất phòng ngủ<br>
                <input type="radio" name="classify" value="GDNhaBep">Gia dụng nhà bếp<br>
                <input type="radio" name="classify" value="TBGiaDung">Thiết bị gia dụng<br>
            </div>
            <div class="input-wrap">
                <label>Nhập mô tả sản phẩm</label>
                <input type="text" name="description" value="<?php echo $description ?>">
            </div>
            <div class="input-wrap">
                <label>Nhập ảnh</label>
                <input type="file"  name="uploadFile" value="">
            </div>
            <div class="input-wrap"><input type="submit" name="submit" value="Thêm sản phẩm"></div>
        </form>
    </div>
<style>
    body {
   display: flex;
   justify-content:center;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    margin-top:50px;
}

h1 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
}
.input-wrap {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="radio"] {
    margin-right: 10px;
}
input[type="submit"],
input[type="reset"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover,
input[type="reset"]:hover {
    background-color: #0056b3;
}

    </style>
</body>
</html>