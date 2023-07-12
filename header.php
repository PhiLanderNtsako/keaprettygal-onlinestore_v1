<header class="site-navbar" role="banner">
  <div class="site-navbar-top">
    <div class="container">
      <div class="row align-items-center">

        <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
          <form action="" class="site-block-top-search">
            <span class="icon icon-search2"></span>
            <input type="text" class="form-control border-0" placeholder="Search">
          </form>
        </div>

        <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
          <div class="site-logo">
            <a href="index.php" class="js-logo-clone"><img src="images/logo3.png" alt="" height="90px"></a>
          </div>
        </div>

        <div class="col-6 col-md-4 order-3 order-md-3 text-right">
          <div class="site-top-icons">
            <ul>
              <li>
                <a href="cart.php" class="site-cart">
                  <span class="icon icon-shopping_cart"></span>
                  <?php
                    if(!empty($_SESSION["cart"])) {
                      $cart_count = count(array_keys($_SESSION["cart"]));
                        echo '<span class="count">'.$cart_count.'</span>';
                    }
                  ?>
                </a>
              </li>
              <li><a href="#"><span class="icon icon-person"></span></a></li>
              <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
              <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
  <nav class="site-navigation text-right text-md-center" role="navigation">
    <div class="container">
      <ul class="site-menu js-clone-nav d-none d-md-block">
        <li><a href="index.php">Home</a></li>
        <li class="has-children">
          <a href="#" data-toggle="collapse" data-target="#collapseItem0">Shop Underwears</a>
          <ul class="dropdown">
            <li><a href="shop.php?type=underwear&category=prettyboi">Prettyboi</a></li>
            <li><a href="shop.php?type=underwear&category=prettygal">Prettygal</a></li>
          </ul>
        </li>
        <li class="has-children">
          <a href="#" data-toggle="collapse" data-target="#collapseItem1">Shop Cosmetics</a>
          <ul class="dropdown">
            <li><a href="shop.php?type=cosmetics&category=lotion">Lotion</a></li>
            <li><a href="shop.php?type=cosmetics&category=wash">Wash</a></li>
            <li><a href="shop.php?type=cosmetics&category=perfume">Perfume</a></li>
            <li><a href="shop.php?type=cosmetics&category=accessories">Others</a></li>
          </ul>
        </li>
        <li><a href="about-us.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </nav>
</header>
