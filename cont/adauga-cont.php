<?php
// Include config file
session_start();
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if(isset($_POST['adauga-cont'])){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Te rog să introduci un nume de utilizator.";
    }
    else
    {
        // Prepare a select statement
        $sql = "SELECT id FROM angajati WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Acest nume de utilizator este deja in folosință.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } 
            else{
                echo "Oops! Ceva nu a mers bine. Încearcă din nou.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Te rog să introduci o parolă";     
    }
    else{
        $password = trim($_POST["password"]);
        $rol = trim($_POST["rol"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO angajati (username, password, rol) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_rol);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_rol = $rol;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                MesajAdaugare('Contul a fost creat cu succes!' , 'success');
                
            } else{
                echo "Oops! Ceva nu a mers bine. Încearcă din nou.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}

if (isset($_POST['schimba'])) 
{
    $db = $link;
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    if (empty($password_1)) 
    { 
        MesajAdaugare('Te rog introdu parola nouă.' , 'danger');
    }
    else if ($password_1 != $password_2) 
    {
        MesajAdaugare('Parolele nu sunt asemănătoare.' , 'danger');
    }
    else {
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        $query = "UPDATE angajati set password='$password' WHERE id='" . $_SESSION["id"] . "'";
        mysqli_query($db, $query);
        $password = "";
        MesajAdaugare('Parola dumneavoastră a fost schimbată cu succes.' , 'success');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flaely GRUP - Adăugare Cont</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main-adauga-cont.css">
<!--===============================================================================================-->
</head>
<body>  
<?php if ($_SESSION["rol"] == 'Administrator') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important">
                <div class="col m-1">
                    <div class="text-center">
                        <h1 style="margin-bottom: 45px;">Adaugă Cont</h1>
                    </div>

                    <form action="" method="post" id="adauga-cont">

                        <h4 style="padding-left: 15px;">Nume Utilizator</h4>
                        <div class="wrap-input100 validate-input" data-validate = "Trebuie sa introduci numele de utilizator">
                            <input type="text" name="username" class="form-control input100" value="<?php echo $username; ?>">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>    

                        <h4 style="padding-left: 15px;">Parolă</h4>
                        <div class="wrap-input100 validate-input" data-validate = "Trebuie sa introduci parola">
                            <input type="password" name="password" class="form-control input100" value="<?php echo $password; ?>">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        <h4 style="padding-left: 15px;">Rolul contului</h4>
                        <div class="wrap-input100">
                            <select name="rol" form="adauga-cont" class="input100 xd">
                                <option value="Administrator" style="text-align:center;">Administrator</option>
                                <option value="Șef șantier" style="text-align:center;">Șef șantier</option>
                                <option value="Aprovizionare" style="text-align:center;">Aprovizionare</option>
                                <option value="Muncitor" style="text-align:center;">Muncitor</option>
                            </select>
                        </div>    

                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type = "submit" value = "Crează cont" name="adauga-cont">
                        </div>
                    </form>
                    </div>
                    <div class="text-center p-t-80">
                        <?php
                            MesajAfisare();
                        ?>   
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
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>