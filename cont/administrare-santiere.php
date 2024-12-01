<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $db = $link;
    if(isset($_POST['adauga-santier'])){
        $nume_santier = mysqli_real_escape_string($db, $_POST['nume_santier_form']);
         
        if (empty($nume_santier)) 
        { 
            MesajAdaugare('Trebuie sa introduci un nume de șantier.' , 'danger');
        }        
        else {
            $queryxd = "INSERT INTO santiere (nume_santier) VALUES ('$nume_santier')";
            mysqli_query($db, $queryxd);
            MesajAdaugare('Ai adaugat șantierul cu succes!' , 'success');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main-adauga-cont.css">
    <title>Flaely GRUP - Șantiere</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="width: 1360px !important;">
                <h1 class="text-center" style="padding-bottom: 15px;">Șantiere - Flaely GRUP</h1>
                <div class="container text-center">
                    <div class="row justify-content-center align-items-center">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header text-center" id="flush-headingOne">
                                    <button class="accordion-button collapsed filtre" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Adaugă Șantier
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="" method="post">
                                            <h4 style="padding-bottom: 15px;">Nume Șantier</h4>
                                            <div class="wrap-input100 validate-input" data-validate = "Trebuie sa introduci un nume de șantier">
                                                <input type="text" name="nume_santier_form" class="form-control input100">
                                                <span class="focus-input100"></span>
                                                <span class="symbol-input100">
                                                    <i class="fa fa-helmet-safety" aria-hidden="true"></i>
                                                </span>
                                            </div> 

                                            <div class="container-login100-form-btn">
                                                <input class="login100-form-btn" type = "submit" value = "Adaugă Șantier" name="adauga-santier">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            require_once "config.php";
                            $db = $link;
                            $query = "SELECT id, nume_santier from santiere";
                            $result = $db->query($query);
                            $contor = 0;

                            if($result== true)
                            {
                                if ($result-> num_rows > 0){?>
                                    <div class="table-responsive">
                                    <table class="table table-bordered">

                                    <tbody><?php
                                    while($row = $result-> fetch_assoc()){
                                        echo "<tr>                                                
                                        <td style='font-size: 35px;'>". $row["nume_santier"] ."</td>
                                        <td style='padding-top: 15px;'><a class='delete-x-sefsantier' href='php/delete-santier.php?id=".$row['id']."'>Șterge</a></td>                                                                              
                                        </tr>";
                                        $contor++;
                                    }
                                    ?>
                                    </tr><?php echo "</tbody></table></div>";
                                }
                                else{
                                    echo "Nu există șantiere deschise.";
                                }                        
                            }
                            else{
                                echo "Eroare baza de date.";
                            }
                            MesajAfisare();
                        ?>
                    </div>
                </div>
                <div class="text-center p-t-80">
                    <a class="txt2" href="admin-cont.php">
                    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                        Înapoi la pagina de administrare conturi
                    </a>
                </div>
            </div>  
        </div>
    </div>
<?php } else header("location: login.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/raport-zilnic.js"></script>
</body>
</html>