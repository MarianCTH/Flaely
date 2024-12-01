<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'flaelyco_conturi');
define('DB_PASSWORD', 'v@tm_us!iKS4');
define('DB_NAME', 'flaelyco_conturi');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$link->set_charset("utf8mb4");
if($link === false){
    die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
}
    function MesajAdaugare($text, $tip)
        {
            if(! isset($_SESSION['mesaje']))
                $_SESSION['mesaje'] = [];
            $mesaj = [
                'text' => $text ,
                'tip' => $tip
            ];
            $_SESSION['mesaje'][] = $mesaj;
        }

    function MesajAfisare()
    {
        if(! isset($_SESSION['mesaje']))
            return;
        ?>
        <div class="container py-3">
            <?php
            foreach($_SESSION['mesaje'] as $mesaj)
            {
                ?>
                    <div class="alert ms-auto alert-<?=$mesaj['tip']?>">
                        <?=htmlspecialchars($mesaj['text'])?>
                    </div>
                <?php
            }
            unset($_SESSION['mesaje']);
            ?>
        </div>
        <?php
    }
  
    function Merge()
    {
        echo "Merge";
    }
?>
