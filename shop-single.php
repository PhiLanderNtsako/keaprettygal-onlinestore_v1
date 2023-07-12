<?php
    session_start();
    include 'admin/inc/dbConfig.php';
    $product_name_slug = $_GET['id'];
    $status = "";

	// unset($_SESSION['cart']);

    if (isset($_POST['submit'])) {

        $product_id = $_POST['product_id'];

        $query_product = mysqli_query($conn, "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_id AND product.product_id = '$product_id'");
        $row = mysqli_fetch_assoc($query_product);


        $product_image = $row['product_image'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_size = $_POST['product_size'];
        $product_quantity = $_POST['product_quantity'];
        $code = $product_id.'-'.$product_size;

        $cartArray = array(
            $code => array(
            'code' => $code,
            'product_id' => $product_id,
            'product_image' => $product_image,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_size' => $product_size,
            'product_quantity' =>$product_quantity
            )
        );

        if(empty($_SESSION['cart'])) {

            $_SESSION['cart'] = $cartArray;
            $status = "Product is added to your cart!";
            if($product_size == 'no_size'){
              echo '<meta http-equiv="refresh" content="0; url= cart.php">';
            }
        }else {

            $array_keys = array_keys($_SESSION['cart']);
            if(in_array($code,$array_keys)) {

                $status = "Product is already added to your cart!";
            } else {

                $_SESSION['cart'] = array_merge_recursive($_SESSION['cart'],$cartArray);
                $status = "Product is added to your cart!";
                if($product_size == 'no_size'){
                  echo '<meta http-equiv="refresh" content="0; url= cart.php">';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>

  <div class="site-wrap">
    <?php
      include 'header.php';

      if (isset($_POST['submit'])) {
          echo'
          <div class="alert alert-success alert-dismissible text-center">
              <strong> '.$status.'</strong>
          </div>';
      }
      $sel_product = "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_id WHERE product_name_slug = '$product_name_slug' LIMIT 1";
      $query_product = mysqli_query($conn, $sel_product);
      $row = mysqli_fetch_array($query_product);
      ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo $row['product_name'] ?></strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="images/product_images/<?php echo $row['product_image'] ?>" alt="Image" class="img-fluid">
          </div>
          <div class="col-md-6">
            <h2 class="text-black"><?php echo $row['product_name'] ?></h2>
            <p><strong class="text-primary h4">R<?php echo $row['product_price'] ?></strong></p>
            <p><?php echo $row['product_description'] ?></p>
            <?php
              if($row['active_yn']){
                if(
                  $row['size_XS_quantity'] == 0 &
                  $row['size_S_quantity'] == 0 &
                  $row['size_M_quantity'] == 0 &
                  $row['size_L_quantity'] == 0 &
                  $row['size_XL_quantity'] == 0 &
                  $row['size_XXL_quantity'] == 0 &
                  $row['no_size'] == 0
                ){
            ?>
            <p><a href="cart.php" class="buy-now btn btn-sm btn-primary">OUT OF STOCK</a></p>
            <?php } ?>
            <form method="post" action="" id="cart-form">
              <?php
                if($row['no_size'] > 0){
              ?>
              <div class="mb-5">
                <h5>Quantity</h5>
                <div class="input-group mb-3" style="max-width: 120px;">
                  <input type="hidden" name="product_size" value="no_size">
                  <select class="form-control" name="product_quantity" onchange="this.form.submit();">
                    <option value="1">1</option>
                    <?php
                      $size = $row['no_size'];
                      for($x = 1; $x <= $size; $x++){
                        echo '<option value="'.$x.'">'.$x.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <?php
              }else{
              ?>
              <h5>Size</h5>
              <div class="mb-1 d-flex">
                <label for="option-xs" class="d-flex mr-3 mb-3">
                  <?php
                  if($row['size_XS_quantity'] > 0){
                    echo '
                      <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xs" name="product_size" value="size_XS_quantity" required></span> <span class="d-inline-block text-black">X Small</span>
                      ';
                  }
                  ?>
                </label>
                <label for="option-s" class="d-flex mr-3 mb-3">
                  <?php
                  if($row['size_S_quantity'] > 0){
                    echo '
                      <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-s" name="product_size" value="size_S_quantity" required></span> <span class="d-inline-block text-black">Small</span>
                      ';
                  }
                  ?>
                </label>
                <label for="option-md" class="d-flex mr-3 mb-3">
                  <?php
                  if($row['size_M_quantity'] > 0){
                    echo '
                      <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-md" name="product_size" value="size_M_quantity" required></span> <span class="d-inline-block text-black">Medium</span>
                      ';
                  }
                  ?>
                </label>
                <label for="option-lg" class="d-flex mr-3 mb-3">
                  <?php
                  if($row['size_L_quantity'] > 0){
                    echo '
                      <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-lg" name="product_size" value="size_L_quantity" required></span> <span class="d-inline-block text-black">Large</span>
                      ';
                  }
                  ?>
                </label>
                <label for="option-xlg" class="d-flex mr-3 mb-3">
                  <?php
                  if($row['size_XL_quantity'] > 0){
                    echo '
                      <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xlg" name="product_size" value="size_XL_quantity" required></span> <span class="d-inline-block text-black">X Large</span>
                      ';
                  }
                  ?>
                </label>
              </div>
              <div class="mb-5">
                <h5>Quantity</h5>
                <div class="input-group mb-3" style="max-width: 120px;">
                  <select class="form-control" name="product_quantity" onchange="this.form.submit();">
                    <option value="1">1</option>
                    <?php
                      for($x = 1; $x <= 1; $x++){
                        echo '<option value="'.$x.'">'.$x.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
              <p><button type="submit" name="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button></p>
            </form>
            <?php
              }else{
            ?>
            <p><a href="#" class="buy-now btn btn-sm btn-primary">OUT OF STOCK</a></p>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>New Arrivals</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/product_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="shop-single.php">Tank Top</a></h3>
                    <p class="mb-0">Finding perfect t-shirt</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/product_5.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/product_12.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Polo Shirt</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/product_13.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">T-Shirt Mockup</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/product_10.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include 'footer.php'; ?>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

  </body>
</html>
