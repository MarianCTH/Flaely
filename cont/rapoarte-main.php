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
                <div class="wrap-login100">
                    <div class="text-center">
                        <h1 style="margin-bottom: 25px;">Administrare <b><span style="color:#EB492E">conturi</span></b></h1>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col m-2">
                            <div class=" card buton ms-auto me-auto">
                                <a href="raport-zilnic.php">
                                    <img src="images/admin-alege/raport-zilnic.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Raport Zilnic</p>
                                    </div>
                                </a>
                            </div>
                        </div>  
                        <div class="col m-2">
                            <div class=" card buton ms-auto me-auto">
                                <a href="rapoarte.php">
                                    <img src="images/admin-alege/raport-pdf.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Raport PDF</p>
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