<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelUnit
{
    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM unit ";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Unit');
        } else {
            $array = [];
        }
        return $array;
    }

    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM unit where $parameter = '$value'";

        $result = $pdo->query($sql);
       
        $data = $result->fetch(PDO::FETCH_ASSOC);
       
        if ($data) {
            $unit = new Unit();
            $unit->setUnitFromArray($data);
        } else {

            $unit = [];
        }
        return $unit;
    }

    public function findChild($type, $value)
    {
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM $type WHERE id" . ucfirst($type) . "= $value";

        $result = $pdo->query($sql);
        $data = $result->fetch();
        return $data;
    }

    /**requete insertion unité ingredient supplementaire
     */
    public function createUnit($unit)
    {
        $pdo = Connection::getPdo();
        try {
            // Create prepared statement
            $sql = "INSERT INTO unit (name) VALUES (?)";

            $stmt = $pdo->prepare($sql);

            $values = [$unit];
            // Execute the prepared statement
            $success = $stmt->execute($values);
            $newUnit = $this->readOneBy("idUnit", $pdo->lastInsertId());
            echo "Records inserted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        return $newUnit;
    }
}
