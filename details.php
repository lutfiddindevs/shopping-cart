<?php 

session_start();
require "db/utils.php";
$_SESSION['cart'] = $_SESSION['cart'] ?? []; 
$products = get_products();
require "sending_tg_msg.php";

if (isset($_POST['remove'])) {
	unset($_SESSION['cart'][$_POST['remove']]);
}

if (isset($_POST['checkOut'])) {

	for ($i=0; $i < count($_SESSION['cart']); $i++) { 
		$_SESSION['cart'][$i] = $_POST[$i];
	}
    
    $email = $_POST['email'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $street = $_POST['street'] ?? '';
    $apartment = $_POST['apartment'] ?? '';
    $city = $_POST['city'] ?? '';
    $country = $_POST['country'] ?? '';
    $zip = $_POST['zip'] ?? '';

    $address = "Address: <b><i>$zip, $city, $country, $street, $apartment</i></b>" . PHP_EOL;
    $order_section = "<b>Order details:</b>";
    $client_details = "<b>Client:</b>" . PHP_EOL;
    $client_details .= "Email:  <i>$email</i>" . PHP_EOL;
    $client_details .= "Phone Number:   <i>$phoneNumber</i>" . PHP_EOL;
    $total = "<b>Total:</b>";

    
    $msg = '<b>Checkout:</b>' . PHP_EOL . $client_details . $address . PHP_EOL . $order_section .  PHP_EOL;

    foreach ($_SESSION['cart'] as $key => $amount) {
    	$product = $products[$key];
    	$msg .= ++$key . '. ' . $product['name'] . '     ' .  $product['currency'] . $product['price'] .  ' x '  .  $amount . " = " . "$" . $product['price'] * $amount . PHP_EOL;
    	
    }
	send_tg_msg($msg);
	unset($_SESSION['cart']);
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

    
  </head>
  <body  style="background-color: #00bfff">
		  	<div class="container">
		  		<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                 <form  method="post">
		  		<div class="row justify-content-center my-5">
		  			<?php foreach ($_SESSION['cart'] as $product_key => $amount): ?>
		  			<?php $product = $products[$product_key]; ?>
		  			 <div class="col-4">
		  				<div class="card mb-3">
					      <div class="row g-0">
					          <div class="col-md-4">
					           <img src="<?php echo $product['image_path'] ?>" alt="<?php echo $product['name'] ?>" class="img-fluid">
					          </div>
					            <div class="col-md-8">
					              <div class="card-body">
					              	<div class="row">
					              	<div class="col-6">
					              		<h5 class="card-title"><?php echo $product['name'] ?></h5>
					              	</div>
					              	<div class="col-6">
					              		<button class="btn btn-danger rounded-pill" type="submit" name="remove" value="<?php echo $product_key ?>">Remove</button>
					              	</div>
					                </div>
					                <p class="card-text"><small class="text-muted"><?php echo $product['currency'] . $product['price'] ?></small></p>
					                <input class="form-control" type="number" placeholder="amount" value="<?php echo $amount ?>" name="<?php echo $product_key ?>">
					              </div>
					            </div>
					            <div class="card-footer">
					            	Total: <strong><?php echo $product['currency'] .  $amount * $product['price']  ?></strong>
					            </div>
					        </div>
					    </div>
					</div>
				 <?php endforeach; ?>
		  	 </div>
		  	 <div class="row my-3">
		  	 	<div class="card">
		  	 		<div class="card-body">
		  	 		<div class="card-title text-center display-4">Checkout</div>
		  	 		<div class="row g-3 my-5 mx-4">
		  	 		<div class="col-md-6">
					    <label for="inputEmail4" class="form-label">Email</label>
					    <input type="email" name="email" class="form-control <?php isset($errors['email']) ? 'is-invalid' : '' ?>" id="inputEmail4">
					    <div class="invalid-feedback">
                            <?php echo $errors['email'] ?? '' ?>
                        </div>
					  </div>
					  <div class="col-md-6">
					    <label for="phoneNumber" class="form-label">Phone number</label>
					    <input type="tel" name="phoneNumber" placeholder="+998 9* *** ** **" class="form-control <?php isset($errors['phoneNumber']) ? 'is-invalid' : '' ?>"  id="phoneNumber">
					    <div class="invalid-feedback">
                            <?php echo $errors['phoneNumber'] ?? '' ?>
                        </div>
					  </div>
					  <div class="col-12">
					    <label for="inputAddress" class="form-label">Address</label>
					    <input type="text" name="street" class="form-control <?php isset($errors['address']) ? 'is-invalid' : '' ?>" id="inputAddress" placeholder="1234 Main St">
					    <div class="invalid-feedback">
                            <?php echo $errors['address'] ?? '' ?>
                        </div>
					  </div>
					  <div class="col-12">
					    <label for="inputAddress2" class="form-label">Address 2</label>
					    <input type="text" name="apartment" class="form-control <?php isset($errors['address2']) ? 'is-invalid' : '' ?>" id="inputAddress2" placeholder="Apartment, studio, or floor">
					    <div class="invalid-feedback">
                            <?php echo $errors['address2'] ?? '' ?>
                        </div>
					  </div>
					  <div class="col-md-6">
					    <label for="inputCity" class="form-label">City</label>
					    <input type="text" name="city" class="form-control <?php isset($errors['city']) ? 'is-invalid' : '' ?>" id="inputCity">
					    <div class="invalid-feedback">
                            <?php echo $errors['city'] ?? '' ?>
                        </div>
					  </div>
					  <div class="col-md-4">
					    <label for="inputState" class="form-label">State</label>
					    <select id="inputState" class="form-select" name="country">
					      <option selected>Choose...</option>
					      <option value="Uzbekistan">Uzbekistan</option>
					    </select>
					  </div>
					  <div class="col-md-2">
					    <label for="inputZip" class="form-label">Zip</label>
					    <input type="text" name="zip" class="form-control" id="inputZip">
					  </div>
					  <div class="col-12">
					    <button type="submit" name="checkOut" class="btn btn-primary my-3 rounded-pill">Send</button>
					  </div>
					  </div>
					</div>
		  	 	</div>
		  	 </div>
		  	 <?php else: ?>
		  	 	<div class="text-center my-5 mx-5">
		  	 		<h1><a href="index.php">Go to homepage to make an order</a></h1>
		  	 	</div>
		  	 	</form>
		  	 <?php endif ?>
		  	</div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
