<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber-On-Go</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown:hover .dropdown-content {
    display: block;
}

    </style>

</head>

<body>
    <header class="header">
        <div class="container container-nav">
            <div class="site-title">
                <h1>Barber-On-Go</h1>
                <p class="" subtitle">Getting your hair ready</p>
            </div>
            <nav id="navbar">
                <ul>
                    <li><a href="user-index.php">Home</a></li>
                    <li><a href="user-about.php">About</a></li>
                    <li><a href="user-faq.php">FAQ</a></li>
                    <li class="dropdown">
                    <a href="" class="dropbtn">Barbers</a>
                    <div class="dropdown-content">
                        <a href="user-booking-add.php">List of Barber</a>
                    </div>
                    </li>
                    <li class="dropdown">
                    <a href="user-booking.php" class="dropbtn">My Appointment</a>
                    <div class="dropdown-content">
                        <a href="user-booking-history.php">Appointment History</a>
                    </div>
                    </li>
                    <li class="dropdown">
                    <a href="user-profile2.php" class="dropbtn">My Profile</a>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>