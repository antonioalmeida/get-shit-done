</head>

<body>
<div class="content">
    <div class="navbar">
        <div class="container-large">
            <ul>
                <li><a href="mylists.php"><i class="fa fa-sitemap"></i> Get Shit Done</a></li>
            </ul>

            <div class="nav-right">
                <ul>
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] != '') { ?>

                        <li><a href="myprofile.php"><i class="fa fa-user"></i></a></li>
                        <li><a href="sharedwithme.php"><i class="fa fa-users"></i></a></li>
                    <?php } else { ?>
                        <li><a href="login.php"><i class="fa fa-sign-in"></i></a></li>
                        <li><a href="register.php"><i class="fa fa-user-plus"></i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
