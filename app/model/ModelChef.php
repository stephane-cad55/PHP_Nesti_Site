<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelChef
{

    public static function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * from Chef";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Chef');
        } else {
            $array = [];
        }
        return $array;
    }

    public function insertChef(Chef &$idChef)
    {
        $pdo = Connection::getPdo();
        try {
            // Create prepared statement
            $sql = "INSERT INTO chef (idChef) VALUES (?)";

            $stmt = $pdo->prepare($sql);

            $values = [$idChef->getIdChef()];
            // Execute the prepared statement
            $stmt->execute($values);

            echo "Records insert Chef inserted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        unset($pdo);
    }
}
