<?php
    session_start();
    include 'admin/inc/dbConfig.php';
	// unset($_SESSION['order']);

  // session_destroy();

    // $_SESSION['rdurl'] = $_SERVER['REQUEST_URI'];
    $status = "";

	if(isset($_POST['delivery_method'])){
		$_SESSION['delivery_method'] = $_POST['delivery_method'];
	}

    if (isset($_POST['action']) && $_POST['action'] == "clear") {
        $status = "Your Cart Is Cleared";
        unset($_SESSION['cart']);
        unset($_SESSION['order']);
    }
    if (isset($_POST['action']) && $_POST['action'] == "remove" && $_POST['product_selected'] = '1') {

        if (!empty($_SESSION['cart'])) {

            foreach ($_SESSION['cart'] as $key => $value) {

                if ($_POST['code'] == $key) {

                    unset($_SESSION['cart'][$key]);
                    $status = "Product Removed From Your Cart";
                }
                if (empty($_SESSION['cart'])) {
                    unset($_SESSION['cart']);
                    unset($_SESSION['order']);
                }
            }
        }
    }
    if (isset($_POST['action']) && $_POST['action']=="change") {

	    foreach($_SESSION["cart"] as &$value) {

		    if($value['code'] === $_POST["code"]) {

		        $value['product_quantity'] = $_POST["product_quantity"];
				$status = "Cart Updated";
		        break; // Stop the loop after we've found the product
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
      if(!isset($_SESSION["cart"])) {
    ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>
    <?php
      }else{
    ?>
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>
    <?php
      $total_price = 0;
      if (isset($_POST['action']) && $_POST['action']=="change") {
        echo'
           <div class="alert alert-success alert-dismissible text-center">
            <strong> '.$status.'</strong>
          </div>';
      }
    ?>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
      							foreach ($_SESSION["cart"] as $product) {

      								$product_id = $product['product_id'];
      								$product_size = $product['product_size'];

      								switch($product_size){

      									case 'size_XS_quantity':
      									$product_size_name = 'Extra Small (XS)';
      									break;
      									case 'size_S_quantity':
      									$product_size_name = 'Small (S)';
      									break;
      									case 'size_M_quantity':
      									$product_size_name = 'Medium (M)';
      									break;
      									case 'size_L_quantity':
      									$product_size_name = 'Large (L)';
      									break;
      									case 'size_XL_quantity':
      									$product_size_name = 'XL (Extra Large)';
      									break;
      									case 'size_XXL_quantity':
      									$product_size_name = 'XXL (Extra Extra Large)';
      									break;
      									case 'size_fit_all':
      										$product_size_name = 'One Size';
      										break;
      								}

      								$query_product = mysqli_query($conn, "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_id AND product.product_id = '$product_id'");
      								$row = mysqli_fetch_assoc($query_product);
      						?>
                  <tr>
                    <td class="product-thumbnail">
                      <img src="images/product_images/<?php echo $product["product_image"] ?>" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                      <h2 class="h5 text-black">
                        <?php echo $product["product_name"] ?><br />
                        <?php
                          if(!isset($row['no_size'])){
                            echo '<small>Size:'.$product_size_name.'</small>';
                          }
                        ?>
                      </h2>
                    </td>
                    <td>R<?php echo $product["product_price"] ?></td>
                    <td>
                      <div class="input-group mb-3" style="max-width: 120px;">
                        <form method='post' action=''>
                          <input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
  												<input type='hidden' name='action' value="change" />
                          <select class="form-control" name="product_quantity" onchange="this.form.submit();">
                            <option value="<?php echo $product["product_quantity"] ?>"><?php echo $product["product_quantity"] ?></option>
  													<?php
  														$size = $row[$product_size];
  														for($x = 1; $x <= $size; $x++){
  															echo '<option value="'.$x.'">'.$x.'</option>';
  														}
  													?>
                          </select>
                        </form>
                      </div>

                    </td>
                    <td>
                      R<?php
  											$total = $product["product_price"]*$product["product_quantity"];
  											echo number_format($total, 2, '.', ' ');
  										?>
                    </td>
                    <td>
                      <form method='post' action='' id='clear-form'>
    										<input type='hidden' name='action' value="clear">
    										<a class="btn btn-primary btn-sm" href="javascript:;" onclick="document.getElementById('clear-form').submit();">X</a>
    									</form>
                    </td>
                  </tr>
                  <?php
    								$total_price += $total;
    								}
    							?>
                </tbody>
              </table>
            </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button class="btn btn-primary btn-sm btn-block">Update Cart</button>
              </div>
              <div class="col-md-6">
                <button class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-sm">Apply Coupon</button>
              </div>
            </div> -->
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <span class="text-black">Subtotal</span>
                      </div>
                      <div class="col-md-6 text-right">
                        <strong class="text-black">R<?php echo number_format($total_price, 2, '.', ' '); ?></strong>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout-library/checkout.php'">Proceed To Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      }
      include 'footer.php';
    ?>
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
