<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelProduct
{

    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM product ";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Product');
        } else {
            $array = [];
        }

        return $array;
    }
    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM product where $parameter = '$value'";

        $result = $pdo->query($sql);
        if ($result) {

            $data = $result->fetch(PDO::FETCH_ASSOC);
        } else {

            $data = [];
        }
        $user = new Product();
        $user->setProductFromArray($data);

        return $user;
    }
    public function findChildType($table, $type, $value)
    {
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM $table WHERE id" . ucfirst($type) . "= $value";

        $result = $pdo->query($sql);
        $data = $result->fetch();
        return $data;
    }
}
