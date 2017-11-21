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
                        <li><a href="actions/action_logout.php">Logout</a></li>
                        <?php } else { ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                        <?php } ?>
                    </div>

                </div>
