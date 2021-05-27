<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelArticles
{

    public static function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM article";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Articles');
        } else {
            $array = [];
        }
        return $array;
    }

    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM article where $parameter = '$value'";
        $result = $pdo->query($sql);
        if ($result) {

            $data = $result->fetch(PDO::FETCH_ASSOC);
        } else {

            $data = [];
        }

        $user = new Articles();
        $user->setArticleFromArray($data);
        return $user;
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
