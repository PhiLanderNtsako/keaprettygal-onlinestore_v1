<?php
	session_start();
    include 'admin/inc/dbConfig.php';
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

      $product_category = $_GET['category'];
      $product_type = $_GET['type'];

      $sel_product = "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_id WHERE product.product_category = '$product_category'  && product.product_type = '$product_type' ORDER BY product.product_id ASC";
      $query_product = mysqli_query($conn, $sel_product);
      $row = mysqli_fetch_assoc($query_product);
    ?>
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong> / <strong class="text-black"><?php echo $product_type?></strong> / <strong class="text-black"><?php echo $product_category?></strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row mb-5">
              <?php
                $sel_product = "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_id WHERE product.product_category = '$product_category'  && product.product_type = '$product_type' ORDER BY product.product_id ASC";
                $query_product = mysqli_query($conn, $sel_product);

                while($row = mysqli_fetch_array($query_product)){
              ?>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href="shop-single.php?id=<?php echo $row['product_name_slug'] ?>"><img src="images/product_images/<?php echo $row['product_image'] ?>" alt="Image placeholder" class="img-fluid"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="shop-single.php?id=<?php echo $row['product_name_slug'] ?>"><?php echo $row['product_name'] ?></a></h3>
                    <p class="mb-0"><?php echo $product_type.' - '.$product_category?></p>
                    <p class="text-primary font-weight-bold">R<?php echo $row['product_price'] ?></p>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="row" data-aos="fade-up">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <button class="btn btn-outline-primary btn-sm btn-block" disabled>Loading More...</button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block"><?php echo $product_category?></h3>
              <ul class="list-unstyled mb-0">
                <?php
                  $sel_product = "SELECT `product_category` FROM `product` WHERE `product_type` = '$product_type'";
                  $query_product = mysqli_query($conn, $sel_product);

                  while($row2 = mysqli_fetch_array($query_product)){
                ?>
                <li class="mb-1"><a href="shop.php?type=cosmetics&category=wash" class="d-flex"><span><?php echo $row2['product_category'] ?></span></a></li>
              <?php } ?>
              </ul>
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
