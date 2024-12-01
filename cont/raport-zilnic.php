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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
    <title>Flaely GRUP - Raport Zilnic</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="text-center">
                    <h1 style = "padding-bottom: 25px;">Raport Șantiere (<?php echo date("d.m.Y")?>)</h1>
                    <form name="myform" action="" method="post">
                        <select name="nrsantier" id="santiere" class="form-select text-center mx-auto" style="width: 340px !important;" onChange="this.form.submit()">
                        <?php 
                                $result2 = mysqli_query($link, "SELECT nume_santier FROM santiere LIMIT 1");
                                $row = mysqli_fetch_assoc($result2);
                                $nrsantier = $row['nume_santier'];
                                if(isset($_POST['nrsantier'])){
                                    $nrsantier = $_POST['nrsantier'];
                                }

                                $sql = "SELECT * FROM `santiere`";
                                $all_categories = mysqli_query($link,$sql);
                                while ($category = mysqli_fetch_array(
                                        $all_categories,MYSQLI_ASSOC)):; ?>
                                    <option value="<?php echo $category["nume_santier"];?>" <?php if($category["nume_santier"] == $nrsantier){ echo " selected"; }?>>
                                        <?php echo $category["nume_santier"]; ?>
                                    </option>
                            <?php
                                endwhile; 
                            ?>
                        </select>
                    </form>
                    <div class="table-responsive">
                        <?php
                            $db = $link;
                            $query = "SELECT Nume, Rol, Prezenta from santier_1 WHERE created = CURDATE() AND Santier = '$nrsantier' ORDER BY Prezenta";
                            $result = $db->query($query);
                            $contor = 1;

                            if($result== true)
                            {
                                if ($result-> num_rows > 0){ ?>
                                    <table class="table table-bordered">
                                        <thead><tr><th>Nr. crt.</th>
                                            <th>Nume</th>
                                            <th>Rol</th>
                                            <th>Prezență</th><tr>
                                        </thead>
                                    <tbody> <?php
                                    while($row = $result-> fetch_assoc()){
                                        echo "<tr>
                                            <td>". $contor ."</td>
                                            <td>". $row["Nume"] ."</td>
                                            <td>". $row["Rol"] ."</td>
                                            <td>". $row["Prezenta"] ." ore</td>
                                            </tr>";
                                        $contor++;
                                    }?>
                                    <td colspan="2" class="table-active table-dark" style="font-size: 20px;">Total Muncitori: </td>
                                    <td colspan="3" class="table-active table-dark" style="font-size: 25px;"> <?php echo $contor-1 ."</td>";
                                    echo "</tbody></table>";
                                }
                                else{
                                    echo "Nu a fost gasit nici un rezultat.";
                                }                        
                            }
                            else{
                                echo "Eroare baza de date.";
                            }
                        ?>
                    </div>
                </div>

                <div class="text-center p-t-80">
                    <a class="txt2" href="rapoarte-main.php">
                    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                        Înapoi la pagina de rapoarte
                    </a>
                </div>
            </div>  
        </div>
    </div>
<?php } else header("location: login.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>