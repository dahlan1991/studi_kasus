<?php session_start();
include_once "library/inc.connection.php"; ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title><?php echo $ambil['nm_toko'] ?> | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="assets/css/default/style.min.css" rel="stylesheet" />
    <link href="assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>

<body class="pace-top bg-white">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(assets/img/login-bg-11.jpg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><b><?php echo $ambil['nm_toko'] ?></h4>
                    <p>
                        <?php echo $ambil['alamat_toko'];
                        echo " HP. ";
                        echo $ambil['no_telepon']  ?>
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                        <i class="fa fa-shopping-cart fa-lg"></i> <?php echo $ambil['nm_toko'] ?>
                        <small><?php echo $ambil['alamat_toko'];
                                echo " HP. ";
                                echo $ambil['no_telepon'] ?></small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <?php
                    if (isset($_POST['btnLogin'])) {

                        # Baca variabel form
                        $txtUser     = $_POST['txtUser'];
                        $txtPassword = md5($_POST['txtPassword']);

                        # LOGIN CEK KE TABEL USER LOGIN
                        $myQry = $koneksidb->query("SELECT * FROM petugas WHERE username='$txtUser' AND password='$txtPassword' ");
                        # JIKA LOGIN SUKSES
                        if ($myQry->num_rows >= 1) {
                            $myData = $myQry->fetch_assoc();
                            $_SESSION['SES_LOGIN'] = $myData['kd_petugas'];
                            $_SESSION['SES_USER'] = $myData['username'];
                            $_SESSION['petugas'] = $myData['nm_petugas'];
                            $_SESSION['level'] = $myData['level'];

                            // Jika yang login Administrator
                            if ($_SESSION['level'] == "Admin") {

                                header("Location: home.php");
                            }

                            // Jika yang login Apotek
                            if ($_SESSION['level'] == "Apotek") {
                                header("Location: home.php");
                            }
                        } else {
                            echo "Maaf, Email atau Password tidak sama";
                        }
                    } // End POST
                    ?>
                    <form role="form" action="" method="post" id="form1">
                        <input class="form-control" name="txtUser" placeholder="Masukan Username" type="text" size="30" maxlength="20" /><br />
                        <input class="form-control" name="txtPassword" placeholder="Masukan Password" type="password" size="30" maxlength="20" /><br />
                        <br>
                        <div class="login-buttons">
                            <input type="submit" name="btnLogin" class="btn btn-success btn-block btn-lg" value=" Login " />
                        </div>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->

    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <!--[if lt IE 9]>
		<script src="../assets/crossbrowserjs/html5shiv.js"></script>
		<script src="../assets/crossbrowserjs/respond.min.js"></script>
		<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/js-cookie/js.cookie.js"></script>
    <script src="assets/js/theme/default.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</body>

</html>