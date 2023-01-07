<?php ob_start(); //NE PAS MODIFIER 
$titre = "Un catalogue de produits"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
require_once ('catalogue.dao.php');
require_once ('gestionImage.php');

//VERIFICATION DE SUPPRESSION
if (isset($_GET['type']) && $_GET['type'] === "suppression"){
    $coursNameToDelete = getCoursNameToDeleteBD($_GET['idCours']);
?>
    <div class="alert alert-warning" role="alert">
        Voulez-vous vraiment <b class="text-danger">supprimer</b> l'élement <b><?= $coursNameToDelete ?></b> de la bd ?
        <a href="?delete=<?= $_GET['idCours'] ?>" class="btn btn-danger">Supprimer !</a>
        <a href="index.php" class="btn btn-success">Annuler !</a>
    </div>
<?php
}

//SUPPRESSION
if (isset($_GET['delete'])){
    $imageToDelete = getImageToDelete($_GET['delete']);
    deleteImage("source/",$imageToDelete);
    $success = deleteCoursBD($_GET['delete']);
    if ($success){ ?>
        <div class="alert alert-success" role="alert">
            la suppression s'est bien déroulée !
        </div>
    <?php } else{ ?>
        <div class="alert alert-danger" role="alert">
            la suppression n'a pas fonctionée !
        </div>
    <?php }
}

//MODIFICATION
if (isset($_POST['type']) && $_POST['type'] === "modificationEtape2"){
    $nomNouvelleImage = "";
    if($_FILES['imageCours']['name'] !== "") {
        $imageToDelete = getImageToDelete($_POST['idCours']);
        deleteImage("source/", $imageToDelete);
        $fileImage = $_FILES['imageCours'];
        $repertoire = "source/";
        try {
            $nomNouvelleImage = ajoutImage($fileImage, $repertoire, $_POST['nomCours']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    $success = modifierCoursBD($_POST['idCours'], $_POST['nomCours'], $_POST['descCours'], $_POST['idType'], $nomNouvelleImage);
    if ($success){ ?>
        <div class="alert alert-success" role="alert">
            la modification s'est bien déroulée !
        </div>
    <?php } else{ ?>
        <div class="alert alert-danger" role="alert">
            la modification n'a pas fonctionée !
        </div>
    <?php }
}

$cours = getCoursBD();
$types = getTypesBD();
?>
<a href="ajout.php" class="btn btn-primary">Ajout</a>

<div class="row no-gutters">
    <?php foreach($cours as $c) : ?>
        <div class="col-4">
            <div class="card m-2" style="">
                <?php if (!isset($_GET['type']) || $_GET['type'] !== 'modification' || $_GET['idCours'] !== $c['idCours']){ ?>
                <img src="source/<?= $c['image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $c['libelle'] ?></h5>
                    <p class="card-text"><?= $c['description'] ?></p>
                    <?php
                        $typeTxt = getNomType($c['idType']);
                    ?>
                    <span class='badge badge-primary'><?= $typeTxt['libelle'] ?></span>
                </div>
                <div class="row no-gutters p-2">
                    <form action="" method="get" class="col-6 text-center">
                        <input type="hidden" name="idCours" value="<?= $c['idCours'] ?>">
                        <input type="hidden" name="type" value="modification">
                        <input type="submit" value="modifier" class="btn btn-primary">
                    </form>
                    <form action="" method="get" class="col-6 text-center">
                        <input type="hidden" name="idCours" value="<?= $c['idCours'] ?>">
                        <input type="hidden" name="type" value="suppression">
                        <input type="submit" value="supprimer" class="btn btn-danger">
                    </form>
                </div>
                <?php  }else{ ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="modificationEtape2"/>
                        <input type="hidden" name="idCours" value="<?= $c['idCours'] ?>">
                        <img src="source/<?= $c['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Image du cours : </label>
                                <input type="file" class="form-control-file" name="imageCours">
                            </div>
                            <div class="form-group">
                                <label>Nom du cours : </label>
                                <input type="text" class="form-control" name="nomCours" value="<?= $c['libelle'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Description : </label>
                                <textarea name="descCours" rows="3" class="form-control"> <?= $c['description'] ?></textarea>
                            </div>
                            <select name="idType" class="form-control">
                                <?php foreach ($types as $type) { ?>
                                    <option value="<?= $type['idType'] ?>"
                                     <?= ($type['idType'] === $c['idType']) ? "selected" : "" ?>
                                    ><?= $type['libelle'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="row no-gutters p-2">
                            <div class="col text-center">
                                <input type="submit" value="Valider" class="btn btn-success">
                            </div>
                            <div class="col text-center">
                                <input type="submit" value="Annuler" onclick="cancelModification(event)" class="btn btn-danger">
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script src="monJS.js"></script>
<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
