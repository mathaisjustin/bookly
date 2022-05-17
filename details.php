<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

include "header.php";

if(isset($_GET['book_id']))
{
    $book_id = $_GET['book_id'];

    $sql = "SELECT * FROM `products` WHERE id = $book_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count == 1)
    {
        // echo "we have data";
        $row = mysqli_fetch_assoc($res);

        $title = $row['name'];
        $price = $row['price'];
        $desc = $row['description'];
        $image = $row['image'];
    }
    else{
        // echo "no data";
        header('location:home.php');
    }
}
else{
    header("location:home.php");
}

if(isset($_POST['add_to_cart'])){

   $product_name = $title;
   $product_price = $price;
   $product_image = $image;

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!-- book dettails start here -->
<!-- <?php echo $title ?> -->
<!-- <?php echo $price ?> -->
<!-- <?php echo $desc ?> -->
<!-- <?php echo $image ?> -->
<!-- <img class="image" src="uploaded_img/<?php echo $image; ?>" alt="">  -->

<main>
         <div class="container">
             <div class="cover"><img src="uploaded_img/<?php echo $image; ?>" width="100%" height="100%"></div>
             <div class="conteent">
                 <div class="navv">
                     <span class="logo">BOOKLY</span>
                     <!-- <span><i class='fab fa-sistrix' style='font-size:24px'></i></span> -->
                 </div>
                 <div class="content-body">
                     <!-- <div class="pages">
                         <span class="active"><b>01</b></span>
                         <span>02</span>
                         <span>03</span>
                         <span>04</span>
                     </div> -->
                    <div class="black-label">
                        <span class="title"><b><?php echo $title; ?></b></span>
                        <p> <?php echo $desc; ?></p>
                        <div class="prix">
                            <span><b><?php echo "Rs " . $price; ?></b></span>
                            <span><a href="shop.php" class="btn">Order Now</a></span>
                        </div>
                    </div>
                </div>
                 
            </div>
         </div>
     </main>

<?php include "footer.php" ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
