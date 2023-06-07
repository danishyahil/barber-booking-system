<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber-On-Go</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include("navbar.php"); ?>
    <main class="contact">
        <h1>Contact Us</h1>
        <div class="flex-container">
            <div class="flex-item-left">
                <h4>We are located at</h4>
                <p>ONE Shamelin</p>
                <p>Ampang, Selangor</p>
                <h4>Phone</h4>
                <p>012-3456789</p>
                <h4>Email</h4>
                <p>info@danish.com</p>
            </div>
            <div class="flex-item-right">
                <form action="">
                    <input type="text" id="fname" placeholder="Your Name">
                    <input type="text" name="subject" id="subject" placeholder="Subject">
                    <textarea name="" id="textarea" cols="30" rows="10"></textarea>
                    <button type="button">Send Message</button>
                </form>
            </div>
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>

</html>