<?php

include 'db.php';

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
        header('location:cart.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header('location:cart.php');
};

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart`");
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>

    <!-- font awesome cdn link  -->
    <script src="https://kit.fontawesome.com/d587626e21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/5.15.3/css/all.min.css" integrity="sha384-eznd5zqXxGq+gFJClHq28KZlaNU9RTRcL4pl1PbpKTepiZhL5K4z4fPeU0zniqz6" crossorigin="anonymous">
    <script src="../javascript/index.js"></script>
    <link rel="stylesheet" href="../css/cart.css">


</head>

<body>

    <!-- navbar section  -->
    <div class="header">
        <div class="container-nav">
            <nav id="navbar">
                <div id="logo">
                    <a href="../code/project.html">
                        <img src="../img/logo.png" alt="logo">
                    </a>
                </div>
                <ul>
                    <li class="item"><a href="../code/project.html">Home</a></li>
                    <!-- <li class="item"><a href="offer.html">Offers</a></li> -->
                    <li class="item"><a href="../code/products.html">Trending</a></li>
                    <li class="item"><a href="#">Categories</a></li>
                    <li class="item"><a href="#contact">Contact us</a></li>
                    <li class="item"><a href="../code/signin.html">Sign in</a></li>
                    <li class="item"> <input id="search" type="text" placeholder="Search Your Gadget!"></li>
                    <li class="cart">
                        <a href="../php/cart.php">Cart
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="container-cart">

        <section class="shopping-cart">

            <h1 class="heading">Shopping Cart</h1>

            <table>

                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total price</th>
                    <th>Action</th>
                </thead>

                <tbody>

                    <?php

                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                    $grand_total = 0;
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    ?>

                            <tr>
                                <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                                <td><?php echo $fetch_cart['name']; ?></td>
                                <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" value="update" name="update_update_btn">
                                    </form>
                                </td>
                                <td>$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-
                                </td>
                                <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                            </tr>
                    <?php
                            $grand_total += $sub_total;
                        };
                    };
                    ?>
                    <tr class="table-bottom">
                        <td><a href="products.php" class="option-btn" style="margin-top: 0;">Continue shopping</a></td>
                        <td colspan="3">Grand total</td>
                        <td>NRS: <?php echo $grand_total; ?>/-</td>
                        <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> Delete all </a></td>
                    </tr>

                </tbody>

            </table>

            <div class="checkout-btn">
                <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Procced to checkout</a>
            </div>

        </section>

    </div>


    <!--footer-->
    <section id="contact">
        <div class="footer">
            <div class="col-1">
                <h2>Usefull Links</h3>
                    <a href="#">Coupons</a>
                    <a href="#">Blog Post</a>
                    <a href="#">Return Policy</a>
                    <a href="#">Join affiliate</a>
            </div>
            <div class="col-2">
                <h2>Feedback</h3>
                    <form>
                        <input type="text" placeholder="Enter your feedback">
                        <br>
                        <button id="feedback" onclick="submitted()" type="submit">Submit feedback </button>
                    </form>
                    
                </div>
                <div class="col-3">
                    <h2>Contact</h2>
                    <p id="contact"> Phone: 031-560061 <br>gadgetsbazar@gmail.com<br>Imadol-4, Lalitpur</p>
                </div>
        </div>
                <!--Copyright section-->
            <div class="copyright">
                <hr>
                <h3>Copyright &copy; www.GadgetsBazzar.com. All rights reserved </h3>
            </div>
    </section>


</body>

</html>