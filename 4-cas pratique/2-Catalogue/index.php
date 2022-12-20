<?php ob_start(); //NE PAS MODIFIER 
$titre = "Un catalogue de produits"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
require_once ('MonPDO.class.php');
$pdo = MonPDO::getPDO();

$req = "SELECT * FROM cours";
$stmt = $pdo->prepare($req);
$stmt->execute();
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row no-gutters">
    <?php foreach($cours as $c) : ?>
        <div class="col-4">
            <div class="card m-2" style="">
                <img src="source/<?= $c['image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $c['libelle'] ?></h5>
                    <p class="card-text"><?= $c['description'] ?></p>
                    <?php 
                    $req2 = "SELECT libelle FROM type WHERE idType = :idType";
                    $stmt = $pdo->prepare($req2);
                    $stmt->bindValue(":idType", $c['idType'],PDO::PARAM_INT);
                    $stmt->execute();
                    $typeTxt = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                    <span class='badge badge-primary'><?= $typeTxt['libelle'] ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
