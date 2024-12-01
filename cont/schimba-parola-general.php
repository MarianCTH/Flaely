<?php
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if (isset($_POST['schimba'])) 
    {
        $db = $link;
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        if (empty($password_1)) 
        { 
            MesajAdaugare('Trebuie sa scri o parolă.' , 'danger');
        }
        else if ($password_1 != $password_2) 
        {
            MesajAdaugare('Parola nu este aceeași cu cea dintâi.' , 'danger');
        }
        else {
            $password = password_hash($password_1, PASSWORD_DEFAULT);

            $query = "UPDATE angajati set password='$password' WHERE id='" . $_SESSION["id"] . "'";
            mysqli_query($db, $query);
            MesajAdaugare('Parola dumneavoastră a fost schimbată cu succes.' , 'success');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
    <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
    <title>Flaely GRUP - Schimbă Parola</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Șef șantier' || $_SESSION["rol"] == 'Aprovizionare' ) { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important">
                <div class="col m-1">
                    <div class="text-center">
                        <h1 style="margin-bottom: 45px;">Schimbă Parola</h1>
                    </div>

                    <form action="" method="post">
                        <h3 style="padding-bottom: 15px;" class="text-center">Parolă nouă</h3>

                        <div class="autocomplete-container wrap-input100 validate-input" data-validate = "Trebuie să introduci o parolă">
                            <input class="input100" type="password" name="password_1" placeholder="Parolă nouă">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="autocomplete-container wrap-input100 validate-input" data-validate = "Trebuie să confirmi parola.">
                            <input class="input100" type="password" name="password_2" placeholder="Confirmă parola">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type = "submit" value = "Schimbă Parola" name="schimba">
                        </div>         
                    </form>
                    </div>
                    <?php
                        MesajAfisare();
                    ?>   
                    <div class="text-center p-t-80">
                        <a class="txt2" href="main.php">
                        <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                            Înapoi la pagina de administrare
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