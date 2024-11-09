
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">FIDITI
    <!-- <img src="" alt="" width="50px" height="50px"/> -->
    </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <?php
                if(!isset($_SESSION["user"])){
                    ?>
                    <a href="login.php" class="nav-link">Customer</a>
                    <a href="admin_login.php" class="nav-link">Admin</a>
                    <!-- a class="nav-item nav-link" href="register.php">Register</a -->
                    <?php
              }

              else{
                ?>
                <ul class="nav justify-content-end">
                    <?php
                        if($_SESSION["states"] === "admin"){
                            ?>
                            <a class="nav-item nav-link" href="admin_dashboard.php">Dashboard</a></li>
                            <a class="nav-item nav-link" href="admin_profile.php"><?php echo $_SESSION["user"]; ?></a>
                        <?php
                        }
                        else{
                            ?>
                            <a class="nav-item nav-link" href="customer_dashboard.php">Dashboard</a></li>
                            <a class="nav-item nav-link" href="profile.php"><?php echo $_SESSION["user"]; ?></a>
                        <?php
                        }
                    ?>
                    <a class="nav-item nav-link" href="logout.php">Logout</a>
                <?php
              }
            ?>

        </div>
    </div>
</nav>
