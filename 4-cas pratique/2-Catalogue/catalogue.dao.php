<?php
require_once ('MonPDO.class.php');

function getCoursBD(){
    $pdo = MonPDO::getPDO();
    $req = "SELECT * FROM cours";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    return $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNomType($idType){
    $pdo = MonPDO::getPDO();
    $req = "SELECT libelle FROM type WHERE idType = :idType";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":idType", "$idType" ,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCoursNameToDeleteBD($idCours){
    $pdo = MonPDO::getPDO();
    $req = 'SELECT CONCAT(idCours, " : ", libelle) as monCours FROM cours WHERE idCours = :idCours';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":idCours", "$idCours" ,PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['monCours'];
}

function deleteCoursBD($idCours){
    $pdo = MonPDO::getPDO();
    $req = 'DELETE FROM cours WHERE idCours = :idCours';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":idCours", "$idCours" ,PDO::PARAM_INT);
    return $stmt->execute();

}