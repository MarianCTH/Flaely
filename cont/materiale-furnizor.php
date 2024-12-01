<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    if(isset($_POST['livrare-terminata'])){
        $sql = "UPDATE materiale SET comandat='da' WHERE comandat='nu'";
    
        if ($link->query($sql) === TRUE) {
            MesajAdaugare('Livrarea a fost terminată, lista materialelor de livrat s-a actualizat!' , 'success');
        } 
        else {
        echo "Eroare comanda: " . $clink->error;
        }
    }
    $sortare_alege = 'cod';
    $sortare_ascdesc = 'DESC';
    if(isset($_POST['sortare_tabel'])){
        $sortare_alege =  mysqli_real_escape_string($link, $_POST['sortare_alege']);
        $sortare_ascdesc =  mysqli_real_escape_string($link, $_POST['sortare_ascdesc']);
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
    <title>Flaely GRUP - Comandă Materiale</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Aprovizionare' || $_SESSION["rol"] == 'Șef șantier' ) { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="width: 1360px !important;">
                <h1 class="text-center">Comandă Materiale - Flaely GRUP</h1>
                <div class="container text-center">
                    <div class="row justify-content-center align-items-center">
                        <?php
                            require_once "config.php";
                            $db = $link;
                            $query = "SELECT Cine, Cod, Denumire, Cantitate, Santier, Termen, Furnizor, comandat, data_creare from materiale WHERE comandat = 'nu' ORDER BY `$sortare_alege` $sortare_ascdesc ";
                            $sum = 0;
                            $result = $db->query($query);
                            $contor = 0;

                            if($result== true)
                            {
                                if ($result-> num_rows > 0){?>
                                     <h4 style="padding-bottom: 25px; padding-top: 25px;">Materialele de comandat sunt:</h4>
                                     <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header text-center" id="flush-headingOne">
                                                <button class="accordion-button collapsed filtre" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Filtre
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <form action="" method="post" id="sortare">
                                                        <div class="container justify-content-center filtre-continut">
                                                            <h5 style="padding-top: 3px; padding-bottom: 5px;">Sortează după:</h5>
                                                            <div class="wrap-input100">         
                                                                <select form="sortare" name="sortare_alege">
                                                                    <option value="Cod" <?php if($sortare_alege == "Cod"){ echo " selected"; }?>>Cod</option>
                                                                    <option value="Santier" <?php if($sortare_alege == "Santier"){ echo " selected"; }?>>Șantier</option>
                                                                    <option value="Furnizor" <?php if($sortare_alege == "Furnizor"){ echo " selected"; }?>>Furnizor</option>
                                                                    <option value="data_creare" <?php if($sortare_alege == "data_creare"){ echo " selected"; }?>>Data Emiterii</option>
                                                                </select>      
                                                            </div>     
                                                            <div class="wrap-input100">     
                                                                <select form="sortare" name="sortare_ascdesc">                       
                                                                    <option value="ASC" <?php if($sortare_ascdesc == "ASC"){ echo " selected"; }?>>Crescător</option>
                                                                    <option value="DESC" <?php if($sortare_ascdesc == "DESC"){ echo " selected"; }?>>Descrescător</option>
                                                                </select>        
                                                            </div>  
                                                            <div class="container-login100-form-btn">
                                                                <input class="login100-form-btn" type = "submit" value = "Sortează" name="sortare_tabel">
                                                            </div>   
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead><tr>
                                        <th>Cod</th>                                    
                                        <th class= "text-center">Comandă Trimisă De</th>
                                        <th class= "text-center">Denumire Mat.</th>               
                                        <th class= "text-center">Cantitate</th>
                                        <th class= "text-center">Furnizor</th>      
                                        <th class= "text-center">Șantier</th> 
                                        <th class= "text-center" style="padding: 0 35px; 0px 35px">Termen Livrare</th>   
                                        <th class= "text-center" style="padding: 0 35px; 0px 35px">Data Trimiterii</th><tr>
                                    </thead>
                                    <tbody><?php
                                    while($row = $result-> fetch_assoc()){
                                        if($row["comandat"] == 'nu')
                                        {
                                            echo "<tr>
                                            <td>". $row["Cod"] ."</td>                                                   
                                            <td>". $row["Cine"] ."</td>
                                            <td>". $row["Denumire"] ."</td>
                                            <td>". $row["Cantitate"] ."</td>
                                            <td>". $row["Furnizor"] ."</td> 
                                            <td>". $row["Santier"] ."</td>             
                                            <td>". $row["Termen"] ."</td>        
                                            <td>". $row["data_creare"] ."</td>  
                                            <td style='padding-top: 25px;'><a style='font-size: 15px; color: green;' href='php/trimite-comanda.php?Cod=".$row['Cod']."'>Trimite</a></td>  
                                            <td style='padding-top: 25px;'><a style='font-size: 15px; color: #38a2ff;' href='php/modifica-comanda.php?Cod=".$row['Cod']."'>Editează</a></td> 
                                            <td style='padding-top: 15px;'><a class='delete-x-sefsantier' href='php/delete-furnizor.php?Cod=".$row['Cod']."'>x</a></td>                                                                              
                                            </tr>";
                                            $sum += $row['Cantitate'];
                                            $contor++;
                                        }
                                    }
                                    ?>
                                    <td colspan="6" class="table-active table-dark" style="font-size: 20px;">Total Materiale: </td>
                                    <td colspan="5" class="table-active table-dark" style="font-size: 25px;"> <?php echo $contor ."</td>"?>
                                    </tr><td colspan="6" class="table-active table-dark" style="font-size: 20px;">Cantitate Materiale: </td>
                                    <td colspan="5" class="table-active table-dark" style="font-size: 25px;"> <?php echo $sum ."</td>";
                                    echo "</tbody></table></div>"; ?>
                                    <div class="container-login100-form-btn">
                                        <form action="" method="post">
                                            <input class="login100-form-btn" type="submit" name="livrare-terminata" value="Comandă efectuată (Toate)" />
                                        </form>
                                    </div>
                                <?php
                                }
                                else{
                                    echo " Nu există materiale de comandat.";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/raport-zilnic.js"></script>
</body>
</html>