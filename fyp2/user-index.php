<?php include("user-navbar.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber-On-Go</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #home {
            background: url('img/banner.jpg') no-repeat center center fixed;
            height:85vh;
            position: relative;
            width: 100%;
            background-size: cover;
        }
    </style>
</head>

<body>
<main>
    <div id="home">
        <div class="overlay">
            <div class="landing-text">
                <h3>Discover a new you with our help!</h3>
                <h1>Barber-On-Go</h1>
                <hr id="hr-main">
            </div>
        </div>
    </div>
</main><br>

<main class="team">
    <div class="team-container" id="team">
        <div class="team-header">
            <h1>Famous Barber Around You</h1>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img src="img/18.jpg" alt="" style="width: 100%">
            <h3>Joe's Barbershop Cheras</h3>
            <p><a href="user-booking-add.php" class="button btn-hire">View More</a></p>
        </div>
        <div class="column">
            <img src="img/19.jpg" alt="" style="width: 100%">
            <h3>Nimroc Barbershop Maluri</h3>
            <p><a href="user-booking-add.php" class="button btn-hire">View More</a></p>
        </div>
        <div class="column">
            <img src="img/20.jpg" alt="" style="width: 100%">
            <h3>Prime Barbershop Cheras</h3>
            <p><a href="user-booking-add.php" class="button btn-hire">View More</a></p>
        </div>
        <div class="column">
            <img src="img/21.jpg" alt="" style="width: 100%">
            <h3>Jadioc Barbershop Cheras</h3>
            <p><a href="user-booking-add.php" class="button btn-hire">View More</a></p>
        </div>
    </div>
</main><br>

<main>
    <div class="gallery-header" id="gallery">
        <h1>Some of most awesome haircuts to try!</h1>
        <p>Book your session now with us</p>
    </div>
    <div class="row gallery-row">
        <div class="column">
            <img src="img/1.jpg" alt="" style="width: 100%">
            <img src="img/2.jpg" alt="" style="width: 100%">
            <img src="img/3.jpg" alt="" style="width: 100%">
            <img src="img/4.jpg" alt="" style="width: 100%">
        </div>
        <div class="column">
            <img src="img/5.jpg" alt="" style="width: 100%">
            <img src="img/6.jpg" alt="" style="width: 100%">
            <img src="img/7.jpg" alt="" style="width: 100%">
            <img src="img/8.jpg" alt="" style="width: 100%">
        </div>
        <div class="column">
            <img src="img/9.jpg" alt="" style="width: 100%">
            <img src="img/10.jpg" alt="" style="width: 100%">
            <img src="img/11.jpg" alt="" style="width: 100%">
            <img src="img/12.jpg" alt="" style="width: 100%">
        </div>
        <div class="column">
            <img src="img/13.jpg" alt="" style="width: 100%">
            <img src="img/14.jpg" alt="" style="width: 100%">
            <img src="img/15.jpg" alt="" style="width: 100%">
            <img src="img/16.jpg" alt="" style="width: 100%">
        </div>
    </div>
</main><br>

<?php include("footer.php"); ?>
</body>

</html>