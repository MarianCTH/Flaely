<?php
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if (isset($_POST['schimba_rol'])) 
    {
        $db = $link;
        $angajat = mysqli_real_escape_string($db, $_POST['angajat']);
        $rol = mysqli_real_escape_string($db, $_POST['rol']);

        if (empty($angajat)) 
        { 
            MesajAdaugare('Trebuie să introduci un angajat.' , 'danger');
        }
        else {
            $sql = "SELECT id FROM angajati WHERE username = ?";
        
            if($stmt = mysqli_prepare($link, $sql))
            {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                $param_username = trim($_POST["angajat"]);
                
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) != 1){
                        MesajAdaugare('Acest angajat nu este înregistrat în baza de date.' , 'danger');
                    } 
                    else
                    {
                        $query = "UPDATE angajati set rol='$rol' WHERE username='$angajat'";
                        mysqli_query($db, $query);
                        MesajAdaugare('Rolul angajatului '.$angajat .' a fost schimbat cu succes! (Rol nou: ' .$rol .')', 'success');
                    }
                } 
                else{
                    echo "Oops! Ceva nu a mers bine. Încearcă din nou.";
                }
    
                mysqli_stmt_close($stmt);
            }
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
    <title>Flaely GRUP - Schimbă Rol</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important">
                <div class="col m-1">
                    <div class="text-center">
                        <h1 style="margin-bottom: 45px;">Schimbă Rol</h1>
                    </div>

                    <form action="" method="post">
                        <h4 style="padding-bottom: 5px;" class="text-center">Introdu un angajat</h4>
                        <div class="wrap-input100 validate-input" data-validate = "Trebuie sa introduci numele de utilizator">
                            <input type="text" name="angajat" id="aproape-cauta-nume" class="input100">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>    

                        <h4 style="padding-bottom: 5px;" class="text-center">Selectează un rol</h4>
                        <div class="wrap-input100">
                            <select name="rol" class="input100 xd">
                                <option value="Administrator" style="text-align:center;">Administrator</option>
                                <option value="Șef șantier" style="text-align:center;">Șef șantier</option>
                                <option value="Aprovizionare" style="text-align:center;">Aprovizionare</option>
                                <option value="Muncitor" style="text-align:center;">Muncitor</option>
                            </select>
                        </div>   

                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type = "submit" value = "Schimbă Rolul" name="schimba_rol">
                        </div>         
                    </form>
                    </div>
                    <?php
                        MesajAfisare();
                    ?>   
                    <div class="text-center p-t-80">
                        <a class="txt2" href="admin-cont.php">
                        <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                            Înapoi la pagina de administrare conturi
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