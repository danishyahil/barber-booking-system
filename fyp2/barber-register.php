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
$services 		= (isset($_POST['services'])) ? trim($_POST['services']) : '';

$name	=	mysqli_real_escape_string($con, $name);

$found = 0;
$error = "";
$success = false;

if($act == "register")
{
	$found 	= numRows($con, "SELECT * FROM `barber` WHERE `username` = '$username' ");
	if($found) $error ="Username already registered";
}

if(($act == "register") && (!$error))
{	
	$SQL_insert = " 
	INSERT INTO `barber`(`id_barber`, `username`, `password`, `name`, `email`, `phone`, `address`, `gmap`, `services`, `status`, `verified`, `created_date`) VALUES (NULL, '$username', '$password', '$name', '$email', '$phone', '$address', '$gmap','$services', 0, 0, NOW() )
	";
	
	$id_barber = mysqli_insert_id($con);
	
	// -------- Photo  -----------------
	if(isset($_FILES['photo'])){
		 
		if($_FILES["photo"]["error"] == 4) {
				//means there is no file uploaded
		} else {

			$file_name = $_FILES['photo']['name'];
			$file_size = $_FILES['photo']['size'];
			$file_tmp = $_FILES['photo']['tmp_name'];
			$file_type = $_FILES['photo']['type'];
			
			$fileNameCmps = explode(".", $file_name);
			$file_ext = strtolower(end($fileNameCmps));

			$extensions= array("jpeg","jpg","png","gif");

			if(in_array($file_ext,$extensions)=== false){
				$errors="extension not allowed, please choose a JPEG, JPG, PNG or GIF file.";
			}

			if($file_size > 12097152) {
				$errors='File size must be smaller than 12 MB';
			}

			if(empty($errors)==true) {

				// image resize bfore uploaded
				$fileName = $_FILES['photo']['tmp_name']; 
				$sourceProperties = getimagesize($fileName);
				$resizeFileName = $id_barber;
				$uploadPath = "photo/";
				$fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
				$uploadImageType = $sourceProperties[2];
				$sourceImageWidth = $sourceProperties[0];
				$sourceImageHeight = $sourceProperties[1];
				switch ($uploadImageType) {
					case IMAGETYPE_JPEG:
						$resourceType = imagecreatefromjpeg($fileName); 
						$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
						imagejpeg($imageLayer,$uploadPath. $resizeFileName.'.'. $fileExt);
						break;

					case IMAGETYPE_GIF:
						$resourceType = imagecreatefromgif($fileName); 
						$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
						imagegif($imageLayer,$uploadPath. $resizeFileName.'.'. $fileExt);
						break;

					case IMAGETYPE_PNG:
						$resourceType = imagecreatefrompng($fileName); 
						$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
						imagepng($imageLayer,$uploadPath. $resizeFileName.'.'. $fileExt);
						break;

					default:
						break;
				}
				// image resize bfore uploaded
				
				$finalFileName = $resizeFileName.'.'. $fileExt;
				
				$query = "UPDATE `barber` SET `photo`='$finalFileName' WHERE `id_barber` = '$id_barber'";			
				$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
			}else{
				print_r($errors);
			}  
		}
	}
	// -------- End Photo -----------------

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
  <p>Your registration was successful! You may now <a href="barber-login.php" class="w3-xlarge">Login.</a> </p>
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
		
			<form action="" method="post" enctype = "multipart/form-data" >
			<h3>Registration (Barber)</h3>	

				
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
				<label>Services & Price </label>
				<textarea class="w3-input w3-border w3-round" name="services" required></textarea>
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
			<div class="w3-center">Already registered? <a href="barber-login.php" class="w3-text-blue">Login here</a></div>
		</div>
    </div>
</div>


<div class="w3-padding-24"></div>
	
</div>
<?php include("footer.php"); ?>
</body>
</html>
