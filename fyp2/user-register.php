<?PHP

include("database.php");
$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';
$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$name 		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$address 	= (isset($_POST['address'])) ? trim($_POST['address']) : '';
$gmap 		= (isset($_POST['gmap'])) ? trim($_POST['gmap']) : '';

$name	=	mysqli_real_escape_string($con, $name);

$found = 0;
$error = "";
$success = false;

if($act == "register")
{
	$found 	= numRows($con, "SELECT * FROM `customer` WHERE `username` = '$username' ");
	if($found) $error ="Username already registered";
}

if(($act == "register") && (!$error))
{	
	$SQL_insert = " 
	INSERT INTO `customer`(`id_customer`, `username`, `password`, `name`, `email`, `phone`, `address`, `gmap`, `created_date`) VALUES (NULL, '$username', '$password', '$name', '$email', '$phone', '$address', '$gmap', NOW() )
	
	";	

	$result = mysqli_query($con, $SQL_insert) or die("Error in query: ".$SQL_insert."<br />".mysqli_error($con));
	$success = true;
}
?>
<!DOCTYPE html>
<html>
<title>Barber-On-Go</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-image: url(images/banner.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body>

<?PHP include("navbar.php"); ?>


<div class="bgimg-1" >

	<div class="w3-padding-24"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
		<div class="w3-padding">

<?PHP if($success) { ?>
<div class="w3-panel w3-green w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Success!</h3>
  <p>Your registration was successful! You may now <a href="user-login.php" class="w3-xlarge">Login.</a> </p>
</div>
<?PHP  } ?>

<?PHP if($error) { ?>
<div class="w3-panel w3-red w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Error!</h3>
  <p><?PHP echo $error;?></p>
</div>
<?PHP  } ?>

<?PHP if(!$success) { ?>	
		
			<form action="" method="post">
			<h3>Registration (Customer)</h3>
			
			  <div class="w3-section" >
				<label>Full Name *</label>
				<input class="w3-input w3-border w3-round" type="text" name="name"  required>
			  </div>
			  
			  <div class="w3-section">
				<label>Email *</label>
				<input class="w3-input w3-border w3-round" type="email" name="email" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Mobile Phone *</label>
				<input class="w3-input w3-border w3-round" type="text" name="phone" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Address *</label>
				<textarea class="w3-input w3-border w3-round" name="address" required></textarea>
			  </div>
			  
			  <div class="w3-section">
				<label>Google Map Url </label>
				<input class="w3-input w3-border w3-round" type="text" name="gmap">
			  </div>
			  
			  <div class="w3-section">
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="text" name="username" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Password *</label>
				<input class="w3-input w3-border w3-round" type="password" name="password" required>
			  </div>
			  
			  <input type="hidden" name="act" value="register">
			  <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom w3-round">SUBMIT</button>
			</form>
			
<?PHP } ?>
			<div class="w3-center">Already registered? <a href="user-login.php" class="w3-text-blue">Login here</a></div>
		</div>
    </div>
</div>


<div class="w3-padding-24"></div>
	
</div>
<?php include("footer.php"); ?>

</body>
</html>
