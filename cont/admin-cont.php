<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>
 
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Flaely GRUP - Administrare</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <?php if ($_SESSION["rol"] == 'Administrator'){ ?>
                <div class="wrap-login100" style="width: 1360px !important;">
                    <div class="text-center">
                        <h1 style="margin-bottom: 25px;">Administrare <b><span style="color:#EB492E">conturi</span></b></h1>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="adauga-cont.php">
                                    <img src="images/admin-alege/adauga-cont-xd.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Adaugă Cont</p>
                                    </div>
                                </a>
                            </div>
                        </div>  
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="schimba-rol.php">
                                    <img src="images/admin-alege/schimba-rol.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Schimbă Rol</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="administrare-santiere.php">
                                    <img src="images/admin-alege/administrare-santier.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Șantiere</p>
                                    </div>
                                </a>
                            </div>
                        </div>   
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="schimba-parola.php">
                                    <img src="images/sef-santier-alege/schimba-par.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Schimbă Parola</p>
                                    </div>
                                </a>
                            </div>
                        </div>  
                    </div>
                    <div class="text-center p-t-80">
                    <a class="txt2" href="main.php">
                    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                        Înapoi la pagina de administrare
                    </a>
                    </div>    
                </div>
            <?php } 
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</body>
</html>