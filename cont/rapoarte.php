<?php
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <title>Flaely GRUP - Rapoarte</title>
    </head>
    <body>
    <?php if ($_SESSION["rol"] == 'Administrator') { ?>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100" style="padding-top: 20px !important">
                    <div class="col m-1">
                        <div class="text-center">
                            <h1 style="margin-bottom: 45px;">Generează PDF - Raport Șantier</h1>
                            <h2 style="margin-bottom: 15px;">Selectează perioada dorită:</h2>
                            <form method="post" action="generate_pdf.php">
                            <h4 style="padding-left: 15px;">De la:</h4>
                            <div class="wrap-input100 validate-input" data-validate = "Trebuie să introduci termenul de livrare.">
                                <input type="date" name="de_la" class="input100">
                                <span class="focus-input100"></span>
                            </div>
                            <h4 style="padding-left: 15px;">Până la:</h4>
                            <div class="wrap-input100 validate-input" data-validate = "Trebuie să introduci termenul de livrare.">
                                <input type="date" name="pana_la" class="input100">
                                <span class="focus-input100"></span>
                            </div>
                                <button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary">Generează PDF</button>
                            </form>
                            </fieldset>
                        </div>
                        <?php
                            MesajAfisare();
                        ?>   
                        <div class="text-center p-t-80">
                            <a class="txt2" href="rapoarte-main.php">
                            <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                                Înapoi la pagina de rapoarte
                            </a>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    <?php } else header("location: login.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="frontend-script.js"></script>
    </body>
</html>