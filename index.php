<?php 
session_start();

$_SESSION['cart'] = $_SESSION['cart'] ?? [];
require "./db/utils.php";

$products = get_products();

if (isset($_POST["add"])) {
   $cart_element =& $_SESSION['cart'][$_POST['product_key']];
   if (!isset($cart_element)) {
     $cart_element = 0;
   }
   $cart_element++;
   $_SESSION['success'] = "Element <b>" . $products[$_POST['product_key']]['name'] . "</b> added to your cart";
}
 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Shopping Cart</title>
  </head>
  <body style="background-color: #00bfff">
    <div class="container text-center">
      <h1 class="my-3">Shopping cart Application</h1>
      <div class="accordion" id="accordionExample">
        <div class="row justify-content-center">
          <div class="col-6">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"> 
                  <?php   echo $_SESSION['success'] ?>
                <?php unset($_SESSION['success']) ?>
                </div> 
            <?php endif ?>
        <div class="accordion-item">
         <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Shopping cart <?php echo count($_SESSION['cart']); ?>
            </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                 <h5>Shopping cart elements</h5>
                      <ul class="list-group list-group-flush">
                        <?php foreach ($_SESSION['cart'] as $key => $amount): ?>
                           <li class="list-group-item">
                            Product name:<strong> <?php echo $products[$key]['name'] . "</strong> |  amount:<strong> " . $amount . "</strong>"; ?>
                        <?php endforeach ?>
                        </li>
                    </ul>
                    <a href="details.php" class="btn btn-success rounded-pill my-3">More details</a>               
                </div>
             </div>
          </div>
        </div>
      </div>
    </div>

      <div class="row justify-content-center">
        <?php foreach ($products as $key => $product): ?>
          <div class="col-3 my-3">
          <div class="card">
            <img src="<?php echo $product['image_path'] ?>" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product['name'] . " " . "| " . $product['currency'] . $product['price'] ?></h5>
               <form method="post" action="">
                <input type="hidden" name="product_key" value="<?php echo $key ?>">
              <button class="btn btn-primary my-4 rounded-pill" name="add" type="submit">Add to cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>