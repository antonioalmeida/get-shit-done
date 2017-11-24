</head>

<body>
    <div class="content">
        <div class="navbar" >
            <div class="container-large">
                <ul>
                    <li><a href="mylists.php">Logo</a></li>
                </ul>

                <div class="nav-right">
                    <ul>
                        <?php if (isset($_SESSION['username']) && $_SESSION['username'] != '') { ?>

                        <li><a href="myprofile.php"><i class="fa fa-user"></i></a></li>
                        <li><a href="#"><i class="fa fa-cog"></i></a></li>
                        <?php } else { ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
