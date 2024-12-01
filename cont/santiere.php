<?php
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $last = "";
    if(isset($_REQUEST['last']))
        $last=$_REQUEST['last'];

    $prezenta = "";
    if(isset($_REQUEST['ore']))
        $prezenta=$_REQUEST['ore'];

    if(isset($_POST['raporteaza']))
    {
        $nume = $_REQUEST['Nume'];
        $santier = mysqli_real_escape_string($link, $_POST['santier']);
        $ore = mysqli_real_escape_string($link, $_POST['prezenta']);
        $last = mysqli_real_escape_string($link, $_POST['santier']);
        
        if(empty($nume))
        {
            MesajAdaugare('Trebuie sa introduci un angajat.' , 'danger');
        }
        else{
            header("Location: php/listaAction.php?action=adaugaMuncitor&nume=$nume&santier=$santier&ore=$ore");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/style-welcome.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Flaely GRUP - Șantiere</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Șef șantier' ) { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important">
                <div class="col m-1">
                    <div class="text-center">
                        <h1 style="margin-bottom: 65px; margin-top: 35px;">Raportare Angajați</h1>
                    </div>
                    
                    <?php 
                        $rq = mysqli_query($link, "SELECT * FROM santiere");

                        $row_cnt = mysqli_num_rows($rq);
                        if($row_cnt > 0)
                        {
                    ?>
                    <form action="" method="post" id="raportare">
                        <div class="autocomplete-container wrap-input100 validate-input" data-validate = "Trebuie sa introduci numele angajatului">
                            <input class="input100" type="text" id="aproape-cauta-nume" name="Nume" placeholder="Nume">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="wrap-input100">
                            <select name="santier" class="input100 xd" style="margin-bottom: 15px !important;">
                                <?php 
                                    $sql = "SELECT * FROM `santiere`";
                                    $all_categories = mysqli_query($link,$sql);
                                    while ($category = mysqli_fetch_array(
                                            $all_categories,MYSQLI_ASSOC)):; 
                                ?>
                                        <option value="<?php echo $category["nume_santier"];?>" <?php if($category["nume_santier"] == $last) echo 'selected'; ?>>
                                            <?php echo $category["nume_santier"]; ?>
                                        </option>
                                <?php 
                                    endwhile; 
                                ?>
                            </select>
                        </div>
                        <div class="wrap-input100">
                            <select form="raportare" name="prezenta" class="form-select input100 xd">
                                <?php $options = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
                                foreach($options as $o)
                                {                            
                                    if($o == $prezenta) $attr="selected='true'";
                                    else $attr = "";
                                    if($o != 1)
                                    {
                                        echo "<option value='{$o}' {$attr}>{$o} ore</option>";
                                    }
                                    else echo "<option value='{$o}' {$attr}>O oră</option>";
                                }?>
                            </select>
                        </div>

                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type = "submit" value = "Adaugă în listă" name="raporteaza">
                        </div>          
                    </form>

                    <table class="table table-striped cart" style="margin-top:2%;">

                        <thead>
                            <tr>
                                <th width="35%">Muncitor</th>
                                <th width="25%">Șantier</th>
                                <th width="25%">Ore de muncă</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if(!isset($_SESSION['listaMuncitori'])){
                                $_SESSION['listaMuncitori'] = array();
                            }
                            if(sizeof($_SESSION['listaMuncitori']) > 0)
                            {
                                $cevaid = 0;
                                foreach($_SESSION['listaMuncitori'] as $muncitor)
                                {?>
                                    <tr>
                                    <td style="padding-top:1.7%;"><?php echo $muncitor["nume"]; ?></td>
                                    <td style="padding-top:1.7%;"><?php echo $muncitor["santier"]; ?></td>
                                    <td style="padding-top:1.7%;"><?php echo $muncitor["ore"]; ?></td>
                                    <?php $xd = '&santier='.$muncitor["santier"].'&ore='.$muncitor["ore"]; ?>
                                    <td style="padding-top:1%;"><button class="btn btn-sm btn-danger" onclick="return confirm('Sigur dorești să elimini acest angajat din listă?')?window.location.href='php/listaAction.php?action=stergeMuncitor&cnt=<?php echo $cevaid.$xd ?>':false;" title="Șterge din listă"><i class="bi bi-x-lg"></i> </button> </td>
                                    <?php $cevaid ++; ?>
                                    </tr><?php 
                                } 
                            }
                            else
                            {
                                echo '<tr><td colspan="6"><p>Nu ai adăugat nici o persoană in listă...</p></td>';
                            } ?>
                        </tbody>
                    </table>
                        <?php if(sizeof($_SESSION['listaMuncitori']) > 0)
                        { ?>
                            <div class="row">
                                <div class="col"><a style="background-color:#5A5A5A;" href="php/listaAction.php?action=reseteaza" class="login100-form-btn">Resetează</a></div>
                                <div class="col"><a href="php/listaAction.php?action=trimiteLista" class="login100-form-btn">Trimite lista</a></div>
                            </div> <?php 
                        } ?>
                    <?php
                        MesajAfisare();
                        }
                        else
                        {
                            echo '<h4 class="alert alert-danger text-center">Nu există șantiere adăugate de către Administrator.</h4>';
                        }
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