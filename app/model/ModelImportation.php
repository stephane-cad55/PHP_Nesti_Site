<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelImportation
{

    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM importation";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Importation');
        } else {
            $array = [];
        }

        return $array;
    }
    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM importation where $parameter = '$value'";

        $result = $pdo->query($sql);
        if ($result) {

            $data = $result->fetch(PDO::FETCH_ASSOC);
        } else {

            $data = [];
        }

        $importation = new Importation();
        $importation->setImportationFromArray($data);

        return $importation;
    }
    public function findChild($type, $value)
    {
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM $type WHERE id" . ucfirst($type) . "= $value";

        $result = $pdo->query($sql);
        $data = $result->fetch();
        return $data;
    }
}
