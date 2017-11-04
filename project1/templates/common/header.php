<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Getting Shit Done App</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body>


    <div class="navbar" >
        <img width="7%" class="nav-logo img-responsive" src="assets/img/sample-logo.png" />
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/lists">Lists</a></li>
            <li><a href="/projects">Projects</a></li>
            <li><a href="/cenas">Cenas</a></li>
            <ul>

                <div class="nav-right">
                    <ul>
                        <?php if (isset($_SESSION['username']) && $_SESSION['username'] != '') { ?>
                            <li><a href="myprofile.php"><?=$_SESSION['username']?></a></li>
                            <li><a href="action_logout.php">Logout</a></li>
                        <?php } else { ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        <?php } ?>
                    </div>

                </div>
