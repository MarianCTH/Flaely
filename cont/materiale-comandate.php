<?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main-adauga-cont.css">
    <title>Flaely GRUP - Istoric Comenzi</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Aprovizionare' || $_SESSION["rol"] == 'Șef șantier' ) { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="width: 1360px !important;">
                <div class="container">
                    <div class="row justify-content-center align-items-center text-center">
                        <h1>Materiale Comandate - Flaely GRUP</h1>
                        <h4 style="padding-bottom: 25px; padding-top: 25px;">Istoricul materialelor comandate</h4>
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
                                                        <option value="Cine" <?php if($sortare_alege == "Cine"){ echo " selected"; }?>>Emițător</option>                             
                                                        <option value="Denumire" <?php if($sortare_alege == "Denumire"){ echo " selected"; }?>>Denumire Material</option>
                                                        <option value="Cantitate" <?php if($sortare_alege == "Cantitate"){ echo " selected"; }?>>Cantitate</option>
                                                        <option value="Santier" <?php if($sortare_alege == "Santier"){ echo " selected"; }?>>Șantier</option>
                                                        <option value="Termen" <?php if($sortare_alege == "Termen"){ echo " selected"; }?>>Termen Livrare</option>
                                                        <option value="Furnizor" <?php if($sortare_alege == "Furnizor"){ echo " selected"; }?>>Furnizor</option>
                                                        <option value="data_creare" <?php if($sortare_alege == "data_creare"){ echo " selected"; }?>>Data Emiterii</option>
                                                        <option value="status" <?php if($sortare_alege == "status"){ echo " selected"; }?>>Status</option>
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
                                    <?php
                                        require_once "config.php";
                                        $db = $link;
                                        $query = "SELECT Cine, Cod, Denumire, Cantitate, Santier, Termen, Furnizor, comandat, data_creare, status from materiale ORDER BY `$sortare_alege` $sortare_ascdesc ";
                                        $sum = 0;
                                        $result = $db->query($query);
                                        $contor = 0;

                                        if($result== true)
                                        {
                                            if ($result-> num_rows > 0){?>
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr><th class= "text-center">Cod</th>
                                                    <th class= "text-center">Comandă Trimisă De</th>                                    
                                                    <th class= "text-center">Denumire Mat.</th>                     
                                                    <th class= "text-center">Cantitate</th>
                                                    <th class= "text-center">Furnizor</th>
                                                    <th class= "text-center">Șantier</th> 
                                                    <th class= "text-center">Termen Livrare</th>   
                                                    <th class= "text-center">Data Emiterii</th>
                                                    <th class= "text-center">Status</th>
                                                    <th class= "text-center"></th>
                                                </thead>
                                                <tbody><?php
                                                while($row = $result-> fetch_assoc()){
                                                    if($row["comandat"] == 'da')
                                                    {
                                                        if($row["status"] == 'Livrat')
                                                            echo "<tr>
                                                            <td style='padding-top: 25px;'>". $row["Cod"] ."</td>                                                   
                                                            <td style='padding-top: 25px;'>". $row["Cine"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Denumire"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Cantitate"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Furnizor"] ."</td>  
                                                            <td style='padding-top: 25px;'>". $row["Santier"] ."</td>             
                                                            <td style='padding-top: 25px;'>". $row["Termen"] ."</td>    
                                                            <td>". $row["data_creare"] ."</td>  
                                                            <td style='padding-top: 25px;' class='status-livrat'>". $row["status"] ."</td> 
                                                            <td style='padding-top: 25px;'><a style='font-size: 15px; color: green;' href='php/modifica-comanda-admin.php?Cod=".$row['Cod']."'>Editează</a></td>                                           
                                                            </tr>";
                                                        else
                                                            echo "<tr>
                                                            <td style='padding-top: 25px;'>". $row["Cod"] ."</td>                                                   
                                                            <td style='padding-top: 25px;'>". $row["Cine"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Denumire"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Cantitate"] ."</td>
                                                            <td style='padding-top: 25px;'>". $row["Furnizor"] ."</td>  
                                                            <td style='padding-top: 25px;'>". $row["Santier"] ."</td>             
                                                            <td style='padding-top: 25px;'>". $row["Termen"] ."</td>    
                                                            <td>". $row["data_creare"] ."</td>  
                                                            <td style='padding-top: 25px;'><a class='status-nelivrat' href='php/modifica-status.php?Cod=".$row['Cod']."'>Confirmă Livrare</a></td>  
                                                            <td style='padding-top: 25px;'><a style='font-size: 15px; color: green;' href='php/modifica-comanda-admin.php?Cod=".$row['Cod']."'>Editează</a></td>                                     
                                                            </tr>";
                                                        $sum += $row['Cantitate'];
                                                        $contor++;
                                                    }
                                                }
                                                ?>
                                                <td colspan="5" class="table-active table-dark" style="font-size: 20px;">Total Materiale: </td>
                                                <td colspan="5" class="table-active table-dark" style="font-size: 25px;"> <?php echo $contor ."</td>"?>
                                                </tr><td colspan="5" class="table-active table-dark" style="font-size: 20px;">Cantitate Materiale: </td>
                                                <td colspan="5" class="table-active table-dark" style="font-size: 25px;"> <?php echo $sum ."</td>";
                                                echo "</table>"; ?>
                                            <?php
                                            }
                                            else{
                                                echo "Nu exista materiale comandate.";
                                            }                        
                                        }
                                        else{
                                            echo "Eroare baza de date.";
                                        }
                                    ?>
                                </tbody>
                            </table>
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
    </div>
<?php } else header("location: login.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/raport-zilnic.js"></script>
</body>
</html>