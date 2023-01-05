<?php ob_start(); //NE PAS MODIFIER
$titre = "Page d'ajout d'un produit"; //Mettre le nom du titre de la page que vous voulez
?>

    <!-- mettre ici le code -->
<?php
require_once ('catalogue.dao.php');

if (isset($_POST['libelle'])){
    $success = ajoutCoursBD($_POST['libelle'], $_POST['description'], $_POST['idType'], "nomCours.png");
    if ($success){ ?>
        <div class="alert alert-success" role="alert">
            l'ajout s'est bien déroulé !
        </div>
    <?php } else{ ?>
        <div class="alert alert-danger" role="alert">
            l'ajout' n'a pas fonctioné !
        </div>
    <?php }
}
$types = getTypesBD();
?>

<form method="post" action="">
    <div class="form-group">
        <label>Nom : </label>
        <input type="text" class="form-control" name="libelle" placeholder="Nom du cours" required>
    </div>
    <div class="form-group">
        <label>Description : </label>
        <textarea class="form-control" name="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
    <label>Type de cours : </label>
    <select name="idType" class="form-control">
        <?php foreach ($types as $type) { ?>
            <option value="<?= $type['idType'] ?>"><?= $type['libelle'] ?></option>
        <?php } ?>
    </select>
    </div>
    <div class="form-group">
        <label>Image du cours : </label>
        <input type="file" class="form-control-file" name="imageCours">
    </div>
    <input type="submit" class="btn btn-primary" value="Valider">
</form>

<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
$content = ob_get_clean();
require "../../global/common/template.php";
?>



