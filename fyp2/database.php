<?PHP
	date_default_timezone_set('Asia/Kuala_Lumpur');
	

	//localhost
	$dbHost = "localhost";	// Database host
	$dbName = "barber2";		// Database name
	$dbUser = "root";		// Database user
	$dbPass = "";			// Database password

	
	$con = mysqli_connect($dbHost,$dbUser ,$dbPass,$dbName);
	
	
	function verifyAdmin($con)
	{
		if ($_SESSION['username'] && $_SESSION['password'] ) 
		{
		  $result=mysqli_query($con,"SELECT  `username`, `password` FROM `admin` WHERE `username`='$_SESSION[username]' AND `password`='$_SESSION[password]' " ) ;

          if( mysqli_num_rows( $result ) == 1 ) 
	  	  return true;
		}
		return false;
	}
	
	function verifyCustomer($con)
	{
		if ($_SESSION['username'] && $_SESSION['username'] ) 
		{
		  $result=mysqli_query($con,"SELECT  `username`, `password` FROM `customer` WHERE `username`='$_SESSION[username]' AND `password`='$_SESSION[password]' " ) ;

          if( mysqli_num_rows( $result ) == 1 ) 
	  	  return true;
		}
		return false;
	}
	
	function verifyBarber($con)
	{
		if ($_SESSION['username'] && $_SESSION['username'] ) 
		{
		  $result=mysqli_query($con,"SELECT  `username`, `password` FROM `barber` WHERE `username`='$_SESSION[username]' AND `password`='$_SESSION[password]' " ) ;

          if( mysqli_num_rows( $result ) == 1 ) 
	  	  return true;
		}
		return false;
	}

	function numRows($con, $query) {
        $result  = mysqli_query($con, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
	
	function Notify($status, $alert, $redirect)
	{
		$color = ($status == "success") ? "w3-green" : "w3-red";

		echo '<div class="'.$color.' w3-top w3-card w3-padding-24" style="z-index=999">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-button w3-large w3-display-topright">&times;</span>
				<div class="w3-padding w3-center">
				<div class="w3-large">'.$alert.'</div>
				</div>
			</div>';
		//header( "refresh:1;url=$redirect" );
		print "<script>self.location='$redirect';</script>";
	}
	
	function resizeImage($resourceType,$image_width,$image_height) {
		$resizeWidth 	= 300;
		$resizeHeight 	= 300;
		$imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
		imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
		return $imageLayer;
	}
	
	function GetCustomerName($con, $id_customer)
	{
		$sql = " SELECT `name` FROM `customer` WHERE `id_customer` = '$id_customer'  ";
		$rst = mysqli_query($con, $sql) ;		

		if(mysqli_num_rows($rst)) {
			$data = mysqli_fetch_array($rst);
			return $data["name"];
		} else {
			return "-";
		}
	}
	
	function GetBarberName($con, $id_barber)
	{
		$sql = " SELECT `name` FROM `barber` WHERE `id_barber` = '$id_barber'  ";
		$rst = mysqli_query($con, $sql) ;		

		if(mysqli_num_rows($rst)) {
			$data = mysqli_fetch_array($rst);
			return $data["name"];
		} else {
			return "-";
		}
	}
?>