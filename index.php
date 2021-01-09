<?php 
require "./db/utils.php";

$products = get_products();

if (isset($_POST["add"])) {
   echo "Added product to cart with index=".$_POST['product_key']. "to cart";
   echo "Cart producy name is " . $products[$_POST['product_key']]['name'];
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