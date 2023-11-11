<?php
if(isset($_POST['quantity'])){
    $quantity = ($_POST['quantity']);
    $price = $_POST['price'];
    // Tính toán giá trị mới cho ô "total"
    $total=0;
    for($i=0;$i<count($price);$i++){
        $total+=$price[$i]* (int)$quantity[$i];
    }
    echo number_format($total, 0, ',', '.');
}

    if(isset($_POST['quantityProductDes'])){
        $quantity = ($_POST['quantityProductDes']);
        $price = $_POST['priceProductDes'];
        echo number_format($quantity*$price, 0, ',', '.');
    }

?>