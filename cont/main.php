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
            <?php if ($_SESSION["rol"] == 'Administrator') { ?>
                <div class="wrap-login100" style="width: 1360px !important;">
                        <div class="text-center">
                            <h1 style="margin-bottom: 25px;">Bine ai venit <b><span style="color:#EB492E"><?php echo htmlspecialchars($_SESSION["username"]); ?></span><spanel style="color:black;"><sup><?php echo ' ['. htmlspecialchars($_SESSION["rol"]). ']';?></span></sup></b></h1>
                        </div>
                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col my-col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="rapoarte-main.php">
                                        <img src="images/admin-alege/rapoarte.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <p class="card-text text-center">Rapoarte</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="lista-angajati.php">
                                        <img src="images/admin-alege/lista-angajati.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <p class="card-text text-center">Listă Angajați</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="materiale-comandate.php">
                                        <img src="images/admin-alege/comenzi.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <p class="card-text text-center">Istoric Comenzi</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="admin-cont.php">
                                        <img src="images/admin-alege/adauga-cont.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <p class="card-text text-center">Admin Cont</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php } 
            else if ($_SESSION["rol"] == 'Șef șantier'){ ?>
                <div class="wrap-login100">
                    <div class="text-center">
                         <h1 style="margin-bottom: 25px;">Bine ai venit <b><span style="color:#EB492E"><?php echo htmlspecialchars($_SESSION["username"]); ?></span><spanel style="color:black;"><sup><?php echo ' ['. htmlspecialchars($_SESSION["rol"]). ']';?></span></sup></b></h1>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="santiere.php">
                                        <img src="images/sef-santier-alege/santier1.png" class="card-img-top">
                                        <div class="card-body">
                                        <p class="card-text text-center">Raportează Muncitori</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="materiale.php">
                                        <img src="images/sef-santier-alege/cutie.png" class="card-img-top">
                                        <div class="card-body">
                                        <p class="card-text text-center">Comandă Materiale</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col culoare">
                                <div class=" card buton ms-auto me-auto">
                                    <a href="schimba-parola-general.php">
                                        <img src="images/sef-santier-alege/schimba-par.png" class="card-img-top">
                                        <div class="card-body">
                                        <p class="card-text text-center">Schimbă Parola</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            <?php } 
            else if ($_SESSION["rol"] == 'Muncitor'){ ?>
                <div class="wrap-login100">
                </div>
            <?php } 
            else if ($_SESSION["rol"] == 'Aprovizionare'){ ?>
                <div class="wrap-login100">
                    <div class="text-center">
                        <h1 style="margin-bottom: 25px;">Bine ai venit <b><span style="color:#EB492E"><?php echo htmlspecialchars($_SESSION["username"]); ?></span><spanel style="color:black;"><sup><?php echo ' ['. htmlspecialchars($_SESSION["rol"]). ']';?></span></sup></b></h1>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col m-2">
                            <div class="col culoare">
                                <a href="materiale-furnizor.php">
                                    <img src="images/sef-santier-alege/cutie.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Comandă Materiale</p>
                                    </div>
                                </a>
                            </div>
                        </div>  
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="materiale-comandate.php">
                                    <img src="images/sef-santier-alege/cutie2.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Istoric Comenzi</p>
                                    </div>
                                </a>
                            </div>
                        </div>  
                        <div class="col culoare">
                            <div class=" card buton ms-auto me-auto">
                                <a href="schimba-parola-general.php">
                                    <img src="images/sef-santier-alege/schimba-par.png" class="card-img-top">
                                    <div class="card-body">
                                    <p class="card-text text-center">Schimbă Parola</p>
                                    </div>
                                </a>
                            </div>
                        </div>   
                    </div>    
                </div>
            <?php } 
            ?>
            <div class="footer">
                <a href="logout.php" class="btn btn-danger ml-3">Ieși din cont</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</body>
</html>