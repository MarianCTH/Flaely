<?php
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    $db = $link;
    $Santier_ses="";
    $Cantitate_ses = "";
    $loc_livrare = "";
    if (isset($_POST['adauga-material'])) 
    {
        // Prepare a select statement
        $sql = "SELECT Cod FROM mat WHERE DenumireMat = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_DenumireMat);
            $param_DenumireMat = trim($_POST["Material_ses"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) != 1) MesajAdaugare('Acest material nu există.' , 'danger');
                else
                {
                    $Material_ses = mysqli_real_escape_string($db, $_POST['Material_ses']);
                    $Cantitate_ses = mysqli_real_escape_string($db, $_POST['Cantitate_ses']);
                    $Furnizorxd = mysqli_query($db, "SELECT `Furnizor` from `mat` WHERE DenumireMat = '$Material_ses' ");
                    $Furnizor_ses = mysqli_fetch_array($Furnizorxd);
                    $cine = $_SESSION["username"];
                    $termen_livrare = mysqli_real_escape_string($db, $_POST['termen_livrare']);
                    $Santier_ses = mysqli_real_escape_string($db, $_POST['Santier_ses']);
                    $query = "INSERT INTO sesiune_sefsantier_comanda (Cine_ses, Material_ses, Cantitate_ses, Furnizor_ses, TermenLivrare_ses, Santier_ses) 
                                                                        VALUES ('$cine', '$Material_ses', '$Cantitate_ses', '$Furnizor_ses[0]', '$termen_livrare', '$Santier_ses')";
                    mysqli_query($db, $query);
                    MesajAdaugare('Materialul a fost adaugat în listă.' , 'success');
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    if (isset($_POST['comanda'])) 
    {
        $data = mysqli_query($db, "SELECT Cine_ses, Material_ses, Cantitate_ses, Furnizor_ses, TermenLivrare_ses, Santier_ses FROM sesiune_sefsantier_comanda");
        $values = Array();
        while ($row = mysqli_fetch_assoc($data)) {
            $row['Cine_ses'] = mysqli_real_escape_string($db, $row['Cine_ses']);
            $row['Material_ses'] = mysqli_real_escape_string($db, $row['Material_ses']);
            $row['Cantitate_ses'] = mysqli_real_escape_string($db, $row['Cantitate_ses']);
            $row['Santier_ses'] = mysqli_real_escape_string($db, $row['Santier_ses']);
            $row['TermenLivrare_ses'] = mysqli_real_escape_string($db, $row['TermenLivrare_ses']);
            $row['Furnizor_ses'] = mysqli_real_escape_string($db, $row['Furnizor_ses']);
            $values[] = "('$row[Cine_ses]','$row[Material_ses]','$row[Cantitate_ses]','$row[Santier_ses]','$row[TermenLivrare_ses]','$row[Furnizor_ses]', 'nu')";
        }
        mysqli_query($db, "INSERT INTO materiale (Cine, Denumire, Cantitate, Santier, Termen, Furnizor, comandat) VALUES ".implode(',',$values)."");
        MesajAdaugare('Comanda a fost plasată cu succes.' , 'success');
        mysqli_query($db, "DELETE FROM sesiune_sefsantier_comanda");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flaely GRUP - Comandă Materiale</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
    <script src="https://kit.fontawesome.com/b3f4906d87.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main-adauga-cont.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>  
<?php if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Șef șantier') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important; width: 960px;">
                <div class="text-center">
                    <h1 style="margin-bottom: 5px;">Adaugă Materiale</h1>
                </div>
                <div class="text-center p-t-80">
                <div class="row justify-content-center align-items-center">
                    <form action="" method="post">
                        <h4 style="padding-left: 15px;">Denumire Material</h4>
                        <div class="autocomplete-container wrap-input100 validate-input" data-validate = "Trebuie sa introduci denumirea materialului">
                            <input class="input100" type="text" id="aproape-cauta-material" name="Material_ses">
                            <span class="focus-input100"></span>
                        </div>

                        <h4 style="padding-left: 15px;">Cantitate</h4>
                        <div class="wrap-input100 validate-input" data-validate = "Trebuie să introduci cantitatea.">
                            <input type="number" name="Cantitate_ses" class="input100">
                            <span class="focus-input100"></span>
                        </div>

                        <h4 style="padding-left: 15px;">Termen Livrare</h4>
                        <div class="wrap-input100 validate-input" data-validate = "Trebuie să introduci termenul de livrare.">
                            <input type="date" name="termen_livrare" class="input100" value="<?php echo $termen_livrare; ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <h4 style="padding-left: 15px;">Șantier</h4>
                        <div class="wrap-input100">
                            <select name="Santier_ses" class="input100 xd">
                                <?php 
                                    $sql = "SELECT * FROM `santiere`";
                                    $all_categories = mysqli_query($link,$sql);
                                    while ($category = mysqli_fetch_array(
                                            $all_categories,MYSQLI_ASSOC)):; 
                                ?>
                                    <option value="<?php echo $category["nume_santier"];?>" <?php if($category["nume_santier"] == $Santier_ses) echo 'selected'; ?>>
                                        <?php echo $category["nume_santier"]; ?>
                                    </option>
                                <?php 
                                    endwhile; 
                                ?>
                            </select>
                        </div>

                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type = "submit" value = "Adaugă material" name="adauga-material" style="margin-bottom: 0px !important;">
                        </div>   
                    </form>
                                </div>
                </div>
                <div class="text-center p-t-80">
                    <?php MesajAfisare();?>
                    <div class="row justify-content-center align-items-center">
                        <?php
                            require_once "config.php";
                            $db = $link;
                            $query = "SELECT id, Material_ses, Cantitate_ses, Furnizor_ses, TermenLivrare_ses, Santier_ses from sesiune_sefsantier_comanda";
                            $sum = 0;
                            $result = $db->query($query);
                            $contor = 0;

                            if($result== true)
                            {
                                if ($result-> num_rows > 0){
                                    ?>
                                    <h4 style="padding-bottom: 25px; padding-top: 25px;">Lista materialelor</h4>
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead><tr>
                                        <th class= "text-center">Denumire Material</th>                     
                                        <th class= "text-center">Cantitate</th>
                                        <th class= "text-center">Furnizor</th>
                                        <th class= "text-center">Termen Livrare</th>
                                        <th class= "text-center">Șantier</th>
                                    <tr></thead>
                                    <tbody><?php
                                    while($row = $result-> fetch_assoc()){
                                        echo "<tr>
                                        <td>". $row["Material_ses"] ."</td>                                                   
                                        <td>". $row["Cantitate_ses"] ."</td>        
                                        <td>". $row["Furnizor_ses"] ."</td>      
                                        <td>". $row["TermenLivrare_ses"] ."</td>   
                                        <td>". $row["Santier_ses"] ."</td>   
                                        <td><a class='delete-x-sefsantier' href='php/delete.php?id=".$row['id']."'>x</a></td> 
                                        </tr>";
                                        $sum += $row['Cantitate_ses'];
                                        $contor++;
                                    }
                                    ?>
                                    <td colspan="4" class="table-active table-dark" style="font-size: 20px;">Total Materiale: </td>
                                    <td colspan="4" class="table-active table-dark" style="font-size: 25px;"> <?php echo $contor ."</td>"?>
                                    </tr><td colspan="4" class="table-active table-dark" style="font-size: 20px;">Cantitate Materiale: </td>
                                    <td colspan="4" class="table-active table-dark" style="font-size: 25px;"> <?php echo $sum ."</td>";
                                    echo "</tbody></table></div>"; ?>
                                    <form action="" method="post" class="login100-form">
                                        <div class="container-login100-form-btn" style="padding: 15px;">
                                            <input class="login100-form-btn" type = "submit" value = "Comandă" name="comanda">
                                        </div>   
                                    </form>
                                <?php
                                }                     
                            }
                            else{
                                echo "Eroare baza de date.";
                            }
                        ?>
                    </div>
                    <a class="txt2" href="main.php">
                    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                        Înapoi la pagina de administrare
                    </a>
                </div> 
            </div>
        </div>
    </div>
<?php } else header("location: login.php"); ?>
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="frontend-script2.js"></script>
</body>
</html>