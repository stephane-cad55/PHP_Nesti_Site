<?php
include_once(PATH_MODEL . 'Connection.php');
class ModelArticleprice
{

    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM articleprice";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Articleprice');
        } else {
            $array = [];
        }

        return $array;
    }

    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM articleprice where $parameter = '$value'";

        $result = $pdo->query($sql);
        //var_dump($result);
        if ($result) {

            $data = $result->fetch(PDO::FETCH_ASSOC);
        } else {

            $data = [];
        }
        $articleprice = new Articleprice();
        $articleprice->setArticlepriceFromArray($data);
       
        return $articleprice;
    }

    public function findChild($type, $value)
    {
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM $type WHERE id" . ucfirst($type) . "= $value";
        $result = $pdo->query($sql);
        $data = $result->fetch();
        return $data;
    }
    public function readAllBy($parameter, $value)
    {
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM articleprice where $parameter = '$value'";
        $result = $pdo->query($sql);
       
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Articleprice');
           
        } else {
            $array = [];
        }
       
        return $array;
    }
}
